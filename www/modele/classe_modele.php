<?php
// require_once "outils.php";
require_once "connexion_bdd.php";


class Classe {
    public int $id;
    public string $nom;
    public int $annee;
    public string $ville;
    public string $codePostal;
    public int $idPilote;

    public function __construct(int $id, string $nom, int $annee, string $ville, string $codePostal, int $idPilote) {
        $this->id = $id;
        $this->nom = $nom;
        $this->annee = $annee;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
        $this->idPilote = $idPilote;
    }
}

function getClasses(): array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Class class
    INNER JOIN City c ON (class.idCity = c.idCity)");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return [];
    }

    $classes = [];
    foreach ($reponseBdd as $classe) {
        $classes[] = new Classe(
            $classe["idClass"],
            $classe["className"],
            $classe["yearClass"],
            $classe["cityName"],
            $classe["addressCode"],
            $classe["idPilot"]
        );
    }

    return $classes;
}

function getClasse(int $id): ?Classe {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT class.idClass, class.className, class.yearClass, c.cityName, c.addressCode, class.idPilot
        FROM Class class INNER JOIN City c ON (class.idCity = c.idCity)
        WHERE class.idClass = :id"
    );

    $requete->execute([
        ":id" => $id
    ]);

    $classe = $requete->fetch();

    if ($classe === false) {
        return null;
    }

    return new Classe(
        $classe["idClass"],
        $classe["className"],
        $classe["yearClass"],
        $classe["cityName"],
        $classe["addressCode"],
        $classe["idPilot"]
    );
}

function getClassesPilote(int $idPilote): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT class.idClass, class.className, class.yearClass, c.cityName, c.addressCode, class.idPilot
        FROM Class class INNER JOIN City c ON (class.idCity = c.idCity)
        WHERE class.idPilot = :idPilote"
    );

    $requete->execute([
        ":idPilote" => $idPilote
    ]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    $classes = [];
    foreach ($reponseBdd as $classe) {
        $classes[] = new Adresse(
            $classe["idClass"],
            $classe["className"],
            $classe["yearClass"],
            $classe["cityName"],
            $classe["addressCode"],
            $classe["idPilot"]
        );
    }

    return $classes;
}
