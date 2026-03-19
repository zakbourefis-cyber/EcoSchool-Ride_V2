<?php
require_once '../include/header.php';
require_once '../config.php';
require_once '../include/fonctions.php';
require_once '../include/connexion.php';

require_connexion();
require_admin();

require_once '../include/menu.php';

// on recupere tous les trajets
$tous_trajets = get_all_trajets($pdo);

// calcul des stats pour les cartes du haut
$total_places_prises = 0;
$total_places_proposees = 0;
$nb_trajets_confirmes = 0;
$nb_trajets_renforcer = 0;

for ($i = 0; $i < count($tous_trajets); $i++) {
    $trajet = $tous_trajets[$i];
    $places_prises = get_places_prises($pdo, $trajet['id_trajet']);

    $total_places_prises += $places_prises;
    $total_places_proposees += $trajet['places_proposees'];

    // trajet confirme = au moins une place prise
    if ($places_prises > 0) {
        $nb_trajets_confirmes++;
    }

    // trajet a renforcer = complet
    if ($places_prises >= $trajet['places_proposees']) {
        $nb_trajets_renforcer++;
    }
}

// taux de remplissage moyen
$taux_remplissage = 0;
if ($total_places_proposees > 0) {
    $taux_remplissage = round(($total_places_prises / $total_places_proposees) * 100);
}

// demandes en attente
$demandes_attente = get_demandes_attente($pdo);
$nb_attente = count($demandes_attente);
?>

<div class="container">
    <h1>🎛️ Tableau de bord - Gestionnaire</h1>

    <!-- les 4 cartes stats -->
    <div class="grille_stats">

        <div class="carte_stat">
            <div class="stat_icone icone_vert">🚌</div>
            <div>
                <strong><?php echo $taux_remplissage; ?>%</strong>
                <span>Taux de remplissage moyen</span>
            </div>
        </div>

        <div class="carte_stat">
            <div class="stat_icone icone_orange">⏳</div>
            <div>
                <strong><?php echo $nb_attente; ?></strong>
                <span>Demandes en attente</span>
            </div>
        </div>

        <div class="carte_stat">
            <div class="stat_icone icone_rouge">⚠️</div>
            <div>
                <strong><?php echo $nb_trajets_renforcer; ?></strong>
                <span>Trajets à renforcer</span>
            </div>
        </div>

        <div class="carte_stat">
            <div class="stat_icone icone_bleu">✅</div>
            <div>
                <strong><?php echo $nb_trajets_confirmes; ?></strong>
                <span>Trajets confirmés</span>
            </div>
        </div>

    </div>

    <!-- tableau de remplissage par trajet -->
    <div class="bloc_dashboard">
        <h2>📊 Taux de remplissage par trajet</h2>

        <?php if (count($tous_trajets) == 0): ?>
            <p>Aucun trajet créé. <a href="trajets.php">Créer un trajet</a></p>
        <?php else: ?>

        <table>
            <tr>
                <th>Trajet</th>
                <th>Conducteur</th>
                <th>Horaire</th>
                <th>Capacité</th>
                <th>Remplissage</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>

            <?php for ($i = 0; $i < count($tous_trajets); $i++): ?>
                <?php
                $trajet = $tous_trajets[$i];
                $places_prises = get_places_prises($pdo, $trajet['id_trajet']);
                $places_dispo = $trajet['places_proposees'] - $places_prises;

                // calcul du pourcentage pour la barre
                $pourcentage = 0;
                if ($trajet['places_proposees'] > 0) {
                    $pourcentage = round(($places_prises / $trajet['places_proposees']) * 100);
                }

                // couleur de la barre selon remplissage
                $couleur_barre = "#52b788"; // vert
                if ($pourcentage >= 75) {
                    $couleur_barre = "#f77f00"; // orange
                }
                if ($pourcentage >= 100) {
                    $couleur_barre = "#d62828"; // rouge
                }
                ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($trajet['point_depart']); ?></strong> → <?php echo htmlspecialchars($trajet['destination']); ?></td>
                    <td><?php echo htmlspecialchars($trajet['prenom'] . " " . $trajet['nom']); ?></td>
                    <td><?php echo $trajet['horaire']; ?></td>
                    <td><?php echo $places_prises . "/" . $trajet['places_proposees']; ?></td>
                    <td>
                        <!-- barre de remplissage -->
                        <div class="barre_fond">
                            <div class="barre_remplissage" style="width: <?php echo $pourcentage; ?>%; background-color: <?php echo $couleur_barre; ?>;"></div>
                        </div>
                    </td>
                    <td>
                        <?php if ($places_dispo <= 0): ?>
                            <span class="badge_rouge">Complet</span>
                        <?php elseif ($places_dispo == 1): ?>
                            <span class="badge_orange">1 place</span>
                        <?php else: ?>
                            <span class="badge_vert">Disponible</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($places_dispo <= 0): ?>
                            <a class="btn btn_orange" href="demandes.php">Renforcer</a>
                        <?php else: ?>
                            <a class="btn" href="demandes.php">Détails</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endfor; ?>
        </table>

        <?php endif; ?>
    </div>

    <!-- liens rapides gestion -->
    <div class="bloc_dashboard">
        <h2>⚙️ Gestion</h2>
        <div class="liens_gestion">
            <a class="btn" href="demandes.php">📋 Demandes en attente (<?php echo $nb_attente; ?>)</a>
            <a class="btn" href="trajets.php">🗺️ Créer un trajet</a>
            <a class="btn" href="conducteurs.php">👤 Ajouter un conducteur</a>
            <a class="btn" href="vehicules.php">🚗 Ajouter un véhicule</a>
        </div>
    </div>

</div>

<?php require_once '../include/footer.php'; ?>
