const DYNAMIC_CACHE = 'pwa-dynamic-v8';

var filesToCache = [
    '/',
    '/offline',
    '/list_vacinate',
    '/vaccinate/create',
    '/css/app.css',
    '/css/all.css',
    '/css/sb-admin-2.min.css',
    '/styles_css/bootstrap.css',
    '/js/bootstrap.bundle.js',
    '/js/app.js',
    '/js/jquery.min.js',
    '/js/bootstrap.js',
    '/js/form_validate.js'
];

// Cache on install
self.addEventListener("install", event => {
    self.skipWaiting();
    event.waitUntil(
        caches.open(DYNAMIC_CACHE).then(cache => {
            return cache.addAll(filesToCache);          
        })
    );
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
                        limitCacheSize(DYNAMIC_CACHE, 250);
                        return fetchResponse;
                    })
                });
            }
        }).catch(() => {
            return caches.match('/offline');
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