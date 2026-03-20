<?php
// chemin de base du projet
define('BASE_URL', '/Projets/EcoSchool-Ride_V2');

// infos de connexion a la base
$host = getenv("HOST");
$dbname = getenv("DB_NAME");
$user = getenv("USER");
$password = getenv("PASS_BD");

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}