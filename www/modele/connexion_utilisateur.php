<?php
class Utilisateur {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $typeUtilisateur;

    public function __construct(int $id, string $nom, string $prenom, string $email, TypeUtilisateur $typeUtilisateur) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->typeUtilisateur = $typeUtilisateur;
    }
}

class Etudiant extends Utilisateur {

}

class Pilote extends Utilisateur {
    public $classes;

    public function __construct(int $id, string $nom, string $prenom, string $email, array $classes) {
        parent::__construct($id, $nom, $prenom, $email, TypeUtilisateur::PILOTE);
        $this->classes = $classes;
    }
}

enum TypeUtilisateur {
    case ETUDIANT;
    case PILOTE;
    case ADMINISTRATEUR;
}