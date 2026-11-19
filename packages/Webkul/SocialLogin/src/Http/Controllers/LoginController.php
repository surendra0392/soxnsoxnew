<?php

namespace Webkul\SocialLogin\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Event;
use Laravel\Socialite\Facades\Socialite;
use Webkul\SocialLogin\Repositories\CustomerSocialAccountRepository;

class LoginController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected CustomerSocialAccountRepository $customerSocialAccountRepository) {}

    /**
     * Redirects to the social provider
     *
     * @param  string  $provider
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->redirect('shop.customers.account.profile.index');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());

            return redirect()->route('shop.customer.session.index');
        }
    }

    /**
     * Handles callback
     *
     * @param  string  $provider
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('shop.customer.session.index');
        }

        $customer = $this->customerSocialAccountRepository->findOrCreateCustomer($user, $provider);

        if (! $customer) {
            session()->flash('error', trans('shop::app.customers.login-form.invalid-credentials'));

            return redirect()->route('shop.customer.session.index');
        }

        if (! $customer->status) {
            session()->flash('warning', trans('shop::app.customers.login-form.not-activated'));

            return redirect()->route('shop.customer.session.index');
        }

        if ($customer->is_suspended) {
            session()->flash('warning', trans('shop::app.checkout.cart.suspended-account-message'));

            return redirect()->route('shop.customer.session.index');
        }

        auth()->guard('customer')->login($customer, true);

        request()->session()->regenerate();

        Event::dispatch('customer.after.login', $customer);

        return redirect()->intended(route('shop.customers.account.profile.index'));
    }
}
