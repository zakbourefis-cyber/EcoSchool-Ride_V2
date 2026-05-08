<?php
session_start();
require_once 'config.php';

// Ce fichier est appelé uniquement en AJAX, il répond toujours en JSON
header('Content-Type: application/json');

$id_parent = $_SESSION['id_parent'] ?? null;

if (!$id_parent) {
    echo json_encode(['succes' => false, 'erreur' => 'Session expirée.']);
    exit;
}

$id_conducteur = intval($_POST['id_destinataire'] ?? 0); //assure que l'id est en nb entier (securite)
$contenu       = trim($_POST['message'] ?? '');

if ($id_conducteur <= 0 || $contenu === '') {
    echo json_encode(['succes' => false, 'erreur' => 'Données manquantes.']);
    exit;
}

// Vérifie si une conversation existe déjà entre ce parent et ce conducteur
$stmt = $pdo->prepare("SELECT id_conversation FROM discussion_membres
                       WHERE id_parent = ? AND id_conducteur = ? LIMIT 1");
$stmt->execute([$id_parent, $id_conducteur]);
$conv = $stmt->fetch();

if ($conv) {
    $id_conversation = $conv['id_conversation'];
} else {
    // Pas de conversation existante : on en crée une dans la table 'conversation', puis on lie les deux personnes dans 'discussion_membres'
    $pdo->prepare("INSERT INTO conversations (date_creation) VALUES (NOW())")->execute();
    $id_conversation = $pdo->lastInsertId();

    $pdo->prepare("INSERT INTO discussion_membres (id_conversation, id_parent, id_conducteur) VALUES (?, ?, ?)")
        ->execute([$id_conversation, $id_parent, $id_conducteur]);
}

// Insère le message
$pdo->prepare("INSERT INTO messages (id_conversation, id_parent_expediteur, message, date_envoi)
               VALUES (?, ?, ?, NOW())")
    ->execute([$id_conversation, $id_parent, $contenu]);

echo json_encode(['succes' => true]);
exit;