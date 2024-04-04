<?php 
/**
 * Adresse du site web
 */
const ADRESSE_SITE = "http://localhost/stageureka/www";  // Pour la version locale
// const ADRESSE_SITE = "https://stageureka.alwaysdata.net";  // Pour la version en ligne

const DEBUG = true;  // Affiche ou cache les erreurs

const NB_RESULTATS_PAGE = 5;  // Nombre de résultats par page (pour la pagination)

/**
 * Vérifie si l'utilisateur est connecté
 * @return bool
 */
function estConnecte(): bool {
    return isset($_SESSION["id"]);
}

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

/**
 * Redirige vers la page d'accueil
 */
function redirectionAccueil(): void {
    redirectionInterne("accueil");
}

/**
 * Redirige vers la page d'erreur
 * @param int $codeErreur Code d'erreur HTTP (Optionnel)
 * @param string $messageErreur Message d'erreur (Optionnel)
 */
function redirectionErreur(int $codeErreur = 404, string $messageErreur = ""): void {
    $url = "erreur/$codeErreur";
    if ($messageErreur != "") {
        $url .= "/$messageErreur";
    }
    redirectionInterne($url);
}


/**
 * Redirige vers une page interne commençant par le nom du site
 * (Exemple: /offre/liste)
 * @param string $url URL de la page interne
 */
function redirectionInterne(string $url): void {
    header("Location: " . ADRESSE_SITE . "/$url");
}