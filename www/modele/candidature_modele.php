<?php
require_once "connexion_bdd.php";
// require_once "etudiant_modele.php";
// require_once "offre_modele.php";

/**
 * Représente une candidature
 */
class Candidature {
    public int $idCandidature;
    public int $idEtudiant;
    public int $idOffre;
    public string $motivation;
    public string $cvFichier;

    public function __construct(int $idCandidature, int $idEtudiant, int $idOffre, string $motivation, string $cvFichier) {
        $this->idCandidature = $idCandidature;
        $this->idEtudiant = $idEtudiant;
        $this->idOffre = $idOffre;
        $this->motivation = $motivation;
        $this->cvFichier = $cvFichier;
    }
}

/**
 * Récupère une candidature
 * @param int $idCandidature L'identifiant de la candidature
 * @return Candidature|null La candidature si elle existe, null sinon
 */
function getCandidature(int $idCandidature): ?Candidature {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Candidacy WHERE idCandidacy = :idCandidature");
    $requete->execute([":idCandidature" => $idCandidature]);

    $candidature = $requete->fetch();
    if ($candidature === false) {
        return null;
    }

    return new Candidature(
        $candidature["idCandidacy"],
        $candidature["idStudent"],
        $candidature["idInternshipOffer"],
        $candidature["coverLetter"],
        $candidature["CV"]
    );
}

function getCandidaturesFiltre(string $nomEtudiant, string $prenomEtudiant, string $nomOffre, int $idEtudiant): array {
    $pdo = connexionBDD();

    $sql = "SELECT cand.idCandidacy idCandidature, intern.idInternshipOffer idOffre, s.idStudent idEtudiant, s.name nom, s.firstname prenom, intern.title titre
            FROM Candidacy cand
            INNER JOIN Student s ON (cand.idStudent = s.idStudent)
            INNER JOIN InternshipOffer intern ON (cand.idInternshipOffer = intern.idInternshipOffer)
            WHERE 1";
    $filtres = [];
    if ($idEtudiant >= 0) {
        $sql .= " AND s.idStudent = :idEtudiant";
        $filtres[":idEtudiant"] = $idEtudiant;
    }
    if ($nomEtudiant !== "") {
        $sql .= " AND s.name LIKE :nomEtudiant";
        $filtres[":nomEtudiant"] = "%" . $nomEtudiant . "%";
    }
    if ($prenomEtudiant !== "") {
        $sql .= " AND s.firstname LIKE :prenomEtudiant";
        $filtres[":prenomEtudiant"] = "%" . $prenomEtudiant . "%";
    }
    if ($nomOffre !== "") {
        $sql .= " AND intern.title LIKE :nomOffre";
        $filtres[":nomOffre"] = "%" . $nomOffre . "%";
    }
    $requete = $pdo->prepare($sql);
    $requete->execute($filtres);

    $reponseBDD = $requete->fetchAll(PDO::FETCH_ASSOC);
    if ($reponseBDD === false) {
        return [];
    }

    $candidatures = [];
    foreach ($reponseBDD as $candidature) {
        // $candidatures[] = new Candidature(
        //     $candidature["idCandidacy"],
        //     $candidature["idStudent"],
        //     $candidature["idInternshipOffer"],
        //     $candidature["coverLetter"],
        //     $candidature["CV"]
        // );
        $candidatures[] = [
            "idCandidature" => $candidature["idCandidature"],
            "idEtudiant" => $candidature["idEtudiant"],
            "idOffre" => $candidature["idOffre"],
            "nom" => $candidature["nom"],
            "prenom" => $candidature["prenom"],
            "titre" => $candidature["titre"]
        ];
    }

    return $candidatures;
}

/**
 * Crée une candidature
 * @param int $idEtudiant L'identifiant de l'étudiant
 * @param int $idOffre L'identifiant de l'offre de stage
 * @param string $motivation La lettre de motivation
 * @param string $cvFichier Le fichier du CV
 * @return bool Vrai si la candidature a été créée, faux sinon
 */
function creerCandidature(int $idEtudiant, int $idOffre, string $motivation, string $cvFichier): bool {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("INSERT INTO Candidacy (idStudent, idInternshipOffer, coverLetter, CV) VALUES (:idEtudiant, :idOffre, :motivation, :cvFichier)");
    $requete->execute([
        ":idEtudiant" => $idEtudiant,
        ":idOffre" => $idOffre,
        ":motivation" => $motivation,
        ":cvFichier" => $cvFichier
    ]);

    return $requete->rowCount() > 0;
}

/**
 * Supprime une candidature
 * @param int $idCandidature L'identifiant de la candidature à supprimer
 * @return bool Vrai si la candidature a été supprimée, faux sinon
 */
function supprimerCandidature(int $idCandidature): bool {
    $pdo = connexionBDD();

    try {
        $requete = $pdo->prepare("DELETE FROM Candidacy WHERE idCandidacy = :idCandidature");
        $requete->execute([":idCandidature" => $idCandidature]);
    } catch (Exception $e) {
        return false;
    }

    return $requete->rowCount() > 0;
}
