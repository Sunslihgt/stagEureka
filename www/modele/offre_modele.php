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

function getOffresFiltre(
    string $nomEntreprise,
    string $ville,
    int $dureeMin,
    int $dureeMax,
    int $remunerationMin,
    int $remunerationMax,
    bool $wishlist,
    bool $gene,
    bool $info,
    bool $btp,
    bool $s3e,
    int $idEtudiant=-1
) : ?array {
    $pdo = connexionBDD();

    $filtres = [];

    $sql = "SELECT * FROM InternshipOffer intern
    JOIN Company comp ON intern.idCompany = comp.idCompany
    JOIN Address a ON intern.idAddress = a.idAddress
    JOIN City c ON a.idCity = c.idCity
    WHERE 1";

    // On change la requête si on veut les offres de la wishlist de l'étudiant
    if ($wishlist && $idEtudiant >= 0) {
        $sql = "SELECT * FROM InternshipOffer intern
        JOIN Company comp ON intern.idCompany = comp.idCompany
        JOIN Address a ON intern.idAddress = a.idAddress
        JOIN City c ON a.idCity = c.idCity
        JOIN wishlist w ON intern.idInternshipOffer = w.idInternshipOffer
        WHERE w.idStudent = :idEtudiant";
        $filtres[":idEtudiant"] = $idEtudiant;
    }

    if ($nomEntreprise !== "") {
        $sql .= " AND comp.nameCompany LIKE :nomEntreprise";
        $filtres[":nomEntreprise"] = "%" . $nomEntreprise . "%";
    }

    if ($ville !== "") {
        $sql .= " AND c.cityName LIKE :ville";
        $filtres[":ville"] = "%" . $ville . "%";
    }

    if ($dureeMin >= 0 && ($dureeMin <= $dureeMax || $dureeMax < 0)) {
        $sql .= " AND intern.duration >= :dureeMin";
        $filtres[":dureeMin"] = $dureeMin;
    }

    if ($dureeMax >= 0 && ($dureeMin <= $dureeMax || $dureeMin < 0)) {
        $sql .= " AND intern.duration <= :dureeMax";
        $filtres[":dureeMax"] = $dureeMax;
    }

    if ($remunerationMin >= 0 && ($remunerationMin <= $remunerationMax || $remunerationMax < 0)) {
        $sql .= " AND intern.remuneration >= :remunerationMin";
        $filtres[":remunerationMin"] = $remunerationMin;
    }

    if ($remunerationMax >= 0 && ($remunerationMin <= $remunerationMax || $remunerationMin < 0)) {
        $sql .= " AND intern.remuneration <= :remunerationMax";
        $filtres[":remunerationMax"] = $remunerationMax;
    }

    if ($gene || $info || $btp || $s3e) {
        $mineures = [];
        if ($gene) $mineures[] = "'GENE'";
        if ($info) $mineures[] = "'INFO'";
        if ($btp) $mineures[] = "'BTP'";
        if ($s3e) $mineures[] = "'S3E'";
        
        // Crée un filtre du type "AND minor IN ('GENE', 'INFO', 'BTP', 'S3E')"
        $sql .= " AND intern.minor IN (" . implode(", ", $mineures) . ")";
    }

    // if (DEBUG) echo $sql . "<br>";
    // if (DEBUG) var_dump($filtres) . "<br>";
    $requete = $pdo->prepare($sql);
    $requete->execute($filtres);  // Aplique les filtres

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return [];
    }

    $offres = [];
    foreach ($reponseBdd as $offre) {
        try {
            $dateDebut = new DateTime($offre["offerDate"]);
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

function modifierOffre(
    int $idOffre,
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
) : bool {
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
        return false;
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
        return false;
    }

    // Création de l'offre
    $sql = "UPDATE InternshipOffer
    SET title = :titre, description = :description, skills = :competences,
    remuneration = :remuneration, numberOfPlaces = :places, duration = :duree,
    minor = :mineure, pictureURL = :urlImage, offerDate = :dateDebut,
    idAddress = :idAdresse, idCompany = :idEntreprise
    WHERE idInternshipOffer = :idOffre";
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
        ":idEntreprise" => $idEntreprise,
        ":idOffre" => $idOffre
    ]);

    if ($requete->rowCount() === 0) {
        $pdo->rollBack();
        return false;
    }
    // TODO: Vérifier fonctionnement fonction

    $pdo->commit();

    return true;
}

function supprimerOffre(int $idOffre): bool {
    $pdo = connexionBDD();

    try {
        $sql = "DELETE FROM InternshipOffer WHERE idInternshipOffer = ?";
        $requete = $pdo->prepare($sql);
        $requete->execute([$idOffre]);
    } catch (Exception $e) {
        return false;
    }

    return true;
}
