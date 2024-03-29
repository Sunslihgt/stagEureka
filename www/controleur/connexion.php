<?php

require_once "config.php";
require_once "modele/utilisateur_modele.php";

// Démarrage de la session si nécessaire
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// var_dump($_SESSION);

if (!isset($_SESSION["id"])) {  // L'utilisateur n'est pas connecté
    if (isset($_POST) && isset($_POST["email"]) && isset($_POST["mdp"])) {  // Tentative de connexion
        // echo "POST";

        // L'utilisateur a soumis le formulaire de connexion
        $email = $_POST["email"];
        $mdp = $_POST["mdp"];
        
        // Vérifie les identifiants
        $connexion = connexion($email, $mdp);
        if ($connexion) {  // Connexion réussie
            // echo "Connexion réussie";
            header("Location: " . ADRESSE_SITE . "/accueil");
            exit();
        } else {  // Connexion échouée
            require_once "vue/php/connexion/connexion_vue.php";
            exit();
        }
    } else {  // Affichage du formulaire de connexion
        // echo "GET";
        require_once "vue/php/connexion/connexion_vue.php";
        exit();
    }
} else {
    // L'utilisateur est déjà connecté
    header("Location: " . ADRESSE_SITE . "/accueil");
    exit();
}

// Affiche la vue de connexion
// require_once "vue/php/accueil/accueil_vue.php";

function connexion(string $email, string $mdp): bool {
    $utilisateur = connexionUtilisateur($email, $mdp);

    if (is_null($utilisateur)) {  // La connexion a échouée
        // echo "<br>";
        // echo "Identifiants incorrects";

        return false;
    }
    
    // Connexion réussie, on stocke les infos de l'utilisateur dans des variables du serveur
    // (Ces variables sont conservées par le serveur tant qu'il tourne)
    $_SESSION["id"] = $utilisateur->id;
    $_SESSION["nom"] = $utilisateur->nom;
    $_SESSION["prenom"] = $utilisateur->prenom;
    $_SESSION["email"] = $utilisateur->email;
    $_SESSION["typeUtilisateur"] = $utilisateur->typeUtilisateur;

    // echo "<br>";
    // echo "Identifiants corrects";
    // echo "<br>";
    // var_dump($_SESSION);
    return true;
}