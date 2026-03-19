<?php

// recuperer tous les trajets
function get_all_trajets($pdo) {
    $sql = "SELECT t.*, c.nom, c.prenom, v.capacite_totale
            FROM trajets t
            JOIN conducteurs c ON t.id_conducteur = c.id_conducteur
            JOIN vehicules v ON c.id_vehicule = v.id_vehicule";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// compter les places prises sur un trajet
function get_places_prises($pdo, $id_trajet) {
    $sql = "SELECT COUNT(*) FROM inscriptions WHERE id_trajet = ? AND statut = 'VALIDE'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_trajet]);
    return $stmt->fetchColumn();
}

// recuperer les enfants d'un parent
function get_enfants_parent($pdo, $id_parent) {
    $sql = "SELECT * FROM enfants WHERE id_parent = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_parent]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// recuperer les inscriptions d'un enfant
function get_inscriptions_enfant($pdo, $id_enfant) {
    $sql = "SELECT i.*, t.point_depart, t.destination, t.horaire
            FROM inscriptions i
            JOIN trajets t ON i.id_trajet = t.id_trajet
            WHERE i.id_enfant = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_enfant]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// recuperer un parent par son email
function get_parent_by_email($pdo, $email) {
    $sql = "SELECT * FROM parents WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// recuperer tous les conducteurs
function get_all_conducteurs($pdo) {
    $sql = "SELECT c.*, v.modele, v.capacite_totale
            FROM conducteurs c
            LEFT JOIN vehicules v ON c.id_vehicule = v.id_vehicule";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// recuperer tous les vehicules
function get_all_vehicules($pdo) {
    $sql = "SELECT * FROM vehicules";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// recuperer les demandes en attente
function get_demandes_attente($pdo) {
    $sql = "SELECT i.*, e.prenom AS prenom_enfant, p.nom AS nom_parent, p.prenom AS prenom_parent,
                   t.point_depart, t.destination, t.horaire
            FROM inscriptions i
            JOIN enfants e ON i.id_enfant = e.id_enfant
            JOIN parents p ON e.id_parent = p.id_parent
            JOIN trajets t ON i.id_trajet = t.id_trajet
            WHERE i.statut = 'EN_ATTENTE'
            ORDER BY i.date_demande ASC";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
