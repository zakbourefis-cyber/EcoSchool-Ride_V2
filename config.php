<?php

// chemin de base du projet - a adapter selon ton dossier
define('BASE_URL', '/Projets/EcoSchool-Ride_V2');

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