<?php

function connect_db() {
    $dsn = 'mysql:dbname=;host=';// a modifier
    $user = '';// a modifier
    $password = '';// a modifier
    $pdo = new PDO($dsn, $user, $password);

    return $pdo;
}