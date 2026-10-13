<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.reset-password.title') — {{ config('app.name', 'SOXNSOX') }}
    </x-slot>

    @push('styles')
    <style>
        .nature-card-bg {
            background-color: #E7EFEA;
            background-image: 
                radial-gradient(at 15% 20%, rgba(195, 231, 201, 0.4) 0px, transparent 50%),
                radial-gradient(at 85% 80%, rgba(30, 107, 92, 0.08) 0px, transparent 50%);
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .auth-container-card {
            background: #1E6B5C;
            border-radius: 32px;
            box-shadow: 0 30px 70px -15px rgba(15, 45, 35, 0.22), 0 0 0 1px rgba(255, 255, 255, 0.08);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .nature-illustration-panel {
            background: linear-gradient(180deg, #E6F7EF 0%, #D0F0E0 35%, #B3E5CD 70%, #9BDCBE 100%);
            position: relative;
            overflow: hidden;
        }

        .soxnsox-pill-input-simple {
            width: 100% !important;
            height: 48px !important;
            border-radius: 9999px !important;
            border: 1.5px solid rgba(195, 231, 201, 0.45) !important;
            background-color: rgba(20, 80, 68, 0.55) !important;
            padding-left: 1.5rem !important;
            padding-right: 1.5rem !important;
            font-size: 0.9375rem !important;
            color: #f5f7fa !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .soxnsox-pill-input-simple::placeholder {
            color: rgba(212, 244, 220, 0.45) !important;
        }

        .soxnsox-pill-input-simple:focus {
            border-color: #C3E7C9 !important;
            background-color: rgba(16, 68, 58, 0.85) !important;
            box-shadow: 0 0 0 4px rgba(195, 231, 201, 0.22) !important;
            outline: none !important;
        }

        .soxnsox-mint-btn {
            background: linear-gradient(135deg, #D8F6DF 0%, #AEE6BD 100%);
            color: #124B3F;
            font-weight: 700;
            border-radius: 9999px;
            box-shadow: 0 10px 24px -4px rgba(174, 230, 189, 0.45);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
        }

        .soxnsox-mint-btn:hover {
            background: linear-gradient(135deg, #E6FAEC 0%, #BFF0CC 100%);
            transform: translateY(-1px);
            box-shadow: 0 14px 28px -4px rgba(174, 230, 189, 0.6);
        }
    </style>
    @endpush

    <div class="min-h-screen nature-card-bg flex items-center justify-center p-3 sm:p-6 lg:p-10">
        
        <!-- Main Floating Auth Card -->
        <div class="auth-container-card w-full max-w-[1040px] grid grid-cols-1 lg:grid-cols-12">
            
            <!-- Left Side: Nature Landscape with "RESET" & Deer -->
            <div class="nature-illustration-panel lg:col-span-6 relative flex flex-col justify-between min-h-[380px] lg:min-h-[580px] p-6 sm:p-10">
                
                <div class="relative z-10 text-center pt-4 sm:pt-6">
                    <h2 class="text-xl sm:text-2xl font-bold tracking-[0.38em] text-[#3D7A68] uppercase font-sans select-none">
                        S E C U R I T Y
                    </h2>
                </div>

                <!-- Forest & Deer Artwork -->
                <div class="absolute inset-0 pointer-events-none z-0">
                    <svg class="w-full h-full object-cover" viewBox="0 0 520 620" preserveAspectRatio="xMidYMax slice" fill="none">
                        <rect width="520" height="620" fill="#D4F0E2"/>
                        <path d="M-20 310 Q140 260 300 290 Q440 320 540 260 L540 620 L-20 620 Z" fill="#88C8AB" opacity="0.8"/>
                        <path d="M-20 350 Q160 300 320 370 Q430 420 540 360 L540 620 L-20 620 Z" fill="#519F81"/>
                        <path d="M-20 450 Q100 420 260 520 Q360 580 540 540 L540 620 L-20 620 Z" fill="#113F34"/>
                        <!-- Silhouette Stag -->
                        <g fill="#0B2620" transform="translate(160, 410) scale(0.9)">
                            <ellipse cx="45" cy="85" rx="30" ry="18"/>
                            <rect x="25" y="95" width="4" height="40" rx="2"/>
                            <rect x="33" y="95" width="4" height="38" rx="2"/>
                            <path d="M60 95 Q68 110 65 135 L61 135 Q63 110 56 95 Z"/>
                            <path d="M25 80 Q18 60 22 45 Q26 40 30 42 Q32 55 35 75 Z"/>
                            <circle cx="24" cy="42" r="6"/>
                            <path d="M22 38 Q18 20 12 10 Q10 7 8 8 Q12 18 16 36 Z"/>
                            <path d="M25 38 Q30 18 36 6 Q39 4 38 6 Q32 18 27 36 Z"/>
                        </g>
                    </svg>
                </div>

                <div class="relative z-10 flex items-center justify-start">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#0A241E]/80 border border-[#43A08C]/50 text-xs font-semibold text-[#D4F4DC] shadow-md backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-[#4EBA88] animate-pulse"></span>
                        <span class="tracking-wide text-[11px] sm:text-xs">SOXNSOX Security Reset</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Deep Forest Teal Reset Password Form -->
            <div class="lg:col-span-6 p-6 sm:p-10 lg:p-12 flex flex-col justify-between relative bg-[#1E6B5C]">
                
                <!-- Top Utility Bar -->
                <div class="flex items-center justify-between pb-4">
                    <a href="{{ route('shop.home.index') }}" class="font-serif text-2xl font-bold text-white tracking-wide">
                        Soxnsox
                    </a>

                    <a 
                        href="{{ route('admin.session.create') }}"
                        class="text-xs font-semibold text-[#D4F4DC] hover:text-white transition-colors inline-flex items-center gap-1.5"
                    >
                        <i class="fa-solid fa-chevron-left text-xs"></i>
                        <span>Back to Sign In</span>
                    </a>
                </div>

                <!-- Center Greetings & Form -->
                <div class="my-auto py-4 space-y-5">
                    
                    <div class="space-y-1.5">
                        <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">
                            @lang('admin::app.users.reset-password.title')
                        </h1>
                        <p class="text-sm text-[#D4F4DC] font-normal leading-relaxed">
                            Create a strong, new password for your administrative credentials.
                        </p>
                    </div>

                    <!-- Reset Password Form -->
                    <x-admin::form :action="route('admin.reset_password.store')" class="space-y-4">
                        
                        <x-admin::form.control-group.control
                            type="hidden"
                            name="token"
                            :value="$token"       
                        />

                        <!-- Email -->
                        <x-admin::form.control-group class="space-y-1.5">
                            <x-admin::form.control-group.label class="required text-xs font-medium text-[#E1F4EC] tracking-wide">
                                @lang('admin::app.users.reset-password.email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="email"
                                class="soxnsox-pill-input-simple" 
                                id="email"
                                name="email" 
                                rules="required|email" 
                                :label="trans('admin::app.users.reset-password.email')"
                                placeholder="name@soxnsox.com"
                                :value="old('email')"
                            />

                            <x-admin::form.control-group.error control-name="email" class="text-xs text-[#FFB4A2] mt-1 pl-4" />
                        </x-admin::form.control-group>
                        
                        <!-- Password -->
                        <x-admin::form.control-group class="space-y-1.5">
                            <x-admin::form.control-group.label class="required text-xs font-medium text-[#E1F4EC] tracking-wide">
                                @lang('admin::app.users.reset-password.password')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="password"
                                class="soxnsox-pill-input-simple" 
                                id="password"
                                name="password" 
                                rules="required|min:6" 
                                :label="trans('admin::app.users.reset-password.password')"
                                placeholder="••••••••"
                                ref="password"
                            />

                            <x-admin::form.control-group.error control-name="password" class="text-xs text-[#FFB4A2] mt-1 pl-4" />
                        </x-admin::form.control-group>

                        <!-- Confirm Password -->
                        <x-admin::form.control-group class="space-y-1.5">
                            <x-admin::form.control-group.label class="required text-xs font-medium text-[#E1F4EC] tracking-wide">
                                @lang('admin::app.users.reset-password.confirm-password')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="password"
                                class="soxnsox-pill-input-simple" 
                                id="password_confirmation"
                                name="password_confirmation"
                                rules="confirmed:@password" 
                                :label="trans('admin::app.users.reset-password.confirm-password')"
                                placeholder="••••••••"
                                ref="password"
                            />

                            <x-admin::form.control-group.error control-name="password_confirmation" class="text-xs text-[#FFB4A2] mt-1 pl-4" />
                        </x-admin::form.control-group>

                        <!-- Submit Button -->
                        <div class="pt-3">
                            <button
                                type="submit"
                                class="soxnsox-mint-btn h-12 w-full text-xs uppercase tracking-widest font-bold flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <span>@lang('admin::app.users.reset-password.submit-btn')</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </button>
                        </div>
                    </x-admin::form>
                </div>

                <!-- Bottom Security Encryption Notice -->
                <div class="pt-4 text-center text-xs text-white/50 space-y-1">
                    <div class="inline-flex items-center gap-1.5 justify-center">
                        <i class="fa-solid fa-shield-halved text-[#B8E3BF] text-xs"></i>
                        <span>Protected by Argon2id Salted Hash Key Protocol</span>
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-admin::layouts.anonymous>