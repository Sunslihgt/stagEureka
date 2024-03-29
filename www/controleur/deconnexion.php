<?php

require_once "config.php";

// Démarrage de la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Déconnexion de l'utilisateur
session_destroy();

// Redirige l'utilisateur vers la page d'accueil
header("Location: " . ADRESSE_SITE . "/accueil");
