const DYNAMIC_CACHE = 'pwa-dynamic-v12';

var filesToCache = [
    '/',
    '/offline',
    '/css/app.css',
    '/js/app.js',
    '/images/icon-72x72.jpg',
    '/images/icon-96x96.jpg',
    '/images/icon-128x128.jpg',
    '/images/icon-144x144.jpg',
    '/images/icon-152x152.jpg',
    '/images/icon-192x192.jpg',
    '/images/icon-384x384.jpg',
    '/images/icon-512x512.jpg',
];

// Cache on install
self.addEventListener("install", event => {
    self.skipWaiting();
    // event.waitUntil(
    //     caches.open(DYNAMIC_CACHE).then(cache => {
    //         // cache.add(filesToCache);            
    //     })
    // );
});

// Clear cache on activate
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.filter(cacheName => (cacheName !== DYNAMIC_CACHE)).map(cacheName => caches.delete(cacheName))
            );
        })
    );
});

// Serve from Cache
self.addEventListener("fetch", event => {
    event.respondWith(
        caches.match(event.request).then(cacheResponse => {
            if(cacheResponse){
                event.waitUntil(fetch(event.request).then(response => {
                    caches.open(DYNAMIC_CACHE).then(cache => {
                        cache.put(event.request, response)
                    })
                }));
                return cacheResponse;
            }else{
                return fetch(event.request).then(fetchResponse => {
                    return caches.open(DYNAMIC_CACHE).then(cache => {
                        cache.put(event.request.url, fetchResponse.clone());
                        cache.add('/');
                        cache.add('/list_vacinate');
                        limitCacheSize(DYNAMIC_CACHE, 250);
                        return fetchResponse;
                    })
                });
            }
        }).catch(() => {
            // console.log("test: "+err);
            // receive_data(err)
            // history.back();
            return caches.match('offline');
        })
    );
});

// Cache size limit function
const limitCacheSize = (name, size) => {
    caches.open(name).then(cache => {
        cache.keys().then(keys => {
            if (keys.length > size) {
                cache.delete(keys[0]).then(limitCacheSize(name, size))
            }
        })
    })
};

// notification
self.addEventListener("push", (event ) => {
    // const pushData = event.data.json();
    // event.waitUntil(
    //     self.registration.showNotification("LesDieuxDuCode", {
    //         body: pushData.Summary,
    //         dir: "ltr",
    //         tag: "lesdieuxducode",
    //         icon: "/images/logo.png",
    //         badge: "/images/logo.png",
    //         image: pushData.TitleImage,
    //         data: pushData
    //     })
    // );
});