// self.addEventListener('fetch', event => {
//     const cached = caches.match(event.request);
//     const fetched = fetch(event.request);
//     const fetchedCopy = fetched.then(resp => resp.clone());

//     // Call respondWith() with whatever we get first.
//     // If the fetch fails (e.g disconnected), wait for the cache.
//     // If there’s nothing in cache, wait for the fetch. 
//     // If neither yields a response, return a 404.
//     event.respondWith(
//         Promise.race([fetched.catch(_ => cached), cached])
//         .then(resp => resp || fetched)
//         .catch(_ => new Response(null, {
//             status: 404
//         }))
//     );

//     // Update the cache with the version we fetched
//     event.waitUntil(
//         Promise.all([fetchedCopy, caches.open('cache-v1')])
//         .then(([response, cache]) => cache.put(event.request, response))
//         .catch(_ => {
//             /* eat any errors */ })
//     );
// });