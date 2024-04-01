<?php

// require_once "outils.php";
require_once "connexion_bdd.php";
require_once "entreprise_modele.php";
require_once "adresse_modele.php";


class Offre {
    public int $id;
    public string $titre;
    public string $description;
    public string $competences;
    public float $remuneration;
    public int $places;
    public int $duree;
    public string $mineure;
    public string $urlImage;
    public DateTime $dateDebut;
    public Adresse $adresse;
    public Entreprise $entreprise;

    public function __construct(
        int $id,
        string $titre,
        string $description,
        string $competences,
        float $remuneration,
        int $places,
        int $duree,
        string $mineure,
        string $urlImage,
        DateTime $dateDebut,
        Adresse $adresse,
        Entreprise $entreprise
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->competences = $competences;
        $this->remuneration = $remuneration;
        $this->places = $places;
        $this->duree = $duree;
        $this->mineure = $mineure;
        $this->urlImage = $urlImage;
        $this->dateDebut = $dateDebut;
        $this->adresse = $adresse;
        $this->entreprise = $entreprise;
    }
}

const MINEURES = [
    "GENE", "INFO", "BTP", "S3E"
];

/**
 * Récupère toutes les offres de stage
 * @return array Tableau d'objets Offre
 */
function getOffres(): array {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM InternshipOffer";
    $requete = $pdo->prepare($sql);
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    // if (DEBUG) var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return [];
    }
    // if (DEBUG) echo var_dump($reponseBdd) . "<br>";

    $offres = [];
    foreach ($reponseBdd as $offre) {
        try {
            $dateDebut = new DateTime($offre["offerDate"]);
            // if (DEBUG) echo var_dump($dateDebut) . "<br>";
        } catch (Exception $e) {
            continue;  // Si la date n'est pas valide, on ignore l'offre
        }
        $mineure = $offre["minor"];
        $adresse = getAdresse($offre["idAddress"]);
        $entreprise = getEntreprise($offre["idCompany"], false);

        if (is_null($adresse) || is_null($entreprise) || !in_array($mineure, MINEURES)) {
            continue;  // Si l'adresse ou l'entreprise n'existe pas, on ignore l'offre
        }

        $offres[] =  new Offre(
            $offre["idInternshipOffer"],
            $offre["title"],
            $offre["description"],
            $offre["skills"],
            $offre["remuneration"],
            $offre["numberOfPlaces"],
            $offre["duration"],
            $mineure,
            $offre["pictureURL"],
            $dateDebut,
            $adresse,
            $entreprise
        );
    }
    
    return $offres;
}

function getOffre(int $idOffre): ?Offre {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM InternshipOffer WHERE idInternshipOffer = ?";
    $requete = $pdo->prepare($sql);
    $requete->execute([$idOffre]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    try {
        $dateDebut = new DateTime($reponseBdd["offerDate"]);
    } catch (Exception $e) {
        return null;
    }
    $mineure = $reponseBdd["minor"];
    $adresse = getAdresse($reponseBdd["idAddress"]);
    $entreprise = getEntreprise($reponseBdd["idCompany"], false);

    if (is_null($adresse) || is_null($entreprise) || !in_array($mineure, MINEURES)) {
        return null;
    }

    return new Offre(
        $reponseBdd["idInternshipOffer"],
        $reponseBdd["title"],
        $reponseBdd["description"],
        $reponseBdd["skills"],
        $reponseBdd["remuneration"],
        $reponseBdd["numberOfPlaces"],
        $reponseBdd["duration"],
        $mineure,
        $reponseBdd["pictureURL"],
        $dateDebut,
        $adresse,
        $entreprise
    );
}

/**
 * Crée une offre de stage et son adresse (réutilise la ville si possible)
 * @param string $titre
 * @param string $description
 * @param string $competences
 * @param float $remuneration
 * @param int $places
 * @param int $duree
 * @param string $mineure
 * @param string $urlImage
 * @param DateTime $dateDebut
 * @param int $idEntreprise
 * @param int $numeroRue
 * @param string $rue
 * @param string $ville
 * @param string $codePostal
 * @return int|null ID de l'offre créée ou null si une erreur survient
 */
function creerOffre(
    string $titre,
    string $description,
    string $competences,
    float $remuneration,
    int $places,
    int $duree,
    string $mineure,
    string $urlImage,
    DateTime $dateDebut,
    int $idEntreprise,
    int $numeroRue,
    string $rue,
    string $ville,
    string $codePostal
) : ?int {
    $pdo = connexionBDD();

    // Début de la transaction (permet d'annuler les modifications si une erreur survient)
    $pdo->beginTransaction();

    // Création de l'adresse
    // Recherche de la ville
    $requete = $pdo->prepare(
        "SELECT idCity FROM City WHERE cityName = :ville AND addressCode = :codePostal"
    );
    $requete->execute([
        ":ville" => $ville,
        ":codePostal" => $codePostal
    ]);
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    if ($resultat !== false && isset($resultat["idCity"])) {  // La ville existe déjà
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

    // Création de l'offre
    $sql = "INSERT INTO InternshipOffer (title, description, skills,
    remuneration, numberOfPlaces, duration, minor, pictureURL, offerDate, idAddress, idCompany)
    VALUES (:titre, :description, :competences, :remuneration, :places, :duree, :mineure, :urlImage, :dateDebut, :idAdresse, :idEntreprise)";
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ":titre" => $titre,
        ":description" => $description,
        ":competences" => $competences,
        ":remuneration" => $remuneration,
        ":places" => $places,
        ":duree" => $duree,
        ":mineure" => $mineure,
        ":urlImage" => $urlImage,
        ":dateDebut" => $dateDebut->format("Y-m-d"),
        ":idAdresse" => $idAdresse,
        ":idEntreprise" => $idEntreprise
    ]);

    $idOffre = $pdo->lastInsertId();
    if ($idOffre === false) {
        $pdo->rollBack();
        return null;
    }

    $pdo->commit();

    return $idOffre;
}
