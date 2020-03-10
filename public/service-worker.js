/**
 * Welcome to your Workbox-powered service worker!
 *
 * You'll need to register this file in your web app and you should
 * disable HTTP caching for this file too.
 * See https://goo.gl/nhQhGp
 *
 * The rest of the code is auto-generated. Please don't update this file
 * directly; instead, make changes to your Workbox build configuration
 * and re-run your build process.
 * See https://goo.gl/2aRDsh
 */

importScripts("workbox-v4.3.1/workbox-sw.js");
workbox.setConfig({modulePathPrefix: "workbox-v4.3.1"});

importScripts(
  "./js/service-worker.js",
  "precache-manifest.bccfc9b35cad4b6f960e07bfe3b40398.js"
);

workbox.core.setCacheNameDetails({prefix: "TH"});

workbox.core.skipWaiting();

workbox.core.clientsClaim();

/**
 * The workboxSW.precacheAndRoute() method efficiently caches and responds to
 * requests for URLs in the manifest.
 * See https://goo.gl/S9QRab
 */
self.__precacheManifest = [
  {
    "url": "/offline",
    "revision": "481d2dc05d557ef17bfaf18e2647884a"
  },
  {
    "url": "/",
    "revision": "e09897fbdd2918deee752b67af496219"
  },
  {
    "url": "/about-us",
    "revision": "ab681be0a001b177b9f7634304449637"
  },
  {
    "url": "/Tansik/Geographic-Distribution-Information",
    "revision": "b5916aa88edd6c6e0e89d28ecaefbbec"
  },
  {
    "url": "/Tansik/Taqleel-al-eghterab",
    "revision": "53ce240fb78f576d603133890be4eea6"
  },
  {
    "url": "/Tansik/Tzalom",
    "revision": "130de469475a22f24893f3b8b9dff9b9"
  },
  {
    "url": "/Tansik/Stages-Information",
    "revision": "b4b3df3b22736d26c8f5c702c3986249"
  }
].concat(self.__precacheManifest || []);
workbox.precaching.precacheAndRoute(self.__precacheManifest, {
  "ignoreURLParametersMatching": [/./]
});

workbox.precaching.cleanupOutdatedCaches();

workbox.routing.registerRoute(/\.(?:css|js|png|jpg|jpeg|svg)$/, new workbox.strategies.StaleWhileRevalidate(), 'GET');
workbox.routing.registerRoute(/((\/Tansik\/).+(Edges|Distribution$))|contact$|join-us$|TAS|\/team\//, new workbox.strategies.NetworkOnly(), 'GET');
