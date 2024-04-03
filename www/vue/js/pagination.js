$(document).ready(function() {
    const formulaire = $("#form-filtres");
    const btnDebut = $("#pagination-debut");
    const btnPrecedent = $("#pagination-precedent");
    // const btnNumPrecedent = $("#pagination-numero-precedent");
    const btnNumActuel = $("#pagination-numero-actuel");
    // const btnNumSuivant = $("#pagination-numero-suivant");
    const btnSuivant = $("#pagination-suivant");
    const btnFin = $("#pagination-fin");

    const page = getPage();
    const nbPages = getNbPages();

    // S'il n'y a qu'une seule page, on cache la pagination
    if (nbPages <= 1) {
        $("#pagination").hide();
        return;
    }

    // console.log("page = " + page);
    // console.log("nbPages = " + nbPages);
    // console.log(page == 1);
    // console.log(page == nbPages);

    btnDebut.attr("hidden", page == 1);
    btnPrecedent.attr("hidden", page == 1);
    // btnNumPrecedent.attr("hidden", page == 1);
    btnNumActuel.attr("hidden", nbPages <= 1);
    btnSuivant.attr("hidden", page == nbPages);
    // btnNumSuivant.attr("hidden", page == nbPages);
    btnFin.attr("hidden", page == nbPages);
    
    btnDebut.attr("disabled", page == 1);
    // btnNumPrecedent.attr("disabled", page == 1);
    btnPrecedent.attr("disabled", page == 1);
    btnNumActuel.attr("disabled", false);
    // btnNumSuivant.attr("disabled", page == nbPages);
    btnSuivant.attr("disabled", page == nbPages);
    btnFin.attr("disabled", page == nbPages);

    // Gestion des événements
    btnDebut.click(function() {
        setPage(1);
        formulaire.submit();
    });
    
    // btnNumPrecedent.click(function () {
    //     if (page > 1) {
    //         setPage(page - 1);
    //         formulaire.submit();
    //     }
    // });
    
    // btnNumSuivant.click(function() {
    //     if (page < nbPages) {
    //         setPage(page + 1);
    //         formulaire.submit();
    //     }
    // });
    
    btnPrecedent.click(function () {
        if (page > 1) {
            setPage(page - 1);
            formulaire.submit();
        }
    });
    
    btnSuivant.click(function() {
        if (page < nbPages) {
            setPage(page + 1);
            formulaire.submit();
        }
    });
    
    btnFin.click(function() {
        if (page < nbPages) {
            setPage(nbPages);
            formulaire.submit();
        }
    });
});

function getPage() {
    return parseInt($("#page").val());
}

function getNbPages() {
    return parseInt($("#nb-pages").val());
}

function setPage(page) {
    $("#page").val(page);
}