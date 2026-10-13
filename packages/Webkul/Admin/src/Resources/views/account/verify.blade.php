<x-admin::layouts.anonymous>
    <x-slot:title>
        @lang('admin::app.users.verify.title')
    </x-slot>

    <div class="flex h-[100vh] items-center justify-center px-4">
        <div class="flex w-full max-w-[420px] flex-col items-center gap-6">
            @php
                $adminLogo = core()->getConfigData('general.design.admin_logo.logo_image');
                $adminLogoUrl = ($adminLogo && file_exists(public_path('storage/' . $adminLogo)))
                    ? asset('storage/' . $adminLogo)
                    : (file_exists(public_path('logo.png')) ? asset('logo.png') : ($adminLogo ? Storage::url($adminLogo) : bagisto_asset('images/logo.png')));
            @endphp

            <!-- Logo -->
            <img
                class="h-10 w-auto object-contain max-w-[200px]"
                src="{{ $adminLogoUrl }}"
                alt="{{ config('app.name') }}"
            />

            <!-- Card -->
            <div class="box-shadow w-full overflow-hidden rounded-xl bg-white">
                <!-- Header -->
                <div class="flex flex-col items-center gap-2 px-8 pt-8 text-center">
                    <!-- Lock Badge -->
                    <div class="mb-2 flex h-14 w-14 items-center justify-center rounded-full bg-[#133b63]/10">
                        <i class="fa-solid fa-lock text-2xl text-[#133b63]"></i>
                    </div>

                    <p class="text-xl font-bold text-gray-800">
                        @lang('admin::app.users.verify.title')
                    </p>

                    <p class="text-sm leading-relaxed text-gray-500">
                        @lang('admin::app.users.verify.enter-code')
                    </p>
                </div>

                <!-- Verification Form -->
                <x-admin::form
                    :action="route('admin.two_factor.verify.store')"
                    method="POST"
                    class="w-full"
                >
                    <div class="px-8 py-6">
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required !text-xs !font-semibold !uppercase !tracking-wide !text-gray-500">
                                @lang('admin::app.users.verify.code-label')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                class="text-center font-semibold !py-3 !text-xl !tracking-[0.35em] placeholder:!tracking-normal placeholder:text-base placeholder:font-normal"
                                id="code"
                                name="code"
                                rules="required|numeric|digits:6"
                                inputmode="numeric"
                                maxlength="6"
                                autocomplete="one-time-code"
                                autofocus
                                :label="trans('admin::app.users.verify.code-label')"
                                :placeholder="trans('admin::app.users.verify.code-placeholder')"
                            />

                            <x-admin::form.control-group.error control-name="code" />
                        </x-admin::form.control-group>

                        <!-- Verify Button -->
                        <button
                            type="submit"
                            class="primary-button mt-2 w-full !justify-center !py-2.5 text-base"
                            aria-label="@lang('admin::app.users.verify.verify-code')"
                        >
                            @lang('admin::app.users.verify.verify-code')
                        </button>
                    </div>
                </x-admin::form>

                <!-- Back / Logout -->
                <div class="border-t px-8 py-4 text-center">
                    <x-admin::form
                        method="DELETE"
                        action="{{ route('admin.session.destroy') }}"
                        id="adminLogout"
                    >
                    </x-admin::form>

                    <button
                        type="button"
                        class="text-sm font-medium text-gray-500 transition-all hover:text-[#133b63]"
                        onclick="event.preventDefault(); document.getElementById('adminLogout').submit();"
                    >
                        @lang('admin::app.users.verify.back')
                    </button>
                </div>
            </div>

            <!-- Powered By -->
            <div class="text-sm font-normal">
                @lang('admin::app.users.sessions.powered-by-description', [
                    'bagisto' => '<a class="text-[#133b63] hover:underline" href="https://bagisto.com/en/">Bagisto</a>',
                    'webkul' => '<a class="text-[#133b63] hover:underline" href="https://webkul.com/">Webkul</a>',
                ])
            </div>
        </div>
    </div>
</x-admin::layouts.anonymous>
