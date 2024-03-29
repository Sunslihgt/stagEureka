<?php

/**
 * Classe Utilisateur
 */
class Utilisateur {
    public int $id;
    public string $nom;
    public string $prenom;
    public string $email;
    // On ne stocke pas le mot de passe en clair mais une version hashée qui est stocké en bdd.
    // Un hash est une fonction qui transforme un texte en une suite de caractères aléatoires.
    // Il est impossible de retrouver le texte d'origine à partir du hash.
    // Cependant, on peut comparer un texte avec un hash pour vérifier si le texte correspond au texte d'origine.
    public string $hash_mdp;
    // Type de l'utilisateur (ADMINISTRATEUR, PILOTE, ETUDIANT) voir la constante TYPES_UTILISATEUR
    public string $typeUtilisateur;

    public function __construct(int $id, string $nom, string $prenom, string $email, string $hash_mdp, string $typeUtilisateur) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->hash_mdp = $hash_mdp;
        $this->typeUtilisateur = $typeUtilisateur;
    }
}

// Liste des types d'utilisateurs et du nom de la table correspondante
const TYPES_UTILISATEUR = [
    "ADMINISTRATEUR" => "Administrator",
    "PILOTE" => "Pilot",
    "ETUDIANT" => "Student"
];

/**
 * Vérifie les identifiants de connexion d'un utilisateur.
 * @param string $email Email de l'utilisateur
 * @param string $mdp Mot de passe de l'utilisateur
 * @return Utilisateur|null Utilisateur si les identifiants sont corrects, null sinon
 */
function connexionUtilisateur(string $email, string $mdp): ?Utilisateur {
    $utilisateur = getUtilisateur($email);

    // S'il n'y a pas d'utilisateur correspondant à l'adresse email donnée
    if ($utilisateur === null) {
        return null;
    }

    // Vérifie que le mot de passe donné correspond au mot de passe hashé stocké en bdd
    if (password_verify($mdp, $utilisateur->hash_mdp)) {
        echo "Mot de passe correct";
        return $utilisateur;
    } else {
        return null;
    }
}

/**
 * Récupère un utilisateur à partir de son adresse email (pas de vérification du mdp).
 * @param string $email Email de l'utilisateur
 * @return Utilisateur|null Utilisateur ou null si l'utilisateur n'existe pas
 */
function getUtilisateur(string $email): ?Utilisateur {
    // Récupère les utilisateurs correspondant à l'adresse email donnée
    $admin = getUtilisateurAbstrait($email, "ADMINISTRATEUR");
    $pilote = getUtilisateurAbstrait($email, "PILOTE");
    $etudiant = getUtilisateurAbstrait($email, "ETUDIANT");

    // Compte le nombre de types d'utilisateurs trouvés pour l'adresse email donnée
    $nbTypesTrouves = 0;
    if (!is_null($admin)) $nbTypesTrouves++;
    if (!is_null($pilote)) $nbTypesTrouves++;
    if (!is_null($etudiant)) $nbTypesTrouves++;

    // On traite les cas possibles
    if ($nbTypesTrouves == 0) {  // L'utilisateur n'existe pas
        // echo "L'utilisateur n'existe pas";
        return null;
    } else if ($nbTypesTrouves == 1) {  // L'utilisateur existe
        // echo "L'utilisateur existe";
        // Renvoie l'utilisateur trouvé
        // L'opérateur ?? renvoie le premier opérande qui n'est pas null
        return $admin ?? $pilote ?? $etudiant;
    } else {  // Plusieurs utilisateurs ont la même adresse email
        // echo "Plusieurs utilisateurs ont la même adresse email";
        return null;
    }
}

/**
 * Renvoie un utilisateur à partir de son email et de son type.
 * (Appelle la table correspondante au type d'utilisateur demandé)
 * @param string $email Email de l'utilisateur
 * @param string $typeUtilisateur Type de l'utilisateur
 * @return Utilisateur|null Utilisateur abstrait ou null si l'utilisateur n'existe pas
 */
function getUtilisateurAbstrait(string $email, string $typeUtilisateur): ?Utilisateur {
    if (!isset(TYPES_UTILISATEUR[$typeUtilisateur])) {  // Si le type d'utilisateur n'existe pas
        return null;
    }

    $pdo = ConnectionBDD();

    $requete = $pdo->prepare("SELECT * FROM " . TYPES_UTILISATEUR[$typeUtilisateur] . " WHERE email = :email");
    $requete->execute([
        ":email" => $email
    ]);

    $reponseBdd = $requete->fetch(PDO::FETCH_ASSOC);
    
    // Affiche le résultat de la recherche pour débugger
    // echo "Recherche utilisateur " . $typeUtilisateur . ": ";
    // var_dump($reponseBdd);
    // echo "<br>";

    if ($reponseBdd === false || !isset($reponseBdd["idAdministrator"]) || !isset($reponseBdd["email"]) || !isset($reponseBdd["name"]) || !isset($reponseBdd["firstName"]) || !isset($reponseBdd["password"])) {
        return null;
    }
    
    return new Utilisateur($reponseBdd["idAdministrator"], $reponseBdd["name"], $reponseBdd["firstName"], $reponseBdd["email"], $reponseBdd["password"], $typeUtilisateur);
}

/**
 * Renvoie une connexion à la base de données.
 * @return PDO|null Connexion à la base de données ou null si la connexion a échouée
 */
function ConnectionBDD(): ?PDO {
    // Crée la variable PDO si elle n'existe pas
    // Une fois créée elle est conservée en mémoire
    static $pdo = null;
    if ($pdo === null) {
        require_once 'connexion_bdd.php';
        $pdo = connexionBDD();
    }

    return $pdo;
}
