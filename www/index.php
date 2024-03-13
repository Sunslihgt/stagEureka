<?php
// Routeur du site web

// require_once($_SERVER['DOCUMENT_ROOT'] . "src/controller/accueil.php");


// if (isset($_GET['action']) && $_GET['action'] !== '') {
//     if ($_GET['action'] == 'accueil') {
//         afficher_accueil();
//     } else {
//         echo "Erreur 404 : page non trouvée";
//     }
// } else {
//     afficher_accueil();
// }

header("Location: html_temp/accueil.html");