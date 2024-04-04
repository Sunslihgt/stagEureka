importScripts('https://storage.googleapis.com/workbox-cdn/releases/6.4.1/workbox-sw.js');

// CacheFirst pour les images, les styles, les fonts et les vidéos
workbox.routing.registerRoute(
    ({request}) => request.destination === 'image',
    new workbox.strategies.CacheFirst()
);
workbox.routing.registerRoute(
    ({request}) => request.destination === 'style',
    new workbox.strategies.CacheFirst()
);
workbox.routing.registerRoute(
    ({ request }) => request.destination === 'font',
    new workbox.strategies.CacheFirst()
);
workbox.routing.registerRoute(
    ({ request }) => request.destination === 'video',
    new workbox.strategies.CacheFirst()
);

// NetworkFirst pour les documents et les scripts
workbox.routing.registerRoute(
    ({ request }) => request.destination === 'document',
    new workbox.strategies.NetworkFirst()
);
workbox.routing.registerRoute(
    ({ request }) => request.destination === 'script',
    new workbox.strategies.NetworkFirst()
);