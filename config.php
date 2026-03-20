<?php
// chemin de base du projet 
define('BASE_URL', '/Projets/EcoSchool-Ride_V2');

// infos de connexion a la base
$host = "51.68.91.213";
$dbname = "info1";
$user = "root";
$password = "T4n";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}