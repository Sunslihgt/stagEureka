<?php

// require_once "outils.php";
require_once "connexion_bdd.php";
require_once "note_entreprise_modele.php";
require_once "adresse_modele.php";


/**
 * Représente une entreprise
 */
class Entreprise {
    public int $id;
    public string $nom;
    public string $activite;
    public int $nbCandidats;
    public bool $visible;
    public float $noteEtudiants;
    public float $notePilotes;
    
    public array $adresses;

    public function __construct(int $id, string $nom, string $activite, int $nbCandidats, bool $visible, float $noteEtudiants, float $notePilotes, array $adresses) {
        $this->id = $id;
        $this->nom = $nom;
        $this->activite = $activite;
        $this->nbCandidats = $nbCandidats;
        $this->visible = $visible;
        $this->noteEtudiants = $noteEtudiants;
        $this->notePilotes = $notePilotes;
        $this->adresses = $adresses;
    }
}

/**
 * Récupère une entreprise par son ID (peut être filtré pour cacher les entreprises invisibles)
 * @param int $idEntreprise ID de l'entreprise à récupérer
 * @param bool $cacherInvisible true pour cacher les entreprises invisibles, false sinon
 * @return Entreprise|null Entreprise récupérée ou null si elle n'est pas trouvée
 */
function getEntreprise(int $idEntreprise, bool $cacherInvisible): ?Entreprise {
    if ($idEntreprise < 0) {
        return null;
    }

    $pdo = connexionBDD();

    $sql = "SELECT * FROM Company WHERE idCompany = :idEntreprise";
    if ($cacherInvisible) {  // Si on doit cacher les entreprises invisibles
        $sql .= " AND visible = 1";  // On ajoute la condition
    }
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ":idEntreprise" => $idEntreprise
    ]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    
    $entreprise = new Entreprise(
        $reponseBdd["idCompany"],
        $reponseBdd["nameCompany"],
        $reponseBdd["activityAera"],
        $reponseBdd["applicationAmount"],
        $reponseBdd["visible"],
        getMoyenneNotesEntreprise($reponseBdd["idCompany"], "ETUDIANT"),
        getMoyenneNotesEntreprise($reponseBdd["idCompany"], "PILOTE"),
        getAdressesEntreprise($reponseBdd["idCompany"])
    );

    return $entreprise;
}

/**
 * Récupère toutes les entreprises (peut être filtré pour cacher les entreprises invisibles)
 * @param bool $cacherInvisible true pour cacher les entreprises invisibles, false sinon
 * @return array Tableau d'entreprises
 */
function getEntreprises(bool $cacherInvisible): array {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM Company";
    if ($cacherInvisible) {  // Si on doit cacher les entreprises invisibles
        $sql .= " WHERE visible = 1";  // On ajoute la condition
    }
    $requete = $pdo->prepare($sql);
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // if (DEBUG) var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return [];
    }
    
    $entreprises = [];
    foreach ($reponseBdd as $ligneEntreprise) {
        // if (DEBUG) echo var_dump($ligneEntreprise) . "<br>";
        $entreprise = new Entreprise(
            $ligneEntreprise["idCompany"],
            $ligneEntreprise["nameCompany"],
            $ligneEntreprise["activityAera"],
            $ligneEntreprise["applicationAmount"],
            $ligneEntreprise["visible"],
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "ETUDIANT"),
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "PILOTE"),
            getAdressesEntreprise($ligneEntreprise["idCompany"])
        );

        $entreprises[] = $entreprise;
    }

    return $entreprises;
}

/**
 * Récupère les entreprises filtrées par nom, localisation, note des pilotes et note des étudiants
 * @param string $nomEntrepriseFiltre Nom de l'entreprise à filtrer
 * @param string $localisationFiltre Localisation à filtrer
 * @param int $notePiloteFiltre Note des pilotes à filtrer
 * @param int $noteEtudiantFiltre Note des étudiants à filtrer
 * @return array|null Tableau d'entreprises filtrées ou null si une erreur survient
 */
