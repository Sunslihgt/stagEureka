<?php

// Import d'un modèle si des données de la BDD sont nécessaires
// require_once('src/model/nom_du_modele.php');

// Affiche la page d'accueil
function afficher_accueil() {
    // $_SERVER['DOCUMENT_ROOT'] donne le chemin absolu du dossier racine du serveur web
    // C'est à dire le chemin absolu du dossier www
    // En PHP, l'opérateur '.' est l'opérateur de concaténation (exemple : 'a' . 'b' donne 'ab')
    require($_SERVER['DOCUMENT_ROOT'] . 'templates/pages/accueil.php');
}