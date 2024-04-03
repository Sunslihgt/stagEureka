<?php
// require_once "outils.php";
require_once "connexion_bdd.php";

class Etudiant {
    public int $id;
    public string $nom;
    public string $prenom;
    public string $email;
    // On ne stocke pas le mot de passe en clair mais une version hashée qui est stocké en bdd.
    // Un hash est une fonction qui transforme un texte en une suite de caractères aléatoires.
    // Il est impossible de retrouver le texte d'origine à partir du hash.
    // Cependant, on peut comparer un texte avec un hash pour vérifier si le texte correspond au texte d'origine.
    public string $hash_mdp;


    public function __construct(int $id, string $nom, string $prenom, string $email, string $hash_mdp) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->hash_mdp = $hash_mdp;
    }
}

class Classe {
    public int $id;
    public string $nom;
    public int $annee;
    public string $ville;
    public string $codePostal;

    public function __construct(int $id, string $nom, int $annee, string $ville, string $codePostal) {
        $this->id = $id;
        $this->nom = $nom;
        $this->annee = $annee;
        $this->ville = $ville;
        $this->codePostal = $codePostal;
    }
}



function getEtudiants(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Student");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    $etudiants = [];
    // var_dump($etudiants);
    if ($reponseBdd === false) {
        return null;
    }

    foreach ($reponseBdd as $ligneEtudiant) {
        // echo var_dump($ligneEtudiant) . "<br>";
        $etudiant = new Etudiant(
            $ligneEtudiant["idStudent"],
            $ligneEtudiant["name"],
            $ligneEtudiant["firstName"],
            $ligneEtudiant["email"],
            $ligneEtudiant["password"]
        );

        $etudiants[] = $etudiant;
    }

    // echo "<br>";

    return $etudiants;
}



function getEtudiant(int $idEtudiant): ?etudiant {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Student WHERE idStudent = :id");
    $requete->execute([
        ":id" => $idEtudiant
    ]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    $etudiant = new Etudiant(
        $reponseBdd["idStudent"],
        $reponseBdd["name"],
        $reponseBdd["firstName"],
        $reponseBdd["email"],
        $reponseBdd["password"]
    );

    return $etudiant;
}



function listeEtudiant(int $idEtudiant): ?Etudiant {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM Student WHERE idStudent = ?";
    $requete = $pdo->prepare($sql);
    $requete->execute([$idEtudiant]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return null;
    }

    return new Etudiant(
        $reponseBdd["idStudent"],
        $reponseBdd["name"],
        $reponseBdd["firstName"],
        $reponseBdd["email"],
        $reponseBdd["password"]
    );
}



function creerEtudiant(
    string $nom,
    string $prenom,
    string $hash_mdp,
    string $email,
    int $idClass
): ?int {
    $pdo = connexionBDD();

    $query = "INSERT INTO Student (name, firstName, password, email, idClass) VALUE (:nom, :prenom, :hash_mdp, :email, :idClass)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":hash_mdp" => $hash_mdp,
        ":email" => $email,
        ":idClass" => $idClass
    ]);

    $idEtudiant = $pdo->lastInsertId();
    if ($idEtudiant === false) {
        return null;
    }

    return $idEtudiant;
}



function modifierEtudiant(int $id, string $nom, string $prenom, string $email, string $mdp): bool {
    $pdo = connexionBDD();
    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);
    echo "$mdp $hash_mdp <br>";

    // Requête SQL Update 
    $query = "UPDATE Student SET name = :nom, firstName = :prenom, email = :email, password = :hash_mdp WHERE idStudent = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":email" => $email,
        ":hash_mdp" => $hash_mdp,
        ":id" => $id
    ]);

    if ($stmt->rowCount() === 0) {
        return false;
    }
    return true;
}



function supprimerEtudiant(int $id): bool {
    $pdo = connexionBDD();

    try {
        $query = "DELETE FROM Student WHERE idStudent = :idStudent;";
        $stmt = $pdo->prepare($query);
        $reussiteRequete = $stmt->execute([
            ":idStudent" => $id
        ]);
    } catch (Exception $e) {
        return false;
    }

    // Vérification réussite requête
    return $reussiteRequete;
}
