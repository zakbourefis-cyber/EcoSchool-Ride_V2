<?php
require_once '../include/header.php';
require_once '../config.php';
require_once '../include/fonctions.php';
require_once '../include/connexion.php';

require_connexion();

$id_parent = $_SESSION['id_parent'];

// on recupere tous les enfants du parent
$liste_enfants = get_enfants_parent($pdo, $id_parent);

require_once '../include/menu.php';
?>

<div class="container">
    <h1>📋 Mes inscriptions</h1>

    <?php if (count($liste_enfants) == 0): ?>
        <p>Aucun enfant enregistré. <a href="mes_enfants.php">Ajouter un enfant</a></p>
    <?php else: ?>

        <?php for ($i = 0; $i < count($liste_enfants); $i++): ?>
            <?php
            $enfant = $liste_enfants[$i];
            $inscriptions_enfant = get_inscriptions_enfant($pdo, $enfant['id_enfant']);
            ?>

            <div class="bloc_enfant">
                <h2>👦 <?php echo htmlspecialchars($enfant['prenom']); ?></h2>

                <?php if (count($inscriptions_enfant) == 0): ?>
                    <p>Aucune inscription pour cet enfant. <a href="trajets.php?id_enfant=<?php echo $enfant['id_enfant']; ?>">Réserver un trajet</a></p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Départ</th>
                            <th>Destination</th>
                            <th>Horaire</th>
                            <th>Date demande</th>
                            <th>Statut</th>
                        </tr>

                        <?php for ($j = 0; $j < count($inscriptions_enfant); $j++): ?>
                            <?php $inscription = $inscriptions_enfant[$j]; ?>
                            <tr>
                                <td><?php echo htmlspecialchars($inscription['point_depart']); ?></td>
                                <td><?php echo htmlspecialchars($inscription['destination']); ?></td>
                                <td><?php echo $inscription['horaire']; ?></td>
                                <td><?php echo $inscription['date_demande']; ?></td>
                                <td>
                                    <?php if ($inscription['statut'] == 'VALIDE'): ?>
                                        <span class="badge_vert">✅ Validé</span>
                                    <?php else: ?>
                                        <span class="badge_orange">⏳ En attente</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endfor; ?>

                    </table>
                <?php endif; ?>
            </div>

        <?php endfor; ?>

    <?php endif; ?>

    <br>
    <a class="btn" href="trajets.php">+ Réserver un autre trajet</a>
</div>

<?php require_once '../include/footer.php'; ?>
