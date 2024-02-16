<?php
require_once("./db.inc.php");
$pdo = connect_db();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['description'], $_FILES['photo'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['mail'];
        $description = $_POST['description'];
        $photo = $_FILES['photo'];
        $captchaResponse = $_POST['g-recaptcha-response'];

        $secretKey = '6Lfy2nMpAAAAAHDe5vR8eyk8bC8wIEVWtM34kab5';
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secretKey,
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

        if (!$captchaResult['success']) {
            $errors[] = "Captcha not valid.";
        } else {
            if (empty($nom) || empty($prenom) || empty($email) || empty($description)) {
                $errors[] = "Tous les champs sont obligatoires.";
            } else {
        if (strlen($nom) < 2 || strlen($nom) > 255) {
            $errors[] = "Le nom doit contenir entre 2 et 255 caractères.";
        }
        if (strlen($prenom) < 2 || strlen($prenom) > 255) {
            $errors[] = "Le prénom doit contenir entre 2 et 255 caractères.";
        }

        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors[] = "adresse e-mail non valide.";
        }
        if (strlen($description) < 2 || strlen($description) > 1000) {
            $errors[] = "La description doit contenir entre 2 et 1000 caractères.";
        }

        $extension = [ 'jpg', 'png', 'gif'];
        $tailleFichier = 2 * 1024 * 1024;
        $photoExtensions = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));

        if(!in_array($photoExtensions, $extension)) {
            $errors[] = "Le fichier doit etre au format jpg,png ou gif";
        }

        if($photo['size'] > $tailleFichier) {
            $errors[] = "la taille du fichier dépasse la limite autorisée (2 Mo)";
        }
        
        if (empty($errors)) {
                    $enregistrementImage = '../img/';
                    $cheminFichier = $enregistrementImage . $photo['name'];

                    if (move_uploaded_file($photo['tmp_name'], $cheminFichier)) {
                        $requete = "INSERT INTO contacts (nom, prenom, mail, description, photo) VALUES (?, ?, ?, ?, ?)";
                        $stm = $pdo->prepare($requete);
                        $succes = $stm->execute([$nom, $prenom, $email, $description, $cheminFichier]);

                        if (!$succes) {
                            $errors[] = "Erreur SQL : " . $stm->errorInfo()[2];
                        } else {
                            header("Location: postread.php");
                            exit();
                        }
                    } else {
                        $errors[] = "Une erreur s'est produite lors de l'enregistrement du fichier.";
                    }
                }
            }
        }
    } else {
        $errors[] = "Tous les champs sont obligatoires.";
    }
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
}
?>