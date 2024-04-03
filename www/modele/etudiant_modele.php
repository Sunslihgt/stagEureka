<?php
// require_once "outils.php";
require_once "connexion_bdd.php";
require_once "modele/classe_modele.php";

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
    public Classe $classe;


    public function __construct(int $id, string $nom, string $prenom, string $email, string $hash_mdp, Classe $classe) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->hash_mdp = $hash_mdp;
        $this->classe = $classe;
    }
}

function getEtudiant(int $idEtudiant): ?etudiant {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT * FROM Student s
        INNER JOIN Class ON (s.idClass = Class.idClass)
        INNER JOIN City c ON (Class.idCity = c.idCity)
        WHERE idStudent = :id"
    );
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
        $reponseBdd["password"],
        new Classe(
            $reponseBdd["idClass"],
            $reponseBdd["className"],
            $reponseBdd["yearClass"],
            $reponseBdd["cityName"],
            $reponseBdd["addressCode"],
            $reponseBdd["idPilot"]
        )
    );

    return $etudiant;
}

function getEtudiants(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare(
        "SELECT * FROM Student s
        INNER JOIN Class class ON (s.idClass = class.idClass)
        INNER JOIN City c ON (class.idCity = c.idCity)"
    );
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
            $ligneEtudiant["password"],
            new Classe(
                $ligneEtudiant["idClass"],
                $ligneEtudiant["className"],
                $ligneEtudiant["yearClass"],
                $ligneEtudiant["cityName"],
                $ligneEtudiant["addressCode"],
                $ligneEtudiant["idPilot"]
            )
        );

        $etudiants[] = $etudiant;
    }

    // echo "<br>";

    return $etudiants;
}

function getEtudiantsFiltres(string $nom, string $prenom, string $ville, string $nomClasse) : array {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM Student s
            INNER JOIN Class class ON (s.idClass = class.idClass)
            INNER JOIN City c ON (class.idCity = c.idCity)
            WHERE 1";
    $filtres = [];
    if ($nom !== "") {
        $sql .= " AND s.name LIKE :nom";
        $filtres[":nom"] = "%" . $nom . "%";
    }
    if ($prenom !== "") {
        $sql .= " AND s.firstName LIKE :prenom";
        $filtres[":prenom"] = "%" . $prenom . "%";
    }
    if ($ville !== "") {
        $sql .= " AND c.cityName LIKE :ville";
        $filtres[":ville"] = "%" . $ville . "%";
    }
    if ($nomClasse !== "") {
        $sql .= " AND class.className LIKE :nomClasse";
        $filtres[":nomClasse"] = "%" . $nomClasse . "%";
    }

    $requete = $pdo->prepare($sql);
    $requete->execute($filtres);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    if ($reponseBdd === false) {
        return [];
    }

    $etudiants = [];
    foreach ($reponseBdd as $etudiant) {
        $etudiants[] = new Etudiant(
            $etudiant["idStudent"],
            $etudiant["name"],
            $etudiant["firstName"],
            $etudiant["email"],
            $etudiant["password"],
            new Classe(
                $etudiant["idClass"],
                $etudiant["className"],
                $etudiant["yearClass"],
                $etudiant["cityName"],
                $etudiant["addressCode"],
                $etudiant["idPilot"]
            )
        );
    }

    return $etudiants;
}

function creerEtudiant(string $nom, string $prenom, string $mdp, string $email, int $idClass): ?int {
    $pdo = connexionBDD();

    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);

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



function modifierEtudiant(int $id, string $nom, string $prenom, string $email, string $mdp, int $idClasse): bool {
    $pdo = connexionBDD();

    $hash_mdp = password_hash($mdp, PASSWORD_DEFAULT);
    // if (DEBUG) echo "$mdp -> $hash_mdp <br>";

    // Requête SQL Update 
    $query = "UPDATE Student SET name = :nom, firstName = :prenom, email = :email,
              password = :hash_mdp, idClass = :idClasse WHERE idStudent = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":email" => $email,
        ":hash_mdp" => $hash_mdp,
        ":idClasse" => $idClasse,
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
