<?php

function connect_db() {
    $dsn = 'mysql:dbname=hackers_poulette;host=localhost';
    $user = 'root';
    $password = 'root';
    $pdo = new PDO($dsn, $user, $password);

    return $pdo;
}