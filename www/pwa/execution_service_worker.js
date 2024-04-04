// if (navigator.serviceWorker) {
//     navigator.serviceWorker.register('/service_worker.js')
//     .catch(err => console.error(err));
// }

if (navigator.serviceWorker) {
    // TODO: Mettre à jour l'URL du service worker en fonction de l'environnement
    // const url = "https://stageureka.alwaysdata.net/pwa/service_worker.js";  // Production
    const url = "http://localhost/stageureka/www/pwa/service_worker.js";  // Test en local
    navigator.serviceWorker.register(url).then(function (registration) {
      console.log("Service Worker en fonctionnement :", registration.scope);
    }).catch(function (err) {
      console.log("Service Worker en échec :", err);
    });
  }