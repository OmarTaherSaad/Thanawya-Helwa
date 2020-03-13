workbox.setConfig({ debug: false });
//Default handler is to State while revalidate
workbox.routing.setDefaultHandler(new workbox.strategies.NetworkFirst());
//Fallback when offline to offline page
workbox.routing.setCatchHandler(({ event }) => {
    return caches.match(workbox.precaching.getCacheKeyForURL('/offline'));
});
//Exclude POST requests from caching
workbox.routing.registerRoute(
    /.+/,
    new workbox.strategies.NetworkOnly(),
    'POST'
);
