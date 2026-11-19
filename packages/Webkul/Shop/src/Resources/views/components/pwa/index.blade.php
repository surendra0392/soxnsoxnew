<!-- SOX N SOX PWA Integration & Install Experience -->
<div id="soxnsox-pwa-container" class="relative z-50">
    <!-- 1. Offline / Online Network Status Toast -->
    <div
        id="soxnsox-network-toast"
        class="fixed bottom-20 left-1/2 -translate-x-1/2 z-50 pointer-events-none transition-all duration-300 opacity-0 translate-y-4"
        role="status"
        aria-live="polite"
    >
        <div id="soxnsox-network-toast-inner" class="flex items-center gap-2.5 px-4 py-2.5 rounded-full shadow-2xl text-xs font-semibold tracking-wide backdrop-blur-md">
            <span id="soxnsox-network-indicator" class="w-2.5 h-2.5 rounded-full"></span>
            <span id="soxnsox-network-message"></span>
        </div>
    </div>

    <!-- 2. PWA Add-to-Home-Screen (A2HS) Floating Install Banner (Positioned Bottom-Left) -->
    <div
        id="soxnsox-pwa-install-banner"
        class="fixed bottom-6 ltr:left-4 ltr:sm:left-6 rtl:right-4 rtl:sm:right-6 ltr:right-auto rtl:left-auto max-w-[calc(100vw-2rem)] sm:max-w-sm z-50 transition-all duration-500 opacity-0 translate-y-8 pointer-events-none"
        style="display: none;"
    >
        <div class="bg-white/95 backdrop-blur-md rounded-2xl border border-[#133b63]/15 shadow-2xl p-4 sm:p-5 flex items-start gap-3.5 ring-1 ring-black/5">
            <img
                src="{{ asset('images/pwa/icon-96x96.png') }}"
                alt="SOX N SOX App Icon"
                class="w-12 h-12 rounded-xl object-contain shadow-sm border border-slate-100 flex-shrink-0"
                width="48"
                height="48"
                loading="lazy"
            />

            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between gap-2">
                    <h4 class="text-sm font-bold text-[#133b63] truncate">Install SOX N SOX</h4>
                    <button
                        type="button"
                        id="soxnsox-pwa-dismiss-btn"
                        class="text-slate-400 hover:text-slate-600 p-1 -mr-1 transition-colors"
                        aria-label="Dismiss installation prompt"
                    >
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>
                <p class="text-xs text-slate-600 mt-0.5 line-clamp-2">
                    Add our lightweight app for fast 1-tap checkout & offline browsing!
                </p>

                <div class="mt-3 flex items-center gap-2">
                    <button
                        type="button"
                        id="soxnsox-pwa-install-btn"
                        class="px-4 py-1.5 rounded-full bg-[#133b63] hover:bg-[#1d5b8f] text-white text-xs font-bold uppercase tracking-wider shadow-md hover:shadow-lg active:scale-95 transition-all"
                    >
                        <span>Install App</span>
                    </button>
                    <button
                        type="button"
                        id="soxnsox-pwa-later-btn"
                        class="px-3 py-1.5 text-xs text-slate-500 hover:text-slate-700 font-medium transition-colors"
                    >
                        Not Now
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        'use strict';

        // ── 1. Register Service Worker ──
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function () {
                navigator.serviceWorker.register('/sw.js', { scope: '/' })
                    .then(function (registration) {
                        // Check for service worker updates
                        registration.addEventListener('updatefound', function () {
                            const newWorker = registration.installing;
                            if (newWorker) {
                                newWorker.addEventListener('statechange', function () {
                                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                        // A new version is available; can automatically claim or notify
                                        console.log('[PWA] New content is available; please refresh.');
                                    }
                                });
                            }
                        });
                    })
                    .catch(function (error) {
                        console.warn('[PWA] Service Worker registration failed:', error);
                    });
            });
        }

        // ── 2. Handle Online / Offline Network Status Banner ──
        const toast = document.getElementById('soxnsox-network-toast');
        const toastInner = document.getElementById('soxnsox-network-toast-inner');
        const indicator = document.getElementById('soxnsox-network-indicator');
        const message = document.getElementById('soxnsox-network-message');
        let hideTimeout = null;

        function showNetworkToast(isOnline) {
            if (!toast || !toastInner || !indicator || !message) return;

            clearTimeout(hideTimeout);

            if (isOnline) {
                toastInner.className = 'flex items-center gap-2.5 px-4 py-2.5 rounded-full shadow-2xl text-xs font-semibold tracking-wide backdrop-blur-md bg-emerald-900/90 text-white border border-emerald-500/40';
                indicator.className = 'w-2.5 h-2.5 rounded-full bg-emerald-400';
                message.textContent = 'You are back online!';
                toast.classList.remove('opacity-0', 'translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');

                hideTimeout = setTimeout(function () {
                    toast.classList.remove('opacity-100', 'translate-y-0');
                    toast.classList.add('opacity-0', 'translate-y-4');
                }, 3500);
            } else {
                toastInner.className = 'flex items-center gap-2.5 px-4 py-2.5 rounded-full shadow-2xl text-xs font-semibold tracking-wide backdrop-blur-md bg-[#133b63]/95 text-white border border-[#2ca7a3]/40';
                indicator.className = 'w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse';
                message.textContent = 'Offline Mode — Showing cached content';
                toast.classList.remove('opacity-0', 'translate-y-4');
                toast.classList.add('opacity-100', 'translate-y-0');
            }
        }

        window.addEventListener('online', function () { showNetworkToast(true); });
        window.addEventListener('offline', function () { showNetworkToast(false); });

        // ── 3. Handle PWA BeforeInstallPrompt (A2HS) ──
        let deferredPrompt = null;
        const banner = document.getElementById('soxnsox-pwa-install-banner');
        const installBtn = document.getElementById('soxnsox-pwa-install-btn');
        const dismissBtn = document.getElementById('soxnsox-pwa-dismiss-btn');
        const laterBtn = document.getElementById('soxnsox-pwa-later-btn');

        const isStandalone = window.matchMedia('(display-mode: standalone)').matches ||
                             window.navigator.standalone === true;

        const DISMISS_KEY = 'soxnsox_pwa_dismissed_until';
        const dismissedUntil = localStorage.getItem(DISMISS_KEY);
        const isDismissed = dismissedUntil && parseInt(dismissedUntil, 10) > Date.now();

        if (!isStandalone && !isDismissed && banner) {
            window.addEventListener('beforeinstallprompt', function (e) {
                e.preventDefault();
                deferredPrompt = e;

                banner.style.display = 'block';
                // Trigger transition on next animation frame
                requestAnimationFrame(function () {
                    banner.classList.remove('opacity-0', 'translate-y-8', 'pointer-events-none');
                    banner.classList.add('opacity-100', 'translate-y-0', 'pointer-events-auto');
                });
            });

            function hideBanner(suppressDays) {
                banner.classList.remove('opacity-100', 'translate-y-0', 'pointer-events-auto');
                banner.classList.add('opacity-0', 'translate-y-8', 'pointer-events-none');
                setTimeout(function () {
                    banner.style.display = 'none';
                }, 500);

                if (suppressDays) {
                    const suppressUntil = Date.now() + (suppressDays * 24 * 60 * 60 * 1000);
                    localStorage.setItem(DISMISS_KEY, suppressUntil.toString());
                }
            }

            if (installBtn) {
                installBtn.addEventListener('click', async function () {
                    if (!deferredPrompt) return;
                    deferredPrompt.prompt();
                    const choiceResult = await deferredPrompt.userChoice;
                    if (choiceResult.outcome === 'accepted') {
                        console.log('[PWA] User accepted the install prompt');
                    }
                    deferredPrompt = null;
                    hideBanner(30);
                });
            }

            if (dismissBtn) {
                dismissBtn.addEventListener('click', function () { hideBanner(7); });
            }

            if (laterBtn) {
                laterBtn.addEventListener('click', function () { hideBanner(3); });
            }

            window.addEventListener('appinstalled', function () {
                deferredPrompt = null;
                hideBanner(365);
                console.log('[PWA] SOX N SOX App successfully installed!');
            });
        }
    })();
</script>
