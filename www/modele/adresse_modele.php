<?php
// require_once "outils.php";
require_once "connexion_bdd.php";

/**
 * Représente une adresse
 */
class Adresse {
    public int $id;
    public int $numero;
    public string $rue;
    public string $ville;
    public string $codePostal;

    public function __construct(int $id, int $numero, string $rue, string $ville, string $codePostal) {
        $this->id = $id;
        $this->numero = $numero;
        $this->rue = $rue;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
    }
}

/**
 * Récupère toutes les adresses
 * @return array|null Les adresses si elles existent, null sinon
 */
function getAdresses(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Address a INNER JOIN City c ON (a.idCity = c.idCity)");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    $adresses = [];
    foreach ($reponseBdd as $adresse) {
        $adresses[] = new Adresse(
            $adresse["idAddress"],
            $adresse["streetNumber"],
            $adresse["streetName"],
            $adresse["cityName"],
            $adresse["addressCode"]
        );
    }

    return $adresses;
}

/**
 * Récupère une adresse
 * @param int $id L'identifiant de l'adresse
 * @return Adresse|null L'adresse si elle existe, null sinon
 */
function getAdresse(int $id): ?Adresse {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT a.idAddress, a.streetNumber, a.streetName, c.cityName, c.addressCode
        FROM Address a
        JOIN City c ON (a.idCity = c.idCity)"
    );

    $requete->execute([]);

    $adresse = $requete->fetch();

    if ($adresse === false) {
        return null;
    }

    return new Adresse(
        $adresse["idAddress"],
        $adresse["streetNumber"],
        $adresse["streetName"],
        $adresse["cityName"],
        $adresse["addressCode"]
    );
}

/**
 * Récupère les adresses d'une entreprise
 * @param int $idEntreprise L'identifiant de l'entreprise
 * @return array|null Les adresses si elles existent, null sinon
 */
function getAdressesEntreprise(int $idEntreprise): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT a.idAddress, a.streetNumber, a.streetName, city.cityName, city.addressCode
        FROM Company company
        JOIN is_settle s ON (company.idCompany = s.idCompany)
        JOIN Address a ON (s.idAddress = a.idAddress)
        JOIN City city ON (a.idCity = city.idCity)
        WHERE company.idCompany = :idEntreprise"
    );

    $requete->execute([
        ":idEntreprise" => $idEntreprise
    ]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    $adresses = [];
    foreach ($reponseBdd as $adresse) {
        $adresses[] = new Adresse(
            $adresse["idAddress"],
            $adresse["streetNumber"],
            $adresse["streetName"],
            $adresse["cityName"],
            $adresse["addressCode"]
        );
    }

    return $adresses;
}
