var CACHE_STATIC_NAME = "static-cache-v1" + new Date().getTime();
var CACHE_DYNAMIC_NAME = "dynamic-cache-v1" + new Date().getTime();
var CACHE_INMUTABLE_NAME = "immutable-cache-v1" + new Date().getTime();

var staticFilesToCache = [
  "/offline",
  "css/bootstrap.min.css",
  "js/bootstrap.min.js",
  "mystyle/mystyle.css",
  "img/no-wifi.png",
  "img/icon-72x72.png",
  "img/icono.ico"

];

var dynamicFilesToCache = [
  "https://code.jquery.com/jquery-3.6.0.min.js",
  "https://www.google.com/recaptcha/api.js?render=6LeacA8lAAAAAIiAfvQQbcF5DTHDRfIkI7SsP4kG",
  "https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js",

];

var immutableFilesToCache = [
  "images/icons/icon-72x72.png",
  "images/icons/icon-96x96.png",
  "images/icons/icon-128x128.png",
  "images/icons/icon-144x144.png",
  "images/icons/icon-152x152.png",
  "images/icons/icon-192x192.png",
  "images/icons/icon-384x384.png",
  "images/icons/icon-512x512.png",
  "hover/hover-min.css"
];

self.addEventListener("install", event => {
  this.skipWaiting();
  event.waitUntil(
    Promise.all([
      caches.open(CACHE_STATIC_NAME).then(cache => {
        return cache.addAll(staticFilesToCache);
      }),
      caches.open(CACHE_DYNAMIC_NAME).then(cache => {
        // Puedes dejarlo vacío por ahora, ya que se llenará dinámicamente
      }),
      caches.open(CACHE_INMUTABLE_NAME).then(cache => {
        return cache.addAll(immutableFilesToCache);
      })
    ])
  );
});

//Esto asegura que solo las cachés de las versiones anteriores se eliminan durante la activación del nuevo service worker
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (
            cacheName !== CACHE_STATIC_NAME &&
            cacheName !== CACHE_DYNAMIC_NAME &&
            cacheName !== CACHE_INMUTABLE_NAME
          ) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      if (response) {
        return response;
      }

      // Determina si el recurso es dinámico o inmutable
      var cacheName = event.request.url.includes("/api/") ? CACHE_DYNAMIC_NAME : CACHE_INMUTABLE_NAME;

      return fetch(event.request).then(networkResponse => {
        caches.open(cacheName).then(cache => {
          cache.put(event.request, networkResponse.clone());
        });
        return networkResponse;
      }).catch(() => {
        return caches.match("offline");
      });
    })
  );
});
