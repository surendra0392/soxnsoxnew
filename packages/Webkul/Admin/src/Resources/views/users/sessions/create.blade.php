<x-admin::layouts.anonymous>
    <!-- Page Title -->
    <x-slot:title>
        @lang('admin::app.users.sessions.title') — {{ config('app.name', 'SOXNSOX') }}
    </x-slot>

    @push('styles')
    <style>
        .brand-canvas {
            background-color: #f5f7fa;
            background-image: radial-gradient(#cbd5e1 1.2px, transparent 1.2px);
            background-size: 24px 24px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .auth-split-wrapper {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 980px;
            min-height: 580px;
            border-radius: 28px;
            overflow: hidden;
            background-color: #133b63;
            box-shadow: 0 30px 70px -15px rgba(19, 59, 99, 0.45), 0 0 0 1px rgba(44, 167, 163, 0.25);
        }

        @media (min-width: 900px) {
            .auth-split-wrapper {
                flex-direction: row;
                height: 580px;
                border-radius: 36px;
            }
            .brand-left-panel {
                width: 46% !important;
                height: 100% !important;
            }
            .form-right-panel {
                width: 54% !important;
                height: 100% !important;
                padding: 3.25rem 3.75rem !important;
            }
        }

        .brand-left-panel {
            position: relative;
            width: 100%;
            min-height: 280px;
            background: linear-gradient(145deg, #0d2847 0%, #133b63 50%, #1d5b8f 100%);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.75rem 2.5rem;
            box-sizing: border-box;
            color: #ffffff;
        }

        .wave-separator {
            display: none;
        }

        @media (min-width: 900px) {
            .wave-separator {
                display: block;
                position: absolute;
                right: -1px;
                top: 0;
                bottom: 0;
                width: 65px;
                height: 100%;
                z-index: 10;
                pointer-events: none;
            }
        }

        .form-right-panel {
            position: relative;
            width: 100%;
            background-color: #133b63;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-sizing: border-box;
            color: #f8fafc;
        }

        .soxnsox-auth-input {
            width: 100% !important;
            height: 48px !important;
            border-radius: 9999px !important;
            border: 1.5px solid rgba(44, 167, 163, 0.35) !important;
            background-color: rgba(13, 40, 71, 0.7) !important;
            padding-left: 1.35rem !important;
            padding-right: 1.35rem !important;
            font-size: 0.875rem !important;
            color: #ffffff !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
            box-sizing: border-box !important;
        }

        .soxnsox-password-container {
            position: relative !important;
            width: 100% !important;
            display: block !important;
        }

        .soxnsox-password-container input {
            padding-right: 3.25rem !important;
        }

        .soxnsox-password-toggle-btn {
            position: absolute !important;
            top: 50% !important;
            right: 1.15rem !important;
            transform: translateY(-50%) !important;
            z-index: 30 !important;
            background: transparent !important;
            border: none !important;
            cursor: pointer !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #f29a38 !important;
            padding: 0.25rem !important;
            transition: color 0.15s ease !important;
        }

        .soxnsox-password-toggle-btn:hover {
            color: #ffffff !important;
        }

        .soxnsox-auth-input::placeholder {
            color: rgba(248, 250, 252, 0.45) !important;
        }

        .soxnsox-auth-input:focus {
            border-color: #2ca7a3 !important;
            background-color: rgba(13, 40, 71, 0.95) !important;
            box-shadow: 0 0 0 3px rgba(44, 167, 163, 0.25) !important;
            outline: none !important;
        }

        .soxnsox-submit-btn {
            background: linear-gradient(135deg, #f29a38 0%, #e08320 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.9375rem;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            border-radius: 9999px;
            height: 48px;
            width: 100%;
            box-shadow: 0 8px 24px -3px rgba(242, 154, 56, 0.45);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .soxnsox-submit-btn:hover {
            background: linear-gradient(135deg, #f5a74e 0%, #f29a38 100%);
            transform: translateY(-1px);
            box-shadow: 0 14px 28px -3px rgba(242, 154, 56, 0.6);
        }

        .soxnsox-submit-btn:active {
            transform: translateY(0);
        }

        .soxnsox-status-badge {
            display: inline-flex !important;
            align-items: center !important;
            gap: 0.5rem !important;
            padding: 0.35rem 0.85rem !important;
            border-radius: 9999px !important;
            background: rgba(255, 255, 255, 0.12) !important;
            backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            letter-spacing: 0.02em !important;
        }

        .soxnsox-status-badge-dot {
            width: 7px !important;
            height: 7px !important;
            border-radius: 9999px !important;
            background-color: #2ca7a3 !important;
            box-shadow: 0 0 8px #2ca7a3 !important;
        }

        .feature-list {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.75rem !important;
            margin: 1.5rem 0 !important;
            position: relative !important;
            z-index: 20 !important;
        }

        .feature-pill {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.95rem;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            font-size: 0.8125rem;
            font-weight: 500;
            color: #e2e8f0;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(8px);
        }

        .feature-pill:hover {
            background: rgba(255, 255, 255, 0.14);
            border-color: rgba(44, 167, 163, 0.45);
            transform: translateX(4px);
        }
    </style>
    @endpush

    <div class="brand-canvas">
        
        <!-- Main Floating Auth Container -->
        <div class="auth-split-wrapper">
            
            <!-- Left Side: Modern SOX N SOX Showcase -->
            <div class="brand-left-panel">
                
                <!-- Ambient Glowing Orbs -->
                <div class="absolute -top-24 -left-24 w-72 h-72 rounded-full bg-[#2ca7a3]/20 blur-3xl pointer-events-none"></div>
                <div class="absolute -bottom-24 -right-24 w-72 h-72 rounded-full bg-[#f29a38]/15 blur-3xl pointer-events-none"></div>

                <!-- Brand Header -->
                <div class="relative z-20">
                    <div class="flex items-center">
                        <img
                            src="{{ file_exists(public_path('logo-white.png')) ? asset('logo-white.png') : asset('logo.png') }}"
                            alt="SOX N SOX"
                            class="h-10 sm:h-11 w-auto object-contain max-w-[210px]"
                        />
                    </div>

                    <div class="mt-6">
                        <h2 class="text-2xl font-bold text-white tracking-tight leading-tight">
                            Engineered for Daily Comfort & Wellness
                        </h2>
                        <p class="mt-2 text-xs text-slate-300 leading-relaxed">
                            India's premier certified bamboo and diabetic health socks commerce platform.
                        </p>
                    </div>
                </div>

                <!-- Feature Highlights -->
                <div class="feature-list">
                    <div class="feature-pill">
                        <div class="w-7 h-7 rounded-lg bg-[#2ca7a3]/20 flex items-center justify-center text-[#2ca7a3] flex-shrink-0">
                            <i class="fa-solid fa-seedling text-sm text-[#2ca7a3]"></i>
                        </div>
                        <span>100% Certified Bamboo Fibers</span>
                    </div>

                    <div class="feature-pill">
                        <div class="w-7 h-7 rounded-lg bg-[#f29a38]/20 flex items-center justify-center text-[#f29a38] flex-shrink-0">
                            <i class="fa-solid fa-heart-pulse text-sm text-[#f29a38]"></i>
                        </div>
                        <span>Diabetic Non-Binding Comfort Cuff</span>
                    </div>

                    <div class="feature-pill">
                        <div class="w-7 h-7 rounded-lg bg-[#2ca7a3]/20 flex items-center justify-center text-[#2ca7a3] flex-shrink-0">
                            <i class="fa-solid fa-shield-halved text-sm text-[#2ca7a3]"></i>
                        </div>
                        <span>Seamless Toe Blister Defense</span>
                    </div>
                </div>

                <!-- S-Curve Wave Separator on Right Edge -->
                <svg class="wave-separator" viewBox="0 0 65 600" preserveAspectRatio="none" fill="#133b63">
                    <path d="M65,0 C15,120 0,230 45,340 C75,420 20,530 65,600 L65,0 Z"/>
                </svg>

                <!-- Bottom Status Badge -->
                <div class="relative z-20 flex items-center justify-start">
                    <div class="soxnsox-status-badge">
                        <span class="soxnsox-status-badge-dot"></span>
                        <span>SOXNSOX Admin Console</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Clean Dark Midnight Navy Authentication Form -->
            <div class="form-right-panel">
                
                <!-- Greetings & Soxnsox Admin Context Header -->
                <div class="space-y-1.5 pt-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold tracking-widest uppercase text-[#f29a38] bg-[#0d2847] px-3 py-0.5 rounded-full border border-[#f29a38]/30">
                            Administrative Access
                        </span>
                        <a href="{{ route('shop.home.index') }}" class="text-xs text-slate-300 hover:text-[#f29a38] hover:underline font-medium inline-flex items-center gap-1.5 transition-colors">
                            <span>Storefront</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
                        </a>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white tracking-tight font-sans">
                        Soxnsox Admin Portal
                    </h1>
                    <p class="text-xs sm:text-sm text-slate-300 font-normal leading-relaxed">
                        Sign in to manage catalog, orders, and customer operations.
                    </p>
                </div>

                <!-- Credential Authentication Form -->
                <x-admin::form :action="route('admin.session.store')" class="space-y-4 my-auto">
                    
                    <!-- Row 1: Email Address -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-slate-200 tracking-wide pl-1">
                            @lang('admin::app.users.sessions.email')
                        </label>

                        <x-admin::form.control-group.control
                            type="email"
                            class="soxnsox-auth-input" 
                            id="email"
                            name="email" 
                            rules="required|email" 
                            :label="trans('admin::app.users.sessions.email')"
                            placeholder="admin@soxnsox.in"
                            :value="old('email')"
                        />

                        <x-admin::form.control-group.error control-name="email" class="text-xs text-red-400 mt-0.5 pl-3" />
                    </div>

                    <!-- Row 2: Password with Properly Placed Right-Aligned Eye Toggle -->
                    <div class="space-y-1.5">
                        <label class="block text-xs font-semibold text-slate-200 tracking-wide pl-1">
                            @lang('admin::app.users.sessions.password')
                        </label>

                        <div class="soxnsox-password-container">
                            <x-admin::form.control-group.control
                                type="password"
                                class="soxnsox-auth-input" 
                                id="password"
                                name="password" 
                                rules="required|min:6" 
                                :label="trans('admin::app.users.sessions.password')"
                                placeholder="••••••••"
                            />

                            <!-- Eye Toggle Positioned Cleanly on the Far Right -->
                            <button 
                                type="button" 
                                class="soxnsox-password-toggle-btn"
                                onclick="switchVisibility()"
                                aria-label="Toggle password visibility"
                            >
                                <i id="passwordToggleIcon" class="fa-regular fa-eye text-sm text-slate-400"></i>
                            </button>
                        </div>

                        <x-admin::form.control-group.error control-name="password" class="text-xs text-red-400 mt-0.5 pl-3" />
                    </div>

                    <!-- Remember Me Checkbox & Forgot Password Link -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none text-xs text-slate-200">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="w-4 h-4 rounded border-[#2ca7a3] bg-[#0d2847] text-[#2ca7a3] focus:ring-0 cursor-pointer"
                                {{ old('remember') ? 'checked' : '' }}
                            />
                            <span>Remember Me</span>
                        </label>

                        <a 
                            class="text-xs font-medium text-[#2ca7a3] hover:text-[#f29a38] underline transition-colors"
                            href="{{ route('admin.forget_password.create') }}"
                        >
                            @lang('admin::app.users.sessions.forget-password-link')
                        </a>
                    </div>

                    <!-- Centered CTA Submit Button -->
                    <div class="pt-3">
                        <button
                            type="submit"
                            class="soxnsox-submit-btn"
                        >
                            <span>@lang('admin::app.users.sessions.submit-btn')</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </button>
                    </div>
                </x-admin::form>

                <!-- Bottom Security Encryption Notice -->
                <div class="pt-2 text-center text-[11px] text-white/50">
                    <div class="inline-flex items-center gap-1.5 justify-center">
                        <i class="fa-solid fa-lock text-[#2ca7a3] text-xs"></i>
                        <span>256-Bit Encrypted Secure Administrative Console</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            function switchVisibility() {
                const passwordField = document.getElementById("password");
                const toggleIcon = document.getElementById("passwordToggleIcon");
                
                if (! passwordField || ! toggleIcon) {
                    return;
                }
                
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    toggleIcon.classList.remove("fa-eye");
                    toggleIcon.classList.add("fa-eye-slash");
                } else {
                    passwordField.type = "password";
                    toggleIcon.classList.remove("fa-eye-slash");
                    toggleIcon.classList.add("fa-eye");
                }
            }
        </script>
    @endpush
</x-admin::layouts.anonymous>