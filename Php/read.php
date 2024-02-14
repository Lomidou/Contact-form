<?php
session_start();

require_once("./db.inc.php");
$pdo = connect_db();

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mail']) || empty($_POST['description']) || empty($_FILES['photo']) || empty($_POST['captcha'])) {
        $errors[] = "Tous les champs sont obligatoires.";
    } else if (!isset($_SESSION['captcha']) || $_POST['captcha'] !== $_SESSION['captcha']) {
        $errors[] = "Captcha invalide.";
    } else {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['mail'];
        $description = $_POST['description'];
        $photo = $_FILES['photo'];

        if(empty($nom)||empty($prenom)||empty($email)||empty($description)){
            $errors[] = "tous les champs sont obligatoire.";
        }else{
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
            }
                

            if (!move_uploaded_file($photo['tmp_name'], $cheminFichier)) {
                $errors[] = "Une erreur s'est produite lors de l'enregistrement du fichier.";
            } else {
                $requete = "INSERT INTO contacts (nom, prenom, mail, description, photo) VALUES (?, ?, ?, ?, ?)";
                $stm = $pdo->prepare($requete);
                $succes = $stm->execute([$nom, $prenom, $email, $description, $cheminFichier]);

                if (!$succes) {
                    $errors[] = "Erreur SQL : " . $stm->errorInfo()[2];
                }
            }
        }
    } 
}else {
        $errors[] = "tous les champs sont obligatoire.";
}