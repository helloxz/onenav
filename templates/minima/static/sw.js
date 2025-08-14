// OneNav Default3 Theme Service Worker
const CACHE_NAME = 'onenav-default3-v1.0.0';
const urlsToCache = [
    '/templates/default3/static/style.css',
    '/templates/default3/static/embed.js',
    '/static/bootstrap4/css/bootstrap.min.css',
    '/static/bootstrap4/js/bootstrap.bundle.min.js',
    '/static/js/jquery.min.js',
    '/static/font-awesome/4.7.0/css/font-awesome.css'
];

// Install event
self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function(cache) {
                return cache.addAll(urlsToCache);
            })
    );
});

// Fetch event
self.addEventListener('fetch', function(event) {
    event.respondWith(
        caches.match(event.request)
            .then(function(response) {
                // Return cached version or fetch from network
                return response || fetch(event.request);
            }
        )
    );
});

// Activate event
self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys().then(function(cacheNames) {
            return Promise.all(
                cacheNames.map(function(cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});
