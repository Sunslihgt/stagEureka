<?php

/**
 * Renvoie une connexion à la base de données.
 * @brief Les données de connexion sont stockées dans le fichier mot_de_passe.php qui est sécurisé dans Apache.
 * Le fait d'utiliser une fonction pour récupérer les identifiants permet de limiter leur portée.
 * @return PDO Connexion à la base de données
 */
function connexion(): PDO {
    static $connexion = null;

    // Récupère les informations de connexion à la base de données
    $infosConnexion = include "mot_de_passe.php";
    $serveur = $infosConnexion["serveur"];
    $utilisateur = $infosConnexion["utilisateur"];
    $mot_de_passe = $infosConnexion["mot_de_passe"];
    $base_de_donnees = $infosConnexion["base_de_donnees"];

    try {
        $connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }

    return $connexion;
}
