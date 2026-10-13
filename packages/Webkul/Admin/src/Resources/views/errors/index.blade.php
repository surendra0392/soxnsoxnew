<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang("admin::app.errors.{$errorCode}.title")
    </x-slot>

    <!-- Error page Information -->
	<div class="flex h-[100vh] items-center justify-center bg-white">
        <div class="flex max-w-[745px] items-center gap-5">
            <div class="w-full">
                @php
                    $adminLogo = core()->getConfigData('general.design.admin_logo.logo_image');
                    $logoUrl = ($adminLogo && file_exists(public_path('storage/' . $adminLogo)))
                        ? asset('storage/' . $adminLogo)
                        : (file_exists(public_path('logo.png')) ? asset('logo.png') : ($adminLogo ? Storage::url($adminLogo) : bagisto_asset('images/logo.png')));
                @endphp

                <img
                    class="mb-6 h-10"
                    src="{{ $logoUrl }}"
                    id="logo-image"
                    alt="{{ config('app.name') }}"
                />

				<div class="text-[38px] font-bold text-gray-800">
                    {{ $errorCode }}
                </div>

                <p class="mb-6 text-sm text-gray-800">
                    @lang("admin::app.errors.{$errorCode}.description")
                </p>

                <div class="mb-6">
                    <div class="flex items-center gap-2.5">
                        <a
                            onclick="history.back()"
                            class="text-sm font-semibold text-[#133b63] transition-all hover:underline"
                        >
                            @lang('admin::app.errors.go-back')
                        </a>

                        <i class="fa-solid fa-circle text-[5px] text-gray-400"></i>

                        <a
                            href="{{ route('admin.dashboard.index') }}"
                            class="text-sm font-semibold text-[#133b63] transition-all hover:underline"
                        >
                            @lang('admin::app.errors.dashboard')
                        </a>
                    </div>
                </div>

                <p class="text-sm text-gray-800">
                    @lang('admin::app.errors.support', [
                        'link'  => 'mailto:' . (core()->getAdminEmailDetails()['email'] ?? 'support@example.com'),
                        'email' => core()->getAdminEmailDetails()['email'] ?? 'support@example.com',
                        'class' => 'font-semibold text-[#133b63] transition-all hover:underline',
                    ])
                </p>
            </div>

            <div class="w-full">
                <img src="{{ bagisto_asset('images/error.svg') }}" />
            </div>
        </div>
	</div>
</x-admin::layouts.anonymous>