function getEntreprisesFiltre(string $nomEntrepriseFiltre, string $localisationFiltre, int $notePiloteFiltre, int $noteEtudiantFiltre): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Company WHERE nameCompany LIKE :nomEntrepriseFiltre AND visible = 1");
    $requete->execute([
        ":nomEntrepriseFiltre" => "%" . $nomEntrepriseFiltre . "%"
    ]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // if (DEBUG) var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return null;
    }
    
    $entreprises = [];
    foreach ($reponseBdd as $ligneEntreprise) {
        // if (DEBUG) echo var_dump($ligneEntreprise) . "<br>";
        $entreprise = new Entreprise(
            $ligneEntreprise["idCompany"],
            $ligneEntreprise["nameCompany"],
            $ligneEntreprise["activityAera"],
            $ligneEntreprise["applicationAmount"],
            $ligneEntreprise["visible"],
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "ETUDIANT"),
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "PILOTE"),
            getAdressesEntreprise($ligneEntreprise["idCompany"])
        );

        // Filtrage par la position
        if ($localisationFiltre != "") {  // Si on a un filtre de localisation
            // On crée un string avec les villes des adresses de l'entreprise séparées par des virgules
            $villesString = implode(", ", array_map(function ($adresse) {
                return $adresse->ville;
            }, $entreprise->adresses));
            if (strpos($villesString, $localisationFiltre) === false) {  // Si la localisation n'est pas dans les villes de l'entreprise
                continue;  // On passe à l'entreprise suivante
            }
        }

        // // Filtrage par la note des pilotes
        if ($notePiloteFiltre != -1 && $entreprise->notePilotes != -1 && $entreprise->notePilotes < $notePiloteFiltre) {
            continue;  // On passe à l'entreprise suivante
        }

        // // Filtrage par la note des étudiants
        if ($noteEtudiantFiltre != -1 && $entreprise->noteEtudiants != -1 && $entreprise->noteEtudiants < $noteEtudiantFiltre) {
            continue;  // On passe à l'entreprise suivante
        }

        // Si tous les filtres correspondent, on ajoute l'entreprise
        $entreprises[] = $entreprise;
    }

    return $entreprises;
}

/**
 * Crée une entreprise et lie son adresse (réutilise la ville si possible)
 * @param string $nomEntreprise
 * @param int $numeroRue
 * @param string $rue
 * @param string $ville
 * @param string $codePostal
 * @param string $domaine
 * @param bool $visible
 * @return int|null ID de l'entreprise créée ou null si une erreur survient
 */
