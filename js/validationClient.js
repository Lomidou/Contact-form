console.log('hello');
const form = document.querySelector('#form');

const messageConfirmation = document.createElement('div');
messageConfirmation.className = 'message-confirmation';
messageConfirmation.textContent = 'Merci ! Votre formulaire a bien été validé.';
messageConfirmation.style.display = 'none';

document.body.appendChild(messageConfirmation);

form.addEventListener('submit', function (event) {
    event.preventDefault();

    const nom = document.getElementById('nom').value.trim();
    const prenom = document.getElementById('prenom').value.trim();
    const mail = document.getElementById('mail').value.trim();
    const photo = document.getElementById('photo').value.trim();
    const description = document.getElementById('description').value.trim();

    const erreurs = [];

    function messageErreur(imputId, message) {
        const erreur = document.getElementById(imputId + '-error');
        erreur.textContent = message;
        document.getElementById(imputId).value = '';
        erreurs.push(imputId);
    }


    if (nom.length < 2 || nom.length > 255) {
        messageErreur('nom', 'Le nom doit contenir un minimum de 2 et un maximum de 255 caractères');
    }

    if (prenom.length < 2 || prenom.length > 255) {
        messageErreur('prenom', 'Le prénom doit contenir un minimum de 2 et un maximum de 255 caractères');

    }
    if (mail.length < 2 || mail.length > 255 || !mailvalide(mail)) {
        messageErreur('mail', 'Veuillez entrer une adresse e-mail valide.');

    }
    if (photo && !photovalide(photo)) {
        messageErreur('photo', 'Le fichier doit être au format JPG, PNG ou GIF.');

    }
    if (description.length < 2 || description.length > 1000) {
        messageErreur('description', 'La description doit contenir entre 2 et 1000 caractères.');

    }

    if (erreurs.length > 0) {
        return;
    }

    messageConfirmation.style.display = 'block';
    form.style.display = 'none';

    form.submit();
})

function mailvalide(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function photovalide(fileName) {
    const fileExtension = fileName.split('.').pop().toLowerCase();
    return ['jpg', 'png', 'gif'].includes(fileExtension);
}