<?php

namespace Webkul\Admin\Http\Controllers\User;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;

class ForgetPasswordController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        if (auth()->guard('admin')->check()) {
            return redirect()->route('admin.dashboard.index');
        } else {
            $previousUrl = url()->previous();
            $previousHost = parse_url($previousUrl, PHP_URL_HOST);

            if ($previousHost === request()->getHost() && str_contains($previousUrl, config('app.admin_url'))) {
                $intendedUrl = $previousUrl;
            } else {
                $intendedUrl = route('admin.dashboard.index');
            }

            session()->put('url.intended', $intendedUrl);

            return view('admin::users.forget-password.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        try {
            $this->validate(request(), [
                'email' => 'required|email',
            ]);

            $response = $this->broker()->sendResetLink(
                request(['email'])
            );

            if ($response == Password::RESET_THROTTLED) {
                session()->flash('warning', trans('admin::app.users.forget-password.create.already-sent', ['default' => 'Password reset link already sent. Please check your email.']));

                return redirect()->route('admin.forget_password.create');
            }

            session()->flash('success', trans('admin::app.users.forget-password.create.reset-link-sent'));

            return redirect()->route('admin.forget_password.create');
        } catch (\Exception $e) {
            report($e);

            session()->flash('error', trans('admin::app.users.forget-password.create.error', ['default' => 'Something went wrong, please try again later.']));

            return redirect()->back();
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }
}
