self.addEventListener('fetch', function (event) {
    console.log('[ServiceWorker] Fetch event fired.', event.request.url);
    if (event.request.method != "GET")
    {
        return;
    }
     event.respondWith(async function () {
         // If we didn't find a match in the cache, use the network.
         return fetch(event.request).catch(function (e) {
             alert('You appear to be offline, please try again when back online');
             console.log(e);
         });
     }());
});