<?php
// require_once "config.php";
require_once "connexion_bdd.php";


class Entreprise {
    public int $id;
    public string $nom;
    public string $activite;
    public int $nbCandidats;
    public bool $visible;

    

    public function __construct(int $id, string $nom, string $activite, int $nbCandidats, bool $visible) {
        $this->id = $id;
        $this->nom = $nom;
        $this->activite = $activite;
        $this->nbCandidats = $nbCandidats;
        $this->visible = $visible;
    }
}

function getEntreprises(): ?array {
    $pdo = connexionBDD();

    $requete = $pdo->prepare("SELECT * FROM Company");
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
            $ligneEntreprise["visible"]
        );

        $entreprises[] = $entreprise;
    }
    
    // echo "<br>";

    return $entreprises;
}
