<?php
function connect_db() {
    $dsn = 'mysql:dbname=hackers_poulette;host=localhost';
    $user = 'root';
    $password = 'rA4$tk7#LoPz&';
    $pdo = new PDO($dsn, $user, $password);

    return $pdo;
}
$pdo = connect_db();

if ($pdo) {
    echo "Connexion à la base de données établie avec succès.";
} else {
    echo "Erreur lors de la connexion à la base de données.";
}
?>