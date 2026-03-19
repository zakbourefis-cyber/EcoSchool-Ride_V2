<?php
require_once 'include/header.php';
require_once 'config.php';
require_once 'include/fonctions.php';
require_once 'include/connexion.php';
require_once 'include/menu.php';
?>

<div class="container">

    <!-- section hero -->
    <div class="hero">
        <div class="hero_icone">🚌</div>
        <h1>Bienvenue sur <span class="text_vert">EcoSchool Ride</span></h1>
        <p>La solution de transport scolaire écologique et sécurisée pour vos enfants. Réservez facilement des trajets avec nos conducteurs partenaires certifiés.</p>

        <?php if (!isConnecte()): ?>
            <a href="/inscription.php" class="btn">🌿 Commencer maintenant</a>
        <?php else: ?>
            <a href="/parent/trajets.php" class="btn">🔍 Voir les trajets</a>
        <?php endif; ?>
    </div>

    <!-- les 4 cartes -->
    <div class="cartes_features">

        <div class="carte_feature">
            <div class="carte_icone">🛡️</div>
            <h3>100% Sécurisé</h3>
            <p>Tous nos conducteurs sont vérifiés et formés pour le transport d'enfants</p>
        </div>

        <div class="carte_feature">
            <div class="carte_icone">🌿</div>
            <h3>Écologique</h3>
            <p>Véhicules propres et covoiturage pour réduire l'empreinte carbone</p>
        </div>

        <div class="carte_feature">
            <div class="carte_icone">🕐</div>
            <h3>Ponctuel</h3>
            <p>Suivi en temps réel et notifications pour une tranquillité d'esprit totale</p>
        </div>

        <div class="carte_feature">
            <div class="carte_icone">💶</div>
            <h3>Économique</h3>
            <p>Tarifs compétitifs grâce à l'optimisation des trajets partagés</p>
        </div>

    </div>

    <!-- section chiffres -->
    <div class="section_chiffres">
        <h2>📈 Nos chiffres</h2>
        <div class="grille_chiffres">

            <div class="carte_chiffre">
                <div class="chiffre_icone" style="background-color: #2d6a4f;">👨‍👩‍👧</div>
                <div>
                    <strong>2 500+</strong>
                    <span>Familles inscrites</span>
                </div>
            </div>

            <div class="carte_chiffre">
                <div class="chiffre_icone" style="background-color: #0077b6;">🚌</div>
                <div>
                    <strong>150</strong>
                    <span>Trajets quotidiens</span>
                </div>
            </div>

            <div class="carte_chiffre">
                <div class="chiffre_icone" style="background-color: #f77f00;">🚗</div>
                <div>
                    <strong>45</strong>
                    <span>Conducteurs certifiés</span>
                </div>
            </div>

            <div class="carte_chiffre">
                <div class="chiffre_icone" style="background-color: #1b4332;">🌱</div>
                <div>
                    <strong>12T</strong>
                    <span>CO2 économisé/an</span>
                </div>
            </div>

        </div>
    </div>

</div>

<?php require_once 'include/footer.php'; ?>
