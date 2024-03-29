<?php
require_once "config.php";
require_once "modele/entreprise_modele.php";

// var_dump($params);

// Si pas de paramètre, on redirige vers la liste des entreprises
if (count($params) == 0 || $params[0] == "") {
    header("Location: " . ADRESSE_SITE . "/entreprise/liste");
    exit();
}

$action = $params[0];
switch ($action) {
    case "liste":
        if (count($params) > 1) {
            header("Location: " . ADRESSE_SITE . "/entreprise/liste");
        }

        $entreprises = getEntreprises();

        // var_dump($entreprises);

        require_once "vue/php/entreprise/liste_entreprises.php";

        break;
    case "lire":
        # code...
        break;
    case "creer":
        # code...
        break;
    case "modifier":
        # code...
        break;
    case "supprimer":
        # code...
        break;
    default:
        # code...
        break;
}


