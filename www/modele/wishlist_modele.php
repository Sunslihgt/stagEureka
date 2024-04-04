<?php
// require_once "outils.php";
require_once "connexion_bdd.php";

/**
 * Récupère les offres de stage qui sont dans la wishlist d'un étudiant.
 * @param int $idEtudiant L'identifiant de l'étudiant.
 * @return array Un tableau contenant les identifiants des offres de stage de la wishlist de l'étudiant.
 */
function getWishlistsEtudiant(int $idEtudiant): array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT w.idInternshipOffer idOffre FROM wishlist w
        INNER JOIN Student s ON (w.idStudent = s.idStudent)
        WHERE s.idStudent = :id"
    );
    $requete->execute([
        ":id" => $idEtudiant
    ]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return [];
    }

    $wishlists = [];
    foreach ($reponseBdd as $wishlist) {
        $wishlists[] = $wishlist["idOffre"];
    }

    return $wishlists;
}

/**
 * Ajoute une offre de stage à la wishlist d'un étudiant.
 * @param int $idEtudiant L'identifiant de l'étudiant.
 * @param int $idOffre L'identifiant de l'offre de stage.
 * @return bool Vrai si l'offre a été ajoutée à la wishlist, faux sinon.
 */
function ajouterWishlist(int $idEtudiant, int $idOffre): bool {
    $pdo = connexionBDD();

    try {
        $requete = $pdo->prepare(
            "INSERT INTO wishlist (idStudent, idInternshipOffer)
            VALUES (:idStudent, :idInternshipOffer)"
        );
        $requete->execute([
            ":idStudent" => $idEtudiant,
            ":idInternshipOffer" => $idOffre
        ]);
    } catch (Exception $e) {
        return false;
    }

    return $requete->rowCount() === 1;
}

/**
 * Retire une offre de stage à la wishlist d'un étudiant.
 * @param int $idEtudiant L'identifiant de l'étudiant.
 * @param int $idOffre L'identifiant de l'offre de stage.
 * @return bool Vrai si l'offre a été retirée de la wishlist, faux sinon.
 */
function retirerWishlist(int $idEtudiant, int $idOffre): bool {
    $pdo = connexionBDD();

    try {
        $requete = $pdo->prepare(
            "DELETE FROM wishlist
            WHERE idStudent = :idStudent AND idInternshipOffer = :idInternshipOffer"
        );
        $requete->execute([
            ":idStudent" => $idEtudiant,
            ":idInternshipOffer" => $idOffre
        ]);
    } catch (Exception $e) {
        if (DEBUG) echo $e->getMessage();
        return false;
    }

    return $requete->rowCount() === 1;
}