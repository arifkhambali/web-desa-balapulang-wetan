const CACHE_NAME = 'webdesa-v1';
const ASSETS_TO_CACHE = [
    '/',
    '/css/filament/filament/app.css',
    '/js/filament/filament/app.js',
    '/logo-pwa-192.png',
    '/logo-pwa-512.png',
    '/manifest.json'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(ASSETS_TO_CACHE);
        })
    );
});

self.addEventListener('fetch', (event) => {
    // During debugging, only cache essential static assets
    // and let everything else go to the network directly
    if (event.request.url.includes('manifest.json') ||
        event.request.url.includes('/storage/')) {
        return; // Don't handle it in SW for now
    }

    event.respondWith(
        caches.match(event.request).then((response) => {
            return response || fetch(event.request);
        }).catch(() => {
            return fetch(event.request);
        })
    );
});
