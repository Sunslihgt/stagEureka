<?php
require_once "outils.php";
require_once "connexion_bdd.php";
require_once "modele/pilote_modele.php";

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

function getPilotes(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Pilot");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    // var_dump($reponseBdd);
    if($reponseBdd === false) {
        return null;
    }

    // echo "<br>";
    $pilotes = [];
    foreach ($reponseBdd as $lignePilote) {
        // $pilote = new Pilote();
        // echo var_dump($lignePilote) . "<br>";
        $pilote = new Pilote(
            $lignePilote["idPilot"],
            $lignePilote["name"],
            $lignePilote["firstName"],
            $lignePilote["password"],
            $lignePilote["email"]
        );

        $pilotes[] = $pilote;
    }

    // echo "<br>";
    return $pilotes;
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

function creerPilote(string $nom, string $prenom, string $email, string $mdp): ?int{
    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);
    $pdo = connexionBDD();

    $sql = "INSERT INTO Student (name :nom, firstName :prenom, password :hash_mpd, email :email)";
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
    WHERE idInternshipOffer = :idOffre";
    $requete = $pdo->prepare($sql);
    $requete->execute([
        ":nom" => $nom, 
        ":prenom" => $prenom,
        ":email" => $email,
        ":mdp" => $hash_mdp,
        ":idPilote" => $idPilote
    ]);

    if ($requete->rowCount() === 0) {
        $pdo->rollBack();
        return false;
    }

    $pdo->commit();

    return true;
}

function supprimerPilote(int $idPilote): bool{
    $pdo = connexionBDD();

    try {
        $sql = "DELETE FROM Pilot WHERE idPilot= :idPilote";
        $requete = $pdo->prepare($sql);
        $requete->execute([
            " :idPilote" => $idPilote
        ]);
    } catch (Exception $e) {
        return false;
    }

    return true;
}