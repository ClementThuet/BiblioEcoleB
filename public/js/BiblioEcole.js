function ConfirmMessageEleve() {
    if (confirm("Voulez-vous vraiment supprimer cet élève ?")) {
        // Clic sur OK
        var elementEleveId = document.querySelector('.js-eleve-id');
        var eleveId = elementEleveId.dataset.idEleve;
        window.location.href = "/BibliothequeEcole/public/Eleve/Supprimer/"+eleveId;
    }
}

function ConfirmMessageLivre() {
    if (confirm("Voulez-vous vraiment supprimer ce livre ?")) {
        // Clic sur OK
        var elementLivreId = document.querySelector('.js-livre-id');
        var livreId = elementLivreId.dataset.idLivre
        window.location.href = "/BibliothequeEcole/public/Bibliotheque/Supprimer/"+livreId;
    }
}