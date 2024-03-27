// Script pour les filtres en étoile de la page de recherche d'entreprises
const prefixIdPilote = "filtre-etoile-pilote-";
const prefixIdEtudiant = "filtre-etoile-etudiant-";

// Ajoute un listener sur chaque étoile pour mettre à jour l'apparence et la note des étoiles
$(document).ready(function() {
    for (let i = 1; i <= 5; i++) {
        let btnEtoilePilote = $("#" + prefixIdPilote + i);
        let btnEtoileEtudiant = $("#" + prefixIdEtudiant + i);
    
        // Action lorsqu'on clique sur une étoile de note pilote
        btnEtoilePilote.click(function() {
            $("#note-pilote").val(i);  // Met à jour la note dans le champ caché
            miseAJourEtoiles(prefixIdPilote, i);
        });

        // Action lorsqu'on survole une étoile de note pilote
        btnEtoilePilote.hover(
            function() {
                miseAJourEtoiles(prefixIdPilote, i);
            },
            function() {
                miseAJourEtoiles(prefixIdPilote, $("#note-pilote").val());
            }
        );
        
        // Action lorsqu'on clique sur une étoile de note étudiant
        btnEtoileEtudiant.click(function () {
            $("#note-etudiant").val(i);  // Met à jour la note dans le champ caché
            miseAJourEtoiles(prefixIdEtudiant, i);
        });
        
        // Action lorsqu'on survole une étoile de note étudiant
        btnEtoileEtudiant.hover(
            function() {
                miseAJourEtoiles(prefixIdEtudiant, i);
            },
            function() {
                miseAJourEtoiles(prefixIdEtudiant, $("#note-etudiant").val());
            }
        );
    };
});

// Met à jour les 5 étoiles du filtre dont l'id est donné en paramètre
// Les étoiles <= note sont remplies, les autres sont vides
function miseAJourEtoiles(prefixClasse, note) {
    for (let i = 1; i <= 5; i++) {
        let idString = prefixClasse + i;
        let etoile = $("#" + idString).children();
        if (i <= note) {
            etoile.removeClass("fa-regular");
            etoile.addClass("fa-solid");
        } else {
            etoile.removeClass("fa-solid");
            etoile.addClass("fa-regular");
        }
    }
}