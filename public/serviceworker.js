var staticCacheName = "pwa-v" + new Date().getTime();
var dynamicCacheName = "dynamic-v1";

var filesToCache = [
    "/offline",
    "css/bootstrap.min.css",
    "js/bootstrap.min.js",
    "img/no-wifi.png",
    "img/icon-72x72.png",
    "images/icons/icon-72x72.png",
    "images/icons/icon-96x96.png",
    "images/icons/icon-128x128.png",
    "images/icons/icon-144x144.png",
    "images/icons/icon-152x152.png",
    "images/icons/icon-192x192.png",
    "images/icons/icon-384x384.png",
    "images/icons/icon-512x512.png",
    "/productos",
    "/somos",
    "/servicios",
    "/citas",
    "/ayuda",
];

// Instalar caché
self.addEventListener("install", event => {
  this.skipWaiting();
  event.waitUntil(
    caches.open(staticCacheName).then(cache => {
      return cache.addAll(filesToCache);
    })
  );
});

// Limpiar caché o activarlo
self.addEventListener("activate", event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames
          .filter(cacheName => cacheName.startsWith("pwa-"))
          .filter(cacheName => cacheName !== staticCacheName)
          .map(cacheName => caches.delete(cacheName))
      );
    })
  );
});

// Servir desde caché o recuperar de la red y almacenar en el caché
self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request).then(response => {
      if (response) {
        // Servir la respuesta en caché
        return response;
      }

      // Si la solicitud no está en el caché, recuperarla de la red
      return fetch(event.request).then(networkResponse => {
        // Clonar la respuesta de la red
        const clonedResponse = networkResponse.clone();

        // Almacenar la respuesta clonada en el caché dinámico
        caches.open(dynamicCacheName).then(cache => {
          cache.put(event.request, clonedResponse);
        });

        // Devolver la respuesta de la red
        return networkResponse;
      }).catch(error => {
        // Si la red falla, intentar recuperar desde el caché dinámico
        return caches.match(event.request).then(cachedResponse => {
          if (cachedResponse) {
            return cachedResponse;
          }

          // Si no hay una respuesta en el caché, servir una imagen de respaldo
          return caches.match("/offline"); // Cambia "/offline" por la ruta de tu imagen de respaldo
        });
      });
    })
  );
});

self.addEventListener('push', event => {
  const options = {
    body: event.data.text(),
  };

  event.waitUntil(
    self.registration.showNotification('Nueva Notificación', options)
  );
});
