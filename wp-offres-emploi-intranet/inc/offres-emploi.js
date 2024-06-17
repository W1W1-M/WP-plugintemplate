function afficherDetailOffre(offreDetails) {
    var offreDetailElement = document.getElementById('offre-detail');

    offreDetailElement.innerHTML = `
        <h3 style="text-align: center">${offreDetails.intitule}</h3>
        <h5>Identification du poste</h5>
        <p><strong>Filière :</strong> ${offreDetails.filiere}</p>
        <p><strong>Lieu de travail :</strong> ${offreDetails.residence}</p>
        <p><strong>Direction :</strong> ${offreDetails.direction}</p>
        <p><strong>Type de recrutement :</strong> ${offreDetails.type_recrutement}</p>
        <p><strong>Cadre :</strong> ${offreDetails.cadre}</p>
        <p><strong>Date de prise de poste :</strong> ${offreDetails.date_prise_poste}</p>
        <p><strong>Rémunération :</strong> ${offreDetails.remuneration}</p>
        <h5>Missions et responsabilités</h5>
        <p><strong>Missions :</strong> ${offreDetails.mission}</p>
        <h5>Profil et compétences</h5>
        <p><strong>Profil :</strong> ${offreDetails.profil}</p>
        <h5>Spécificités d'embauche</h5>
        <p><strong>Spécificités :</strong> ${offreDetails.specificitees}</p>
        <h5>Conditions d'embauche</h5>
        <p><strong>Conditions :</strong> ${offreDetails.conditions}</p>
    `;
}

var offreButtons = document.getElementsByClassName('offre-specifique-emploi-intranet');
for (var i = 0; i < offreButtons.length; i++) {
    offreButtons[i].addEventListener('click', function() {
        var currentlyActive = document.querySelector('.offre-specifique-emploi-intranet.active');
        var offreDetailElement = document.getElementById('offre-detail');

        if (currentlyActive && currentlyActive !== this) {
            currentlyActive.classList.remove('active');
        }

        if (this.classList.contains('active')) {
            this.classList.remove('active');
            offreDetailElement.innerHTML = '';
        } else {
            this.classList.add('active');
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
        }
    });
}
