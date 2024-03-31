<?php
// require_once "outils.php";
require_once "connexion_bdd.php";

class NoteEtudiant {
    public int $idEntreprise;
    public int $idEtudiant;
    public int $note;

    public function __construct(int $idEntreprise, int $idEtudiant, int $note) {
        $this->idEntreprise = $idEntreprise;
        $this->idEtudiant = $idEtudiant;
        $this->note = $note;
    }
}

class NotePilote {
    public int $idEntreprise;
    public int $idPilote;
    public int $note;

    public function __construct(int $idEntreprise, int $idPilote, int $note) {
        $this->idEntreprise = $idEntreprise;
        $this->idPilote = $idPilote;
        $this->note = $note;
    }
}

// Liste des types de notes et du nom de la table et des champs correspondants
const TYPES_NOTE = [
    "ETUDIANT" => ["grade", "idStudent", "studentGrade"],
    "PILOTE" => ["rate", "idPilot", "pilotGrade"]
];

function getNotesEntreprise(int $idEntreprise, string $typeNote): ?array {
    if (!array_key_exists($typeNote, TYPES_NOTE)) {
        return null;
    }

    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM " . TYPES_NOTE[$typeNote][0] . " WHERE idCompany = ?");
    $requete->execute([$idEntreprise]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    // if (DEBUG) var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return null;
    }

    $notes = [];
    foreach ($reponseBdd as $note) {
        // if (DEBUG) echo var_dump($note) . "<br>";

        $notes[] = new NoteEtudiant(
            $note["idCompany"],
            $note[TYPES_NOTE[$typeNote][1]],  // idPilot ou idStudent
            $note[TYPES_NOTE[$typeNote][2]]  // pilotGrade ou studentGrade
        );
    }

    return $notes;
}

/**
 * Récupère la moyenne des notes des étudiants ou des pilotes pour une entreprise donnée
 * @param int $idEntreprise
 * @param string $typeNote Type de note ("ETUDIANT" ou "PILOTE")
 * @return float Renvoie la moyenne des notes des étudiants ou -1 si aucune note n'est disponible
 */
function getMoyenneNotesEntreprise(int $idEntreprise, string $typeNote): float {
    if (!array_key_exists($typeNote, TYPES_NOTE)) {
        return -1;
    }

    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT AVG(" . TYPES_NOTE[$typeNote][2] .") as moyenne, COUNT(" . TYPES_NOTE[$typeNote][2] . ") as quantite
        FROM " . TYPES_NOTE[$typeNote][0] . " WHERE idCompany = ?"
    );
    $requete->execute([$idEntreprise]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);

    // if (DEBUG) var_dump($reponseBdd);
    if ($reponseBdd === false || $reponseBdd["quantite"] == 0) {
        return -1;
    }

    return $reponseBdd["moyenne"];
}