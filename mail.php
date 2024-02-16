<?php
require_once("./Php/db.inc.php");

$pdo = connect_db();
if ($pdo) {
    echo "Connexion à la base de données réussie.<br>";
} else {
    echo "Échec de la connexion à la base de données.<br>";
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
 

function sendEmail($subject, $message) {
  
    $mail = new PHPMailer(true);

    try {
     
        $mail->isSMTP();                                  
        $mail->Host       = 'smtp.gmail.com';             
        $mail->SMTPAuth   = true;                         
        $mail->Username   ='mail@gmail.com';  //a modifier
        $mail->Password   = 'motdepassegoogle';   //a modifier     
        $mail->SMTPSecure = 'ssl';                        
        $mail->Port       = 465                          

        // Sender and recipient
        $mail->setFrom('mail@gmail.com', 'thomas');//a modifier
        $mail->addAddress('mail@gmail.com');    //a modifier

        // Email content
        $subject = 'Formulaire de contact';
        $message = "Merci d'avoir rempli le formulaire de contact";
        $mail->isHTML(true);                               
        $mail->Subject = $subject;                         
        $mail->Body    = $message;                         

        // Send the email
        $mail->send();
        echo 'Le message a bien été envoyé.';

    } catch (Exception $e) {
        echo "Une erreur est survenue lors de l'envoi du message : {$mail->ErrorInfo}";
    }
}

// Call the function to send the email
sendEmail('Merci pour votre mail', 'Merci pour votre mail.');

?>