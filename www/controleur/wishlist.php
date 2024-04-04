<?php
require_once "outils.php";
require_once "modele/wishlist_modele.php";

// On vérifie qu'il y a au moins un paramètre
if (count($params) < 1) {
    // redirectionErreur(400);
    http_response_code(400);
    exit();
}

// On vérifie que l'utilisateur est connecté et est un étudiant
if (!estConnecte() || !estEtudiant()) {
    http_response_code(401);
    // redirectionErreur(401, "Vous-devez-être-connecté-en-tant-qu'étudiant-pour-accéder-à-cette-page");
    exit();
}

$action = $params[0];

switch ($action) {
    case "ajouter":
        // Si pas de paramètre, on redirige vers la liste des offres
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            redirectionErreur(400);
            http_response_code(400);
            exit();
        }

        // On récupère l'identifiant de l'offre
        $idOffre = intval($params[1]);

        // On ajoute l'offre à la wishlist de l'étudiant
        $offreAjoutee = ajouterWishlist($_SESSION["id"], $idOffre);

        // On renvoie une réponse HTML
        if ($offreAjoutee) {
            // header("HTTP/1.1 201 Created");
            http_response_code(201);
        } else {
            // header("HTTP/1.1 400 Bad Request");
            http_response_code(400);
        }
        break;
    case "supprimer":
        // Si pas de paramètre, on redirige vers la liste des offres
        if (count($params) != 2 || !is_numeric($params[1]) || $params[1] < 0) {
            // redirectionErreur(400);
            http_response_code(400);
            exit();
        }

        // On récupère l'identifiant de l'offre
        $idOffre = intval($params[1]);

        // On ajoute l'offre à la wishlist de l'étudiant
        $offreSupprimee = retirerWishlist($_SESSION["id"], $idOffre);

        // On renvoie une réponse HTML
        if ($offreSupprimee) {
            header("HTTP/1.1 200 OK");
            http_response_code(200);
        } else {
            // header("HTTP/1.1 400 Bad Request");
            http_response_code(418);
        }
        break;
    default:
        http_response_code(400);  // Mauvaise requête
        break;
}





