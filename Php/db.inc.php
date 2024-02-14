<?php

function connect_db() {
    $dsn = 'mysql:dbname=hackers_poulette;host=localhost';
    $user = 'phpmyadmin';
    $password = 'rA4$tk7#LoPz&';
    $pdo = new PDO($dsn, $user, $password);

    return $pdo;
}