<?php
// require_once "config.php";
require_once "connexion_bdd.php";


class Adresse {
    public int $id;
    public int $numero;
    public string $rue;
    // public int $idVille;
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

function getAdresses(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Address a INNER JOIN City c ON (a.idCity = c.idCity)");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return null;
    }

    // echo "<br>";
    $adresses = [];
    foreach ($reponseBdd as $adresse) {
        // echo var_dump($adresse) . "<br>";

        $adresses[] = new Adresse(
            $adresse["idAddress"],
            $adresse["streetNumber"],
            $adresse["streetName"],
            $adresse["cityName"],
            $adresse["addressCode"]
        );
    }

    // echo "<br>";

    return $adresses;
}

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

    // echo var_dump($reponseBdd) . "<br>";
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
