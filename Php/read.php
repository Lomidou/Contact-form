<?php
require_once("./db.inc.php");
$pdo = connect_db();

const CAPTCHA_SECRET_KEY = ''; // à modifier
const MAX_FILE_SIZE = 2 * 1024 * 1024;
const VALID_IMAGE_EXTENSIONS = ['jpg', 'png', 'gif'];

function validateLength($value, $minLength, $maxLength, $errorMessage) {
    if (strlen($value) < $minLength || strlen($value) > $maxLength) {
        return $errorMessage;
    }
    return null;
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validateImage($photo) {
    $extension = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, VALID_IMAGE_EXTENSIONS)) {
        return "Format jpg, png ou gif obligatoire";
    }
    if ($photo['size'] > MAX_FILE_SIZE) {
        return "La taille dépasse la limite autorisée: 2 Mo";
    }
    return null;
}

function validateCaptcha($captchaResponse) {
    $url = '';  // à modifier
    $data = [
        'secret' => CAPTCHA_SECRET_KEY,
        'response' => $captchaResponse,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $captchaResult = json_decode($result, true);
    return $captchaResult['success'];
}

function handleFormSubmission() {
    $invalidations = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['description'], $_FILES['photo'], $_POST['g-recaptcha-response'])) {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['mail'];
            $description = $_POST['description'];
            $photo = $_FILES['photo'];
            $captchaResponse = $_POST['g-recaptcha-response'];

            if (!validateCaptcha($captchaResponse)) {
                $invalidations[] = "Captcha n'est pas valide";
            } else {
                $invalidations[] = validateLength($nom, 2, 255, "Nom invalide: il doit contenir entre 2 et 255 caractères.");
                $invalidations[] = validateLength($prenom, 2, 255, "Prénom invalide : doit contenir entre 2 et 255 caractères.");
                $invalidations[] = validateEmail($email) ? null : "E-mail non valide";
                $invalidations[] = validateLength($description, 2, 1000, "Description non valide: doit contenir entre 2 et 1000 caractères.");
                $invalidations[] = validateImage($photo);

                if (empty(array_filter($invalidations))) {
                    $enregistrementImage = '../img/';
                    $cheminFichier = $enregistrementImage . $photo['name'];

                    if (move_uploaded_file($photo['tmp_name'], $cheminFichier)) {
                        $requete = "INSERT INTO contacts (nom, prenom, mail, description, photo) VALUES (?, ?, ?, ?, ?)";
                        $stm = $pdo->prepare($requete);
                        $succes = $stm->execute([$nom, $prenom, $email, $description, $cheminFichier]);

                        if (!$succes) {
                            $invalidations[] = "Erreur SQL : " . $stm->errorInfo()[2];
                        } else {
                            header("Location: postread.php");
                            exit();
                        }
                    } else {
                        $invalidations[] = "Erreur lors de l'enregistrement du fichier.";
                    }
                }
            }
        } else {
            $invalidations[] = "Les champs ne peuvent pas être vides";
        }
    }
    if (!empty($invalidations)) {
        echo implode("<br>", $invalidations);
    }
}
handleFormSubmission();

?>
