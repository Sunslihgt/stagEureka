<?php

/**
 * Renvoie une connexion à la base de données.
 * @brief Les données de connexion sont stockées dans le fichier mdp.php qui est sécurisé dans Apache.
 * Le fait d'utiliser une fonction pour récupérer les identifiants permet de limiter leur portée.
 * @return PDO Connexion à la base de données
 */
function connexionBDD(): PDO {
    static $connexion = null;

    // Si la connexion existe déjà, on la renvoie
    if (!is_null($connexion)) {
        return $connexion;
    }

    // Récupère les informations de connexion à la base de données
    $infosConnexion = include "mdp.php";
    $serveur = $infosConnexion["serveur"];
    $utilisateur = $infosConnexion["utilisateur"];
    $mdp = $infosConnexion["mdp"];
    $base_de_donnees = $infosConnexion["base_de_donnees"];

    try {
        $connexion = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mdp);
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return null;
    }

    return $connexion;
}
