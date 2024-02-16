<?php
session_start(); 

$myUsername = ''; // a modifier
$myPassword = ''; // a modifier
$hashedPassword = password_hash($myPassword, PASSWORD_DEFAULT);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $myUsername && password_verify($password, $hashedPassword)) {
        $_SESSION['loggedin'] = true; 
        header("Location: dashboard.php"); 
        exit;
    } else {

        $_SESSION['error'] = "Identifiants incorrects";
        echo"Identifiants incorrects";
        header("Location: login.php"); 
        exit;
    }
} else {

    header("Location: login.php");
    exit;
}
?>
            </div>
                        <div class="form_boutton mt-3 self-center text-center">
    <a href="../index.html" class="text-zinc-400 s-center">Retour</a>
</div>