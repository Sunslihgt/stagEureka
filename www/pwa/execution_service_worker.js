// if (navigator.serviceWorker) {
//     navigator.serviceWorker.register('/service_worker.js')
//     .catch(err => console.error(err));
// }

if (navigator.serviceWorker) {
    navigator.serviceWorker.register("http://localhost/stageureka/www/pwa/service_worker.js").then(function(registration) {
      console.log("Service Worker en fonctionnement :", registration.scope);
    }).catch(function(err) {
      console.log("Service Worker en échec :", err);
    });
  }