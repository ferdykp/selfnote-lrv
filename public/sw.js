/* SelfNote: cache static shell only, never HTML with private notes or POST responses. */
const VERSION = 'selfnote-pwa-v1';
const STATIC = `${VERSION}-static`;
const CORE = ['/offline.html', '/icon/pwa-192.png', '/icon/pwa-512.png', '/manifest.webmanifest'];
self.addEventListener('install', event => {
  event.waitUntil(caches.open(STATIC).then(cache => cache.addAll(CORE)).then(() => self.skipWaiting()));
});
self.addEventListener('activate', event => {
  event.waitUntil(Promise.all([
    caches.keys().then(keys => Promise.all(keys.filter(key => key.startsWith('selfnote-pwa-') && key !== STATIC).map(key => caches.delete(key)))),
    self.clients.claim()
  ]));
});
self.addEventListener('fetch', event => {
  const request = event.request;
  const url = new URL(request.url);
  if (request.method !== 'GET' || url.origin !== self.location.origin) return;
  if (request.mode === 'navigate') {
    event.respondWith(fetch(request).catch(() => caches.match('/offline.html')));
    return;
  }
  // Vite fingerprinted files are immutable, safe to cache without note content.
  if (/^\/build\/assets\/[a-zA-Z0-9_.-]+$/.test(url.pathname)) {
    event.respondWith(caches.match(request).then(cached => cached || fetch(request).then(response => {
      if (response.ok && response.type === 'basic') {
        const copy = response.clone();
        caches.open(STATIC).then(cache => cache.put(request, copy));
      }
      return response;
    })));
  }
});
