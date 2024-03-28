<?php

require_once "config.php";
require_once "modele/connexion_bdd.php";

session_start();
var_dump($_SESSION);

if (!isset($_SESSION) || !isset($_SESSION["utilisateur"])) {
    // L'utilisateur n'est pas connecté
    if (isset($_POST) && isset($_POST["identifiant"]) && isset($_POST["mot_de_passe"])) {
        // L'utilisateur a soumis le formulaire de connexion
        $identifiant = $_POST["identifiant"];
        $mot_de_passe = $_POST["mot_de_passe"];

        // Vérifie les identifiants
        $connexion = connexion();
        if ($connexion != null) {
            $requete = $connexion->prepare("SELECT * FROM utilisateur WHERE identifiant = :identifiant AND mot_de_passe = :mot_de_passe");
            $requete->bindParam(":identifiant", $identifiant);
            $requete->bindParam(":mot_de_passe", $mot_de_passe);
            $requete->execute();
            $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
            if ($utilisateur != null) {
                // L'utilisateur est connecté
                $_SESSION["utilisateur"] = $utilisateur;
                header("Location: " . ADRESSE_SITE . "/accueil");
                exit();
            }
        }
    }
} else {
    // L'utilisateur est déjà connecté
    header("Location: " . ADRESSE_SITE . "/accueil");
    exit();
}

// Affiche la vue de connexion
// require_once "vue/php/accueil/accueil_vue.php";

function connexion(int $id, string $mot_de_passe): bool {
    
    
    return false;
}