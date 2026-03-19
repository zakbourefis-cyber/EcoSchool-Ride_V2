<?php

// chemin de base du projet pour le css
define('BASE_URL', '/ecoschool_ride');

// infos de connexion a la base
$host = "localhost";
$dbname = "echoschool_ride";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}