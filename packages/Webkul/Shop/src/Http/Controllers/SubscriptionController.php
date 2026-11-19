<?php

namespace Webkul\Shop\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Webkul\Core\Repositories\SubscribersListRepository;

class SubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected SubscribersListRepository $subscriptionRepository) {}

    /**
     * Subscribes email to the email subscription list.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $this->validate(request(), [
            'email' => ['required', 'email'],
        ]);

        $email = request()->input('email');

        Event::dispatch('customer.subscription.before');

        if ($this->isAlreadySubscribed($email)) {
            session()->flash('error', trans('shop::app.subscription.already'));

            return redirect()->back();
        }

        $subscription = $this->upsertSubscription($email);

        $this->syncCustomerNewsletterFlag();

        Event::dispatch('customer.subscription.after', $subscription);

        session()->flash('success', trans('shop::app.subscription.subscribe-success'));

        return redirect()->back();
    }

    /**
     * Display unsubscribe confirmation page.
     *
     * @param  string  $token
     * @return View|RedirectResponse
     */
    public function unsubscribe($token)
    {
        $subscription = $this->subscriptionRepository->findOneWhere(['token' => $token]);

        if (! $subscription) {
            session()->flash('info', trans('shop::app.subscription.unsubscribe-success'));

            return redirect()->route('shop.home.index');
        }

        return view('shop::subscription.unsubscribe', compact('subscription'));
    }

    /**
     * To unsubscribe from the subscription list.
     *
     * @param  string  $token
     * @return RedirectResponse
     */
    public function destroy($token)
    {
        $subscription = $this->subscriptionRepository->findOneWhere(['token' => $token]);

        if ($subscription) {
            if ($subscription->customer) {
                $subscription->customer->update(['subscribed_to_news_letter' => 0]);
            }

            $subscription->delete();
        }

        session()->flash('success', trans('shop::app.subscription.unsubscribe-success'));

        return redirect()->route('shop.home.index');
    }

    /**
     * Check if the given email is already subscribed to the newsletter. This method checks the subscription repository
     * for an existing record with the given email and subscription status.
     */
    private function isAlreadySubscribed(string $email): bool
    {
        return (bool) $this->subscriptionRepository->findOneWhere([
            'email' => $email,
            'is_subscribed' => 1,
        ]);
    }

    /**
     * Upsert the subscription record for the given email. If a record already exists for the email, it will be updated
     * with the new subscription details. Otherwise, a new record will be created.
     */
    private function upsertSubscription(string $email): mixed
    {
        $customer = auth()->guard('customer')->user();

        $payload = [
            'is_subscribed' => 1,
            'token' => Str::random(60),
            'customer_id' => $customer?->id,
        ];

        $existing = $this->subscriptionRepository->findOneByField('email', $email);

        if ($existing) {
            $existing->update($payload);

            return $existing;
        }

        return $this->subscriptionRepository->create(array_merge($payload, [
            'email' => $email,
            'channel_id' => core()->getCurrentChannel()->id,
        ]));
    }

    /**
     * Sync the newsletter subscription flag for the customer if they are logged in and subscribing to the newsletter.
     */
    private function syncCustomerNewsletterFlag(): void
    {
        $customer = auth()->guard('customer')->user();

        if (! $customer) {
            return;
        }

        $customer->update(['subscribed_to_news_letter' => 1]);
    }
}
