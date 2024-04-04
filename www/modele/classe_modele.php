<?php
// require_once "outils.php";
require_once "connexion_bdd.php";

/**
 * Représente une classe
 */
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

/**
 * Récupère toutes les classes
 * @return array Les classes
 */
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

/**
 * Récupère une classe
 * @param int $id L'identifiant de la classe
 * @return Classe|null La classe si elle existe, null sinon
 */
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

/**
 * Récupère les classes d'un pilote
 * @param int $idPilote L'identifiant du pilote
 * @return array|null Les classes si elles existent, null sinon
 */
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
