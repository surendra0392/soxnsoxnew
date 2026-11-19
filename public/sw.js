/**
 * SOX N SOX — Progressive Web App Service Worker
 * Version: 1.0.0
 */

const CACHE_NAME = 'soxnsox-pwa-v2';
const OFFLINE_URL = '/offline';

const PRECACHE_ASSETS = [
    OFFLINE_URL,
    '/manifest.webmanifest',
    '/favicon.ico',
    '/favicon.png',
    '/apple-touch-icon.png',
    '/logo.png',
    '/images/pwa/icon-192x192.png',
    '/images/pwa/icon-512x512.png',
    '/images/pwa/icon-maskable-192x192.png',
    '/images/pwa/icon-maskable-512x512.png'
];

// Paths that MUST NEVER be cached or intercepted by the Service Worker
const BYPASS_URL_PATTERNS = [
    /\/admin(\/.*)?$/,
    /\/checkout(\/.*)?$/,
    /\/onepage(\/.*)?$/,
    /\/customer(\/.*)?$/,
    /\/wishlist(\/.*)?$/,
    /\/compare(\/.*)?$/,
    /\/gdpr(\/.*)?$/,
    /\/subscription(\/.*)?$/,
    /\/api(\/.*)?$/,
    /\/payment(\/.*)?$/,
    /\/paypal(\/.*)?$/,
    /\/payu(\/.*)?$/,
    /\/stripe(\/.*)?$/,
    /\/phonepe(\/.*)?$/,
    /\/razorpay(\/.*)?$/,
    /\/storage\/.*\.pdf$/
];

/**
 * Install Event: Pre-cache the offline shell and essential brand assets
 */
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(PRECACHE_ASSETS).catch((err) => {
                console.warn('[PWA] Pre-cache non-critical asset failure:', err);
            });
        }).then(() => self.skipWaiting())
    );
});

/**
 * Activate Event: Clean up stale caches and claim clients immediately
 */
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames.map((name) => {
                    if (name !== CACHE_NAME) {
                        return caches.delete(name);
                    }
                })
            );
        }).then(() => self.clients.claim())
    );
});

/**
 * Check if a URL should bypass service worker cache
 */
function shouldBypass(url) {
    const pathname = url.pathname;
    return BYPASS_URL_PATTERNS.some((pattern) => pattern.test(pathname));
}

/**
 * Fetch Event: Intelligent routing
 */
self.addEventListener('fetch', (event) => {
    const request = event.request;

    // Only handle GET requests
    if (request.method !== 'GET') {
        return;
    }

    const url = new URL(request.url);

    // Bypass cross-origin requests (except Google Fonts and CDN icons)
    const isSameOrigin = url.origin === self.location.origin;
    const isFontAsset = url.hostname.includes('fonts.googleapis.com') ||
                        url.hostname.includes('fonts.gstatic.com') ||
                        url.hostname.includes('cdnjs.cloudflare.com');

    if (!isSameOrigin && !isFontAsset) {
        return;
    }

    // Bypass admin, payment, checkout, and API routes
    if (isSameOrigin && shouldBypass(url)) {
        return;
    }

    // 1. Navigation requests (HTML pages) -> Network-First, with cache fallback, then offline fallback
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request)
                .then((networkResponse) => {
                    if (networkResponse && networkResponse.status === 200) {
                        const responseClone = networkResponse.clone();
                        caches.open(CACHE_NAME).then((cache) => {
                            cache.put(request, responseClone);
                        });
                    }
                    return networkResponse;
                })
                .catch(async () => {
                    const cachedResponse = await caches.match(request);
                    if (cachedResponse) {
                        return cachedResponse;
                    }
                    return caches.match(OFFLINE_URL);
                })
        );
        return;
    }

    // 2. Static Assets (CSS, JS, Fonts, Images) -> Stale-While-Revalidate
    const isStaticAsset = ['style', 'script', 'font', 'image'].includes(request.destination) ||
                          url.pathname.startsWith('/themes/') ||
                          url.pathname.startsWith('/build/') ||
                          url.pathname.startsWith('/images/') ||
                          url.pathname.startsWith('/fonts/');

    if (isStaticAsset) {
        event.respondWith(
            caches.open(CACHE_NAME).then((cache) => {
                return cache.match(request).then((cachedResponse) => {
                    const fetchPromise = fetch(request).then((networkResponse) => {
                        if (networkResponse && networkResponse.status === 200) {
                            cache.put(request, networkResponse.clone());
                        }
                        return networkResponse;
                    }).catch(() => {
                        return cachedResponse || Response.error();
                    });

                    return cachedResponse || fetchPromise;
                });
            })
        );
        return;
    }

    // 3. All other GET requests -> Network with cache fallback
    event.respondWith(
        fetch(request).catch(async () => {
            const cached = await caches.match(request);
            return cached || Response.error();
        })
    );
});

/**
 * Message Event: Listen for update prompts
 */
self.addEventListener('message', (event) => {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
