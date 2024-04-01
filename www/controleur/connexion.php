<?php

require_once "outils.php";
require_once "modele/utilisateur_modele.php";

// Démarrage de la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// if (DEBUG) var_dump($_SESSION);

if (!isset($_SESSION["id"])) {  // L'utilisateur n'est pas connecté
    if (isset($_POST) && isset($_POST["email"]) && isset($_POST["mdp"])) {  // Tentative de connexion
        // L'utilisateur a soumis le formulaire de connexion
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        
        // Vérifie les identifiants
        $connexion = connexion($email, $mdp);
        if ($connexion) {  // Connexion réussie
            redirectionAccueil();
            exit();
        } else {  // Connexion échouée
            require_once "vue/php/connexion/connexion_vue.php";
            exit();
        }
    } else {  // Affichage du formulaire de connexion
        require_once "vue/php/connexion/connexion_vue.php";
        exit();
    }
} else {
    // L'utilisateur est déjà connecté
    redirectionAccueil();
    exit();
}

/**
 * Vérifie les identifiants de connexion d'un utilisateur.
 * Stocke les informations de l'utilisateur dans des variables de session si la connexion est réussie.
 * @param string $email Email de l'utilisateur
 * @param string $mdp Mot de passe de l'utilisateur
 * @return bool true si les identifiants sont corrects, false sinon
 */
function connexion(string $email, string $mdp): bool {
    $utilisateur = connexionUtilisateur($email, $mdp);

    if (is_null($utilisateur)) {  // La connexion a échouée
        return false;
    }
    
    // Connexion réussie, on stocke les infos de l'utilisateur dans des variables du serveur
    // (Ces variables sont conservées par le serveur tant qu'il tourne)
    $_SESSION["id"] = $utilisateur->id;
    $_SESSION["nom"] = $utilisateur->nom;
    $_SESSION["prenom"] = $utilisateur->prenom;
    $_SESSION["email"] = $utilisateur->email;
    $_SESSION["typeUtilisateur"] = $utilisateur->typeUtilisateur;

    // if (DEBUG) var_dump($_SESSION);
    return true;
}