<?php 
/**
 * Adresse du site web
 */
const ADRESSE_SITE = "http://localhost/stageureka/www";

/**
 * Vérifie si l'utilisateur est un administrateur
 * @return bool
 */
function estAdmin(): bool {
    return isset($_SESSION["id"]) && isset($_SESSION["typeUtilisateur"]) && $_SESSION["typeUtilisateur"] == "ADMINISTRATEUR";
}

/**
 * Vérifie si l'utilisateur est un pilote
 * @return bool
 */
function estPilote(): bool {
    return isset($_SESSION["id"]) && isset($_SESSION["typeUtilisateur"]) && $_SESSION["typeUtilisateur"] == "PILOTE";
}

/**
 * Vérifie si l'utilisateur est un étudiant
 * @return bool
 */
function estEtudiant(): bool {
    return isset($_SESSION["id"]) && isset($_SESSION["typeUtilisateur"]) && $_SESSION["typeUtilisateur"] == "ETUDIANT";
}