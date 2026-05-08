<?php
require_once __DIR__ . '/connexion.php';

// Fonction pour vérifier si la page est active
function isActive($url_part) {
    return (strpos($_SERVER['REQUEST_URI'], $url_part) !== false) ? 'active' : '';
}
?>
<nav>
    <a class="nav-logo" href="<?php echo BASE_URL; ?>/index.php">
        <img src="<?php echo BASE_URL; ?>/img/logo.png" alt="EcoSchool Ride" height="38">
    </a>

    <?php if (isConnecte()): ?>
        <?php if (isAdmin()): ?>
            <a class="link <?php echo isActive('dashboard.php'); ?>" href="<?php echo BASE_URL; ?>/admin/dashboard.php">
                <i class="fa-solid fa-gauge"></i> <span>Tableau de bord</span>
            </a>
        <?php else: ?>
            <a class="link <?php echo isActive('trajets.php'); ?>" href="<?php echo BASE_URL; ?>/parent/trajets.php">
                <i class="fa-solid fa-route"></i> <span>Trajets</span>
            </a>
            <a class="link <?php echo isActive('mes_enfants.php'); ?>" href="<?php echo BASE_URL; ?>/parent/mes_enfants.php">
                <i class="fa-solid fa-children"></i> <span>Mes enfants</span>
            </a>
            <a class="link <?php echo isActive('mes_inscriptions.php'); ?>" href="<?php echo BASE_URL; ?>/parent/mes_inscriptions.php">
                <i class="fa-solid fa-list-check"></i> <span>Inscriptions</span>
            </a>
        <?php endif; ?>
        
        <a class="link <?php echo isActive('parent_messagerie.php'); ?>" href="<?php echo BASE_URL; ?>/parent_messagerie.php">
            <i class="fa-solid fa-comments"></i> <span>Messagerie</span>
        </a>
        
        <a class="link" href="<?php echo BASE_URL; ?>/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> <span>Déconnexion</span>
        </a>
    <?php else: ?>
        <a class="link <?php echo isActive('login.php'); ?>" href="<?php echo BASE_URL; ?>/login.php">
            <i class="fa-solid fa-right-to-bracket"></i> <span>Connexion</span>
        </a>
        <a class="btn-nav link <?php echo isActive('inscription.php'); ?>" href="<?php echo BASE_URL; ?>/inscription.php">
            <i class="fa-solid fa-user-plus"></i> <span>Inscription</span>
        </a>
    <?php endif; ?>
</nav>