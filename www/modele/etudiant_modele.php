<?php
// require_once "config.php";
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

}

function getEtudiants(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Student");
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);

    $etudiants = [];
    // var_dump($etudiants);
    if($reponseBdd === false) {
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



function listeEtudiant(int $idEtudiant): ?Etudiant {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM Student WHERE idStudent = ?";
    $requete = $pdo->prepare($sql);
    $requete->execute([$idEtudiant]);

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

    return new Etudiant(
        $reponseBdd["idStudent"],
        $reponseBdd["name"],
        $reponseBdd["firstNAme"],
        $reponseBdd["email"],
        $reponseBdd["password"]
    );
}



function creerEtudiant( 
    string $nom,
    string $prenom,
    string $email,
    string $hash_mdp
) : ?int {
    $pdo = connexionBDD();

    // Début de la transaction (permet d'annuler les modifications si une erreur survient)
    $pdo->beginTransaction();

    // Création du nom
    // Recherche du nom
    $requete = $pdo->prepare(
        "SELECT idStudent FROM Student WHERE cityName = :ville AND addressCode = :codePostal"
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



function modifierEtudiant(int $id, string $nom, string $prenom, string $email, string $hash_mdp): bool {
    if ($nom == "" || $prenom == "" || $email == "" || $hash_mdp != "") {
        // echo "Erreur : etudiant invalide";
        header("Location: " . ADRESSE_SITE . "/erreur/404");
        exit();
    }

    $pdo = connexionBDD();

    // Requête SQL Update 
    $query = "UPDATE etudiant SET name = :nom, firstName = :prenom, email = :email, password = :hash_mdp WHERE idStudent = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ":nom" => $nom,
        ":prenom" => $prenom,
        ":email" => $email,
        ":hash_mdp" => $hash_mdp
    ]);

    if ($stmt->rowCount() === 0) {
        return false;
    }
    return true;
}



function supprimerEtudiant(int $id): bool {
    $pdo = connexionBDD();

    // Requête SQL Update
    $query = "DELETE FROM etudiant WHERE id = ?;";
    $stmt = $pdo->prepare($query);
    $reussiteRequete = $stmt->execute([$id]);
    
    // Vérification réussite requête
    return $reussiteRequete;
}