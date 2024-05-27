function afficherDetailOffre(offreDetails) {
    var offreDetailElement = document.getElementById('offre-detail');

    offreDetailElement.innerHTML = `
        <h2 style="text-align: center">${offreDetails.intitule}</h2>
        <p><strong>Filière :</strong> ${offreDetails.filiere}</p>
        <p>Lieu de travail : ${offreDetails.residence}</p>
        <p>Direction: ${offreDetails.direction}</p>
        <p>Type de recrutement: ${offreDetails.type_recrutement}</p>
        <p>Cadre: ${offreDetails.cadre}</p>
        <p>Date de prise de poste: ${offreDetails.date_prise_poste}</p>
        <p>Rémunération: ${offreDetails.remuneration}</p>
        <p>Missions: ${offreDetails.mission}</p>
        <p>Profil: ${offreDetails.profil}</p>
        <p>Spécificités: ${offreDetails.specificitees}</p>
        <p>Conditions: ${offreDetails.conditions}</p>
    `;
}

var offreButtons = document.getElementsByClassName('test');
for (var i = 0; i < offreButtons.length; i++) {
    offreButtons[i].addEventListener('click', function() {
        var offreDetails = {
            intitule: this.getAttribute('data-intitule'),
            filiere: this.getAttribute('data-filiere'),
            residence: this.getAttribute('data-lieu-travail'),
            direction: this.getAttribute('data-direction'),
            type_recrutement: this.getAttribute('data-type-recrutement'),
            cadre: this.getAttribute('data-cadre'),
            date_prise_poste: this.getAttribute('data-date-prise-poste'),
            remuneration: this.getAttribute('data-remuneration'),
            mission: this.getAttribute('data-mission'),
            profil: this.getAttribute('data-profil'),
            specificitees: this.getAttribute('data-specificitees'),
            conditions: this.getAttribute('data-conditions')
        };
        afficherDetailOffre(offreDetails);
    });
}
