<?php

$host = "localhost";
$user = "root";
$password = "";
$dbname = "attendance";
$dsn = "mysql:host={$host};dbname={$dbname}";

try {
    $options = [
        PDO::ATTR_ERRMODE   => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    $pdo = new PDO($dsn, $user, $password, $options);
    $pdo->exec("SET time_zone = '+08:00';");

} catch (PDOException $e) {
    die("Error : ".$e->getMessage());
}

