<?php
require_once "outils.php";
require_once "connexion_bdd.php";
require_once "modele/classe_modele.php";

class Pilote {
    public int $id;
    public string $nom;
    public string $prenom;
    public string $hash_mdp;
    public string $email;

    public function __construct(int $id, string $nom, string $prenom, string $hash_mdp, string $email) {
    $this->id = $id;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->hash_mdp = $hash_mdp;
    $this->email = $email;
    }
}

function getPilote(int $idPilote){
    $pdo = connexionBDD();
    $sql = "SELECT * FROM Pilot WHERE idPilot = :id";

    $requete = $pdo->prepare($sql);
    $requete->execute([":id" => $idPilote]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    
    $pilote = new Pilote(
        $reponseBdd["idPilot"],
        $reponseBdd["name"],
        $reponseBdd["firstName"],
        $reponseBdd["password"],
        $reponseBdd["email"],
    );

    return $pilote;
}

function getPilotes(): array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Pilot");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($reponseBdd);
    if($reponseBdd === false) {
        return [];
    }

    // if (DEBUG) echo "<br>";
    $pilotes = [];
    foreach ($reponseBdd as $lignePilote) {
        // if (DEBUG) echo var_dump($lignePilote) . "<br>";
        $pilotes[] = new Pilote(
            $lignePilote["idPilot"],
            $lignePilote["name"],
            $lignePilote["firstName"],
            $lignePilote["password"],
            $lignePilote["email"]
        );
    }

    // if (DEBUG) echo "<br>";
    return $pilotes;
}

function getPilotesFiltres(string $nom, string $prenom): array {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM Pilot WHERE 1";
    $filtres = [];
    if ($nom !== "") {
        $sql .= " AND name LIKE :nom";
        $filtres[":nom"] = "%". $nom . "%";
    }
    if ($prenom !== "") {
        $sql .= " AND firstName LIKE :prenom";
        $filtres[":prenom"] = "%". $prenom . "%";
    }

    $requete = $pdo->prepare($sql);
    $requete->execute($filtres);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return [];
    }

    $pilotes = [];
    foreach ($reponseBdd as $lignePilote) {
        $pilotes[] = new Pilote(
            $lignePilote["idPilot"],
            $lignePilote["name"],
            $lignePilote["firstName"],
            $lignePilote["password"],
            $lignePilote["email"]
        );
    }

    return $pilotes;
}

function creerPilote(string $nom, string $prenom, string $email, string $mdp): ?int{
    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $pdo = connexionBDD();

    $sql = "INSERT INTO Pilot (name, firstName, password, email) VALUE (:nom, :prenom, :hash_mdp, :email)";
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":hash_mdp" => $hash_mdp,
        ":email" => $email
    ]);

    $idPilote = $pdo->lastInsertId();
    if ($idPilote === false) {
        return null;
    }

    return $idPilote;
}

function ModifierPilote(int $idPilote, string $nom, string $prenom, string $email, string $mdp): bool {
    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);

    $pdo = connexionBDD();
    $sql = "UPDATE Pilot
    SET name = :nom, firstName = :prenom, email = :email, password = :mdp
    WHERE idPilot = :idPilote";
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ":nom" => $nom, 
        ":prenom" => $prenom,
        ":email" => $email,
        ":mdp" => $hash_mdp,
        ":idPilote" => $idPilote
    ]);

    if ($requete->rowCount() === 0) {
        return false;
    }

    return true;
}

function supprimerPilote(int $idPilote): bool{
    $pdo = connexionBDD();

    try {
        $sql = "DELETE FROM Pilot WHERE idPilot = :idPilote";
        $requete = $pdo->prepare($sql);
        $requete->execute([
            ":idPilote" => $idPilote
        ]);
    } catch (Exception $e) {
        if (DEBUG) var_dump($e);
        return false;
    }

    return true;
}