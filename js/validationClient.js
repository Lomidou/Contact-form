console.log('test validation.js');

// Si formulaire validé
function ConfirmationEnvoi() {
    const Confirmation = document.createElement('div');
    Confirmation.className = 'Confirmation';
    Confirmation.textContent = 'Votre formulaire a bien été envoyé. Nous reviendrons vers vous dans les plus brefs délais';
    document.body.appendChild(Confirmation);
    return Confirmation;
}

// Si pas formulaire pas validé
const ERROR_MESSAGES = {
    nom: "Le nom n'est pas valide : minimum 2 et maximum 255 caractères",
    prenom: "Le prénom n'est pas valide : minimum de 2 et maximum 255 caractères",
    mail: "L'adresse mail n'est pas valide",
    photo: "Le fichier doit être au format JPG, PNG ou GIF.",
    description: "La description n'est pas valide : minimum 2 et maximum 1000 caractères."
};

function afficherMessageErreur(inputId, message) {
    const error = document.getElementById(inputId + '-invalide');
    error .textContent = message;
    error .style.display = 'block';
}

function cacherMessageErreur() {
    const invalidate = document.querySelectorAll('.invalide-message');
    invalidate.forEach(erreur => erreur.style.display = 'none');
}

// conditions validation
function validationNom(nom) {
    return nom.length >= 2 && nom.length <= 255;
}

function validationPrenom(nom) {
    return nom.length >= 2 && nom.length <= 255;
}

function validationMail(mail) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return mail.length >= 2 && mail.length <= 255 && emailRegex.test(mail);
}

function validationPhoto(fileName) {
    const extensionRegex = /\.(jpg|jpeg|png|gif)$/i;
    const fileExtension = fileName.split('.').pop().toLowerCase();
    return extensionRegex.test(fileName) && ['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension);
}

function validationDescription(description) {
    return description.length >= 2 && description.length <= 1000;
}

// Envoi du formulaire validé
const form = document.querySelector('#form');
form.addEventListener('submit', function (event) {

    event.preventDefault();
    cacherMessageErreur();

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const mail = document.getElementById('mail').value.trim();
    const photo = document.getElementById('photo').value.trim();
    const description = document.getElementById('description').value.trim();

    const invalidation = [];

    if (!validationNom(nom)) {
        afficherMessageErreur('nom', ERROR_MESSAGES.nom);
        invalidation.push('nom');
    }

    if (!validationNom(prenom)) {
        afficherMessageErreur('prenom', ERROR_MESSAGES.prenom);
        invalidation.push('prenom');
    }

    if (!validationMail(mail)) {
        afficherMessageErreur('mail', ERROR_MESSAGES.mail);
        invalidation.push('mail');
    }

    if (photo && !validationPhoto(photo)) {
        afficherMessageErreur('photo', ERROR_MESSAGES.photo);
        invalidation.push('photo');
    }

    if (!validationDescription(description)) {
        afficherMessageErreur('description', ERROR_MESSAGES.description);
        invalidation.push('description');
    }

    if (invalidation.length === 0) {
        ConfirmationEnvoi();
        form.submit();
    }
});



