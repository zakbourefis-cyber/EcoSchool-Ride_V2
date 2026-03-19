<?php
require_once __DIR__ . '/connexion.php';
?>
<nav>
    <a href="/index.php">🌿 EcoSchool Ride</a>

    <?php if (isConnecte()): ?>
        <?php if (isAdmin()): ?>
            <a href="/admin/dashboard.php">Tableau de bord</a>
        <?php else: ?>
            <a href="/parent/trajets.php">Trajets</a>
            <a href="/parent/mes_enfants.php">Mes enfants</a>
        <?php endif; ?>
        <a href="/logout.php">Déconnexion</a>
    <?php else: ?>
        <a href="/login.php">Connexion</a>
        <a href="/inscription.php">Inscription</a>
    <?php endif; ?>
</nav>
