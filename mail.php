<?php
require_once("./Php/db.inc.php");

$pdo = connect_db();
if ($pdo) {
    echo "Connexion à la base de données réussie.<br>";
} else {
    echo "Échec de la connexion à la base de données.<br>";
}

//required files
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


function sendEmail($subject, $message, $userEmail) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                  
        $mail->Host       = 'smtp.gmail.com';             
        $mail->SMTPAuth   = true;                         
        $mail->Username   = 'mail@gmail.com';  // à Modifier  compte Google
        $mail->Password   = 'motdepassegoogle';   // à Modifier mot de passe du compte Google
        $mail->SMTPSecure = 'ssl';                        
        $mail->Port       = 465;                          


        $mail->setFrom('mail@gmail.com', 'PrénomQuiEnvoieleMail'); // Expéditeur à modifier
        $mail->addAddress($userEmail); //  destinataire

        $mail->isHTML(true);                               
        $mail->Subject = $subject;                         
        $mail->Body    = $message;                         

        if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $mail->send();
            echo 'Le message a bien été envoyé.';
        } else {
            echo "L'adresse e-mail de l'utilisateur n'est pas valide.";
        }
    } catch (Exception $e) {
        echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
    }
}

$userEmail = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mail'])) {
        $userEmail = $_POST['mail'];
        sendEmail('Formulaire', 'Merci pour votre mail, nous avons bien reçu le formulaire', $userEmail);
    }
}

?>