function creerEntreprise(string $nomEntreprise, int $numeroRue, string $rue, string $ville, string $codePostal, string $domaine, bool $visible): ?int {
    $pdo = connexionBDD();

    // Début de la transaction (permet d'annuler les modifications si une erreur survient)
    $pdo->beginTransaction();

    // Ajout de l'entreprise
    $requete = $pdo->prepare(
        "INSERT INTO Company (nameCompany, activityAera, applicationAmount, visible)
        VALUES (:nomEntreprise, :domaine, 0, :visible)"
    );
    $requete->execute([
        ":nomEntreprise" => $nomEntreprise,
        ":domaine" => $domaine,
        ":visible" => $visible
    ]);

    $idEntreprise = $pdo->lastInsertId();
    if ($idEntreprise === false) {
        $pdo->rollBack();
        return null;
    }
    // if (DEBUG) echo "Entreprise créée ! idEntreprise: " . $idEntreprise . "<br>";

    // Recherche de la ville
    $requete = $pdo->prepare(
        "SELECT idCity FROM City WHERE cityName = :ville AND addressCode = :codePostal"
    );
    $requete->execute([
        ":ville" => $ville,
        ":codePostal" => $codePostal
    ]);
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    if ($resultat !== false && isset($resultat["idCity"])) {  // La ville existe
        $idVille = $resultat["idCity"];
        // if (DEBUG) echo "ville trouvée ! idVille: " . $idVille . "<br>";
    } else {  // Création de la ville
        $requete = $pdo->prepare(
            "INSERT INTO City (cityName, addressCode)
            VALUES (:ville, :codePostal)"
        );
        $requete->execute([
            ":ville" => $ville,
            ":codePostal" => $codePostal
        ]);
        $idVille = $pdo->lastInsertId();

        // if (DEBUG) echo "ville créée ! idVille: " . $idVille . "<br>";
    }
    
    if ($idVille === false) {
        $pdo->rollBack();
        return null;
    }

    // Création de l'adresse
    $requete = $pdo->prepare(
        "INSERT INTO Address (streetNumber, streetName, idCity)
        VALUES (:numeroRue, :rue, :idVille)"
    );
    $requete->execute([
        ":numeroRue" => $numeroRue,
        ":rue" => $rue,
        ":idVille" => $idVille,
    ]);

    $idAdresse = $pdo->lastInsertId();
    if ($idAdresse === false) {
        $pdo->rollBack();
        return null;
    }

    // Ajout de la relation entre l'entreprise et l'adresse
    $requete = $pdo->prepare(
        "INSERT INTO is_settle (idCompany, idAddress)
        VALUES (:idEntreprise, :idAdresse)"
    );
    $requete->execute([
        ":idEntreprise" => $idEntreprise,
        ":idAdresse" => $idAdresse
    ]);

    // if (DEBUG) echo "Relation entreprise-adresse créée ! idAdresse: " . $idAdresse . "idEntreprise" . $idEntreprise . "<br>";

    // Validation de la transaction
    $pdo->commit();

    return $idEntreprise;
}

/**
 * Modifie une entreprise et son adresse (réutilise la ville si possible)
 * @param int $idEntreprise
 * @param string $nomEntreprise
 * @param int $numeroRue
 * @param string $rue
 * @param string $ville
 * @param string $codePostal
 * @param string $domaine
 * @param bool $visible
 * @return bool true si la modification a réussi, false sinon
 */
function modifierEntreprise(int $idEntreprise, string $nomEntreprise, string $domaine, bool $visible): bool {
    $pdo = connexionBDD();

    // Modification de l'entreprise
    $requete = $pdo->prepare(
        "UPDATE Company
        SET nameCompany = :nomEntreprise, activityAera = :domaine, visible = :visible
        WHERE idCompany = :idEntreprise"
    );
    $requete->execute([
        ":nomEntreprise" => $nomEntreprise,
        ":domaine" => $domaine,
        ":visible" => $visible,
        ":idEntreprise" => $idEntreprise
    ]);

    // Si aucune ligne n'a été modifiée
    if ($requete->rowCount() === 0) {
        return false;
    }

    return true;
}

/**
 * Supprime une entreprise et ses adresses
 * @param int $idEntreprise ID de l'entreprise à supprimer
 * @return bool true si la suppression a réussi, false sinon
 */
function supprimerEntreprise(int $idEntreprise): bool {
    $pdo = connexionBDD();

    // Début de la transaction (permet d'annuler les modifications si une erreur survient)
    $pdo->beginTransaction();
    try {
        // Suppression de la relation entre l'entreprise et l'adresse
        $requete = $pdo->prepare(
            "DELETE FROM is_settle
        WHERE idCompany = :idEntreprise"
        );
        $requete->execute([
            ":idEntreprise" => $idEntreprise
        ]);

        // Suppression de l'entreprise
        $requete = $pdo->prepare(
            "DELETE FROM Company
            WHERE idCompany = :idEntreprise"
        );
        $requete->execute([
            ":idEntreprise" => $idEntreprise
        ]);
    } catch (Exception $e) {
        $pdo->rollBack();
        return false;
    }

    // Validation de la transaction
    $pdo->commit();

    return true;
}
