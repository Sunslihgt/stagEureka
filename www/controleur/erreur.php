<?php

$codeErreur = 404;
if (isset($params[0])) {
    if (is_numeric($params[0]) && $params[0] >= 400 && $params[0] < 600) {
        $codeErreur = $params[0];
    } else {
        header("Location: " . ADRESSE_SITE . "/erreur/404");
    }
}

$messageErreur = null;
switch ($codeErreur) {
    case 400:
        $messageErreur = "Requête incorrecte";
        break;
    case 401:
        $messageErreur = "Accès non autorisé";
        break;
    case 403:
        $messageErreur = "Accès interdit";
        break;
    case 404:
        $messageErreur = "Page non trouvée";
        break;
    case 500:
        $messageErreur = "Erreur interne du serveur";
        break;
    case 501:
        $messageErreur = "Fonctionnalité non implémentée";
        break;
    default:
        $messageErreur = "Une erreur inattendue est survenue";
        break;
}

// Affiche la vue de l'erreur
require_once "vue/php/erreur/erreur_vue.php";
