@php
    $enabledSocials = [];
    foreach ([
        'enable_google' => 'google',
        'enable_facebook' => 'facebook',
        'enable_twitter' => 'twitter',
        'enable_github' => 'github',
        'enable_linkedin-openid' => 'linkedin-openid'
    ] as $key => $provider) {
        if (core()->getConfigData('customer.settings.social_login.' . $key)) {
            $enabledSocials[] = $provider;
        }
    }
@endphp

@if (! empty($enabledSocials))
    <div class="mt-6 pt-1">
        <!-- Modern Divider -->
        <div class="relative my-4 flex items-center justify-center">
            <div class="w-full border-t border-slate-200"></div>
            <span class="absolute bg-white px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400 select-none">
                Or continue with
            </span>
        </div>

        <!-- Social Buttons Container -->
        <div class="flex items-center justify-center gap-3.5 pt-2">
            @foreach ($enabledSocials as $provider)
                <a
                    href="{{ route('customer.social-login.index', $provider) }}"
                    class="transition-all duration-200 hover:scale-105 active:scale-95 inline-flex"
                    aria-label="Sign in with {{ ucfirst($provider) }}"
                    title="Sign in with {{ ucfirst($provider) }}"
                >
                    @include('social_login::icons.' . $provider)
                </a>
            @endforeach
        </div>
    </div>
@endif