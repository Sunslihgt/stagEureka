<?php
// require_once "config.php";
require_once "connexion_bdd.php";
require_once "note_entreprise_modele.php";
require_once "adresse_modele.php";


class Entreprise {
    public int $id;
    public string $nom;
    public string $activite;
    public int $nbCandidats;
    public bool $visible;
    public float $noteEtudiants;
    public float $notePilotes;
    
    public array $adresses;

    public function __construct(int $id, string $nom, string $activite, int $nbCandidats, bool $visible, float $noteEtudiants, float $notePilotes, array $adresses) {
        $this->id = $id;
        $this->nom = $nom;
        $this->activite = $activite;
        $this->nbCandidats = $nbCandidats;
        $this->visible = $visible;
        $this->noteEtudiants = $noteEtudiants;
        $this->notePilotes = $notePilotes;
        $this->adresses = $adresses;
    }
}

function getEntreprises(bool $cacherInvisible): ?array {
    $pdo = connexionBDD();

    $sql = "SELECT * FROM Company";
    if ($cacherInvisible) {  // Si on doit cacher les entreprises invisibles
        $sql .= " WHERE visible = 1";  // On ajoute la condition
    }
    $requete = $pdo->prepare($sql);
    $requete->execute([]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return null;
    }
    
    // echo "<br>";
    $entreprises = [];
    foreach ($reponseBdd as $ligneEntreprise) {
        // echo var_dump($ligneEntreprise) . "<br>";
        $entreprise = new Entreprise(
            $ligneEntreprise["idCompany"],
            $ligneEntreprise["nameCompany"],
            $ligneEntreprise["activityAera"],
            $ligneEntreprise["applicationAmount"],
            $ligneEntreprise["visible"],
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "ETUDIANT"),
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "PILOTE"),
            getAdressesEntreprise($ligneEntreprise["idCompany"])
        );

        $entreprises[] = $entreprise;
    }
    
    // echo "<br>";

    return $entreprises;
}

function getEntreprisesFiltre(string $nomEntrepriseFiltre, string $localisationFiltre, int $notePiloteFiltre, int $noteEtudiantFiltre): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Company WHERE nameCompany LIKE :nomEntrepriseFiltre AND visible = 1");
    $requete->execute([
        ":nomEntrepriseFiltre" => "%" . $nomEntrepriseFiltre . "%"
    ]);

    $reponseBdd = $requete->fetchAll(PDO::FETCH_ASSOC);
    
    // var_dump($reponseBdd);
    if ($reponseBdd === false) {
        return null;
    }
    
    // echo "<br>";
    $entreprises = [];
    foreach ($reponseBdd as $ligneEntreprise) {
        // echo var_dump($ligneEntreprise) . "<br>";
        $entreprise = new Entreprise(
            $ligneEntreprise["idCompany"],
            $ligneEntreprise["nameCompany"],
            $ligneEntreprise["activityAera"],
            $ligneEntreprise["applicationAmount"],
            $ligneEntreprise["visible"],
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "ETUDIANT"),
            getMoyenneNotesEntreprise($ligneEntreprise["idCompany"], "PILOTE"),
            getAdressesEntreprise($ligneEntreprise["idCompany"])
        );

        // Filtrage par la position
        // if ($localisationFiltre != "") {  // Si on a un filtre de localisation
        //     // On crée un string avec les villes des adresses de l'entreprise séparées par des virgules
        //     $villesString = implode(", ", array_map(function ($adresse) {
        //         return $adresse->ville;
        //     }, $entreprise->adresses));
        //     if (strpos($villesString, $localisationFiltre) === false) {  // Si la localisation n'est pas dans les villes de l'entreprise
        //         continue;  // On passe à l'entreprise suivante
        //     }
        // }

        // // Filtrage par la note des pilotes
        if ($notePiloteFiltre != -1 && $entreprise->notePilotes != -1 && $entreprise->notePilotes < $notePiloteFiltre) {
            continue;  // On passe à l'entreprise suivante
        }

        // // Filtrage par la note des étudiants
        if ($noteEtudiantFiltre != -1 && $entreprise->noteEtudiants != -1 && $entreprise->noteEtudiants < $noteEtudiantFiltre) {
            continue;  // On passe à l'entreprise suivante
        }

        // Si tous les filtres correspondent, on ajoute l'entreprise
        $entreprises[] = $entreprise;
    }
    
    // echo "<br>";

    return $entreprises;
}
