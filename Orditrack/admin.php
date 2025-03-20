<?php
// Vérification si l'utilisateur est admin et connecté
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?role=admin");
    exit;
}

// Connexion à la base de données pour récupérer les réservations/////
require 'config.php';

// Récupérer la valeur de la recherche si elle existe///////
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Convertir la recherche en format date SQL si elle ressemble à jj/mm/aaaa
$search_date = '';
if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $search, $matches)) {
    $search_date = "{$matches[3]}-{$matches[2]}-{$matches[1]}"; // Convertit en aaaa-mm-jj
}

// Récupérer les réservations en attente avec filtre de recherche/////////
$sql = "SELECT r.id, u.username AS user, p.numero_serie AS pc, r.date_debut, r.date_retour, CONCAT('RES-', LPAD(r.id, 4, '0')) AS numero_reservation
        FROM reservations r
        JOIN users u ON r.id_user = u.id
        JOIN pcs p ON r.id_pc = p.id
        WHERE r.status = 'en attente'
        AND (p.numero_serie LIKE :search 
             OR u.username LIKE :search 
             OR CONCAT('RES-', LPAD(r.id, 4, '0')) LIKE :search 
             OR DATE(r.date_debut) LIKE :search_date 
             OR DATE(r.date_retour) LIKE :search_date)";
$stmt = $pdo->prepare($sql);
$stmt->execute([':search' => "%$search%", ':search_date' => $search_date ? "%$search_date%" : "%$search%"]);
$reservations = $stmt->fetchAll();

// Récupérer le stock de PC disponibles avec filtre de recherche
$sql_stock = "SELECT id, numero_serie, status FROM pcs WHERE status = 'disponible' AND numero_serie LIKE :search";
$stmt_stock = $pdo->prepare($sql_stock);
$stmt_stock->execute([':search' => "%$search%"]);
$pcs_disponibles = $stmt_stock->fetchAll();

// Récupérer les PC en maintenance (SAV) avec filtre de recherche
$sql_sav = "SELECT id, numero_serie FROM pcs WHERE status = 'en réparation' AND numero_serie LIKE :search";
$stmt_sav = $pdo->prepare($sql_sav);
$stmt_sav->execute([':search' => "%$search%"]);
$pcs_sav = $stmt_sav->fetchAll();

// Récupérer les PC en prêt (colonne de droite) avec filtre de recherche
$sql_prêt = "SELECT r.id AS reservation_id, r.date_debut, r.date_retour, u.username AS user, p.numero_serie AS pc, CONCAT('RES-', LPAD(r.id, 4, '0')) AS numero_reservation
             FROM reservations r
             JOIN users u ON r.id_user = u.id
             JOIN pcs p ON r.id_pc = p.id
             WHERE r.status = 'validé'
             AND (p.numero_serie LIKE :search 
                  OR u.username LIKE :search 
                  OR CONCAT('RES-', LPAD(r.id, 4, '0')) LIKE :search 
                  OR DATE(r.date_debut) LIKE :search_date 
                  OR DATE(r.date_retour) LIKE :search_date)";
$stmt_prêt = $pdo->prepare($sql_prêt);
$stmt_prêt->execute([':search' => "%$search%", ':search_date' => $search_date ? "%$search_date%" : "%$search%"]);
$pcs_prêt = $stmt_prêt->fetchAll();

// Compter le total des PC/////////////////
$total_pcs_disponibles = count($pcs_disponibles);
$total_pcs_sav = count($pcs_sav);
$total_pcs_prêt = count($pcs_prêt);
// Calcul du total des PCs du parc
$total_pcs = $total_pcs_disponibles + $total_pcs_prêt + $total_pcs_sav;

// Gestion des sélections dans les listes déroulantes//////////
if (isset($_GET['selected_reservation'])) {
    $selected_id = $_GET['selected_reservation'];
    $selected_index = array_search($selected_id, array_column($reservations, 'id'));
    if ($selected_index !== false) {
        $selected_reservation = array_splice($reservations, $selected_index, 1)[0];
        array_unshift($reservations, $selected_reservation);
    }
}

if (isset($_GET['selected_pc'])) {
    $selected_id = $_GET['selected_pc'];
    $selected_index = array_search($selected_id, array_column($pcs_disponibles, 'id'));
    if ($selected_index !== false) {
        $selected_pc = array_splice($pcs_disponibles, $selected_index, 1)[0];
        array_unshift($pcs_disponibles, $selected_pc);
    }
}

if (isset($_GET['selected_prêt'])) {
    $selected_id = $_GET['selected_prêt'];
    $selected_index = array_search($selected_id, array_column($pcs_prêt, 'reservation_id'));
    if ($selected_index !== false) {
        $selected_prêt = array_splice($pcs_prêt, $selected_index, 1)[0];
        array_unshift($pcs_prêt, $selected_prêt);
    }
}

if (isset($_GET['selected_sav'])) {
    $selected_id = $_GET['selected_sav'];
    $selected_index = array_search($selected_id, array_column($pcs_sav, 'id'));
    if ($selected_index !== false) {
        $selected_sav = array_splice($pcs_sav, $selected_index, 1)[0];
        array_unshift($pcs_sav, $selected_sav);
    }
}

// Traitement de l'exportation vers XLS bouton history
if (isset($_GET['export_history'])) {
    $sql_all_reservations = "SELECT r.id, u.username AS user, p.numero_serie AS pc, r.date_debut, r.date_retour, r.status
                             FROM reservations r
                             JOIN users u ON r.id_user = u.id
                             JOIN pcs p ON r.id_pc = p.id";
    $stmt_all = $pdo->query($sql_all_reservations);
    $all_reservations = $stmt_all->fetchAll();

    $filename = "historique_reservations_" . date('Ymd') . ".xls";
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    $output = fopen("php://output", "w");
    fputcsv($output, array('Utilisateur', 'PC', 'Date Debut', 'Date Retour', 'Statut'), "\t");
    foreach ($all_reservations as $row) {

////////// Formater les dates au format français (jj/mm/aaaa hh:mm)/////////
        $date_debut = (new DateTime($row['date_debut']))->format('d/m/Y H:i');
        $date_retour = (new DateTime($row['date_retour']))->format('d/m/Y H:i');
        fputcsv($output, array($row['user'], $row['pc'], $date_debut, $date_retour, $row['status']), "\t");
    }
    fclose($output);
    exit();
}

// Traitement pour valider un prêt, retour, ou mise en SAV/////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['prêt'])) {
        $pc_id = $_POST['pc_id'];
        $update_sql = "UPDATE pcs SET status = 'en prêt' WHERE id = :pc_id";
        $stmt_update = $pdo->prepare($update_sql);
        $stmt_update->execute([':pc_id' => $pc_id]);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['retour'])) {
        $pc_id = $_POST['pc_id'];
        $update_sql = "UPDATE pcs SET status = 'disponible' WHERE id = :pc_id";
        $stmt_update = $pdo->prepare($update_sql);
        $stmt_update->execute([':pc_id' => $pc_id]);
        $update_reservation_sql = "UPDATE reservations SET status = 'rendu' WHERE id = :pc_id";
        $stmt_reservation = $pdo->prepare($update_reservation_sql);
        $stmt_reservation->execute([':pc_id' => $pc_id]);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['sav'])) {
        $pc_id = $_POST['pc_id'];
        $update_sql = "UPDATE pcs SET status = 'en réparation' WHERE id = :pc_id";
        $stmt_update = $pdo->prepare($update_sql);
        $stmt_update->execute([':pc_id' => $pc_id]);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['remise_en_stock'])) {
        $pc_id = $_POST['pc_id'];
        $update_sql = "UPDATE pcs SET status = 'disponible' WHERE id = :pc_id";
        $stmt_update = $pdo->prepare($update_sql);
        $stmt_update->execute([':pc_id' => $pc_id]);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['delete'])) {
        $pc_id = $_POST['pc_id'];
        $sql_delete = "DELETE FROM pcs WHERE id = :pc_id";
        $stmt_delete = $pdo->prepare($sql_delete);
        if ($stmt_delete->execute([':pc_id' => $pc_id])) {
            header("Location: admin.php");
            exit();
        } else {
            echo "Erreur lors de la suppression du PC.";
        }
    }

    if (isset($_POST['delete_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $update_pc_sql = "UPDATE pcs SET status = 'disponible' WHERE id = (SELECT id_pc FROM reservations WHERE id = :reservation_id)";
        $stmt_pc = $pdo->prepare($update_pc_sql);
        $stmt_pc->execute([':reservation_id' => $reservation_id]);
        $delete_sql = "DELETE FROM reservations WHERE id = :reservation_id";
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute([':reservation_id' => $reservation_id]);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['delete_pending_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $delete_sql = "DELETE FROM reservations WHERE id = :reservation_id";
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute([':reservation_id' => $reservation_id]);
        header("Location: admin.php");
        exit;
    }

    if (isset($_POST['import_csv']) && isset($_FILES['csv_file'])) {
        $file = $_FILES['csv_file']['tmp_name'];
        if (($handle = fopen($file, "r")) !== FALSE) {
            $insert_sql = "INSERT INTO pcs (numero_serie, status) VALUES (:numero_serie, :status)";
            $stmt_insert = $pdo->prepare($insert_sql);
            $first_row = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                if ($first_row) {
                    $first_row = false;
                    continue;
                }
                $numero_serie = str_replace("’", "'", $data[0]);
                $status = isset($data[1]) ? $data[1] : 'disponible';
                $stmt_insert->execute([':numero_serie' => $numero_serie, ':status' => $status]);
            }
            fclose($handle);
            header("Location: admin.php?success=CSV importé avec succès");
            exit();
        } else {
            echo "Erreur lors de l'ouverture du fichier CSV.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Réservations</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <!--///////////Barre de recherche///////////-->
    <div class="header-content">
        <form action="admin.php" method="GET" class="search-form">
            <input type="text" name="search" placeholder="PC, Réservation, utilisateur, date..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="button search">Rechercher</button>
        </form>

    <!--///////////Bouton déconnexion///////////--> 
        <a href="logout.php" class="button logout">Déconnexion</a>
    </div>

     <!--///////////Statistiques stock avec total ajouté///////////-->
    <div class="stats-container">
        <p>💻 Nombre total de Pcs : <?php echo $total_pcs; ?> PC(s)</p>
        <p>📦 Pcs Disponibles : <?php echo $total_pcs_disponibles; ?> PC(s)</p>
        <p>🔄 Pcs en prêt : <?php echo $total_pcs_prêt; ?> PC(s)</p>
        <p>🛠️ Pcs en maintenance : <?php echo $total_pcs_sav; ?> PC(s)</p>
    </div>
</header>

<main>
    <section class="container">
        <div class="dashboard">

            <!--////////////Historique////////////-->

            <!-- Bouton Historique utilisant JavaScript pour ouvrir tableau_history.php -->
            <button class="button history" onclick="window.open('tableau_history.php', '_blank', 'width=800,height=600');">Historique</button>

            <!-- //////////Icône telecharger.png pour l'export XLS //////////-->
            <a href="admin.php?export_history=1" class="download-link">
                <img src="img/telecharger.png" alt="Télécharger en XLS" class="telecharger">
            </a>


            <img src="img/edn.png" alt="Logo edn" class="edn">

            <h1>Tableau de bord Administratif</h1><br>
            <h2>Réservations en attente</h2>

            <!-- ////////////////Tableau des réservations///////////////////-->

            <?php if (count($reservations) > 0): ?>
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>PC</th>
                        <th>Date de début</th>
                        <th>Date de retour</th>
                        <th>Numéro de réservation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $visible_reservations = array_slice($reservations, 0, 6);
                    $extra_reservations = array_slice($reservations, 6);
                    foreach ($visible_reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['user']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['pc']); ?></td>
                            <td><?php echo htmlspecialchars((new DateTime($reservation['date_debut']))->format('d/m/Y H:i')); ?></td>
                            <td><?php echo htmlspecialchars((new DateTime($reservation['date_retour']))->format('d/m/Y H:i')); ?></td>
                            <td><?php echo htmlspecialchars($reservation['numero_reservation']); ?></td>
                            <td>
                                <div class="button-container">
                                    <a href="approve_reservation.php?id=<?php echo $reservation['id']; ?>" class="button approve">Approuver</a>
                                    <a href="reject_reservation.php?id=<?php echo $reservation['id']; ?>" class="button reject">Refuser</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($extra_reservations) > 0): ?>
                        <tr>
                            <td colspan="6">
                                <form method="GET" action="admin.php">
                                    <select name="selected_reservation" onchange="this.form.submit();">
                                        <option value="">Autres réservations...</option>
                                        <?php foreach ($extra_reservations as $reservation): ?>
                                            <option value="<?php echo $reservation['id']; ?>">
                                                <?php echo htmlspecialchars($reservation['user'] . " - " . $reservation['pc'] . " - " . $reservation['numero_reservation'] . " - Début: " . (new DateTime($reservation['date_debut']))->format('d/m/Y H:i') . " - Retour: " . (new DateTime($reservation['date_retour']))->format('d/m/Y H:i')); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if ($search): ?>
                                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>Aucune réservation en attente<?php echo $search ? " correspondant à '$search'" : ''; ?>.</p>
            <?php endif; ?>

            <!-- ////////////////Section stock des PC ////////////////-->

            <div class="pc-stock">
                <!-- Colonne gauche : Références des PC disponibles -->
                <div class="stock-column">
                    <h2>Réf des PC disponibles</h2>
                    <?php if (count($pcs_disponibles) > 0): ?>
                        <ul>
                            <?php 
                            $visible_pcs = array_slice($pcs_disponibles, 0, 5);
                            $extra_pcs = array_slice($pcs_disponibles, 5);
                            foreach ($visible_pcs as $pc): ?>
                                <li>
                                    <?php echo htmlspecialchars($pc['numero_serie']); ?>
                                    <form action="admin.php" method="POST" style="display:inline;">
                                        <button type="submit" name="sav" class="button sav">Mettre en SAV</button>
                                        <input type="hidden" name="pc_id" value="<?php echo $pc['id']; ?>">
                                    </form>
                                    <form action="admin.php" method="POST" style="display:inline;">
                                        <button type="submit" name="delete" class="button delete">Supprimer</button>
                                        <input type="hidden" name="pc_id" value="<?php echo $pc['id']; ?>">
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if (count($extra_pcs) > 0): ?>
                            <form method="GET" action="admin.php">
                                <select name="selected_pc" onchange="this.form.submit();">
                                    <option value="">Autres PC disponibles...</option>
                                    <?php foreach ($extra_pcs as $pc): ?>
                                        <option value="<?php echo $pc['id']; ?>">
                                            <?php echo htmlspecialchars($pc['numero_serie']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($search): ?>
                                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Aucun PC disponible en stock<?php echo $search ? " correspondant à '$search'" : ''; ?>.</p>
                    <?php endif; ?>
                </div>

                <!-- Colonne centrale : PC en attente de prêt -->
                <div class="stock-column">
                    <h2>PC en attente de prêt</h2>
                    <?php if (count($reservations) > 0): ?>
                        <ul>
                            <?php 
                            $visible_pending = array_slice($reservations, 0, 5);
                            $extra_pending = array_slice($reservations, 5);
                            foreach ($visible_pending as $reservation): ?>
                                <li>
                                    <?php echo htmlspecialchars($reservation['pc']); ?><br>
                                    <?php echo htmlspecialchars($reservation['numero_reservation']); ?><br>
                                    (Utilisateur : <?php echo htmlspecialchars($reservation['user']); ?>, Date de début : <?php echo htmlspecialchars((new DateTime($reservation['date_debut']))->format('d/m/Y H:i')); ?>)
                                    <form action="admin.php" method="POST" style="display:inline;">
                                        <button type="submit" name="prêt" class="button approve">Prêter</button>
                                        <input type="hidden" name="pc_id" value="<?php echo $reservation['id']; ?>">
                                    </form>
                                    <form action="admin.php" method="POST" style="display:inline;">
                                        <button type="submit" name="delete_pending_reservation" class="button delete">Supprimer</button>
                                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if (count($extra_pending) > 0): ?>
                            <form method="GET" action="admin.php">
                                <select name="selected_reservation" onchange="this.form.submit();">
                                    <option value="">Autres PC en attente...</option>
                                    <?php foreach ($extra_pending as $reservation): ?>
                                        <option value="<?php echo $reservation['id']; ?>">
                                            <?php echo htmlspecialchars($reservation['pc'] . " - " . $reservation['numero_reservation'] . " (" . $reservation['user'] . ")"); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($search): ?>
                                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Aucun PC en attente de validation<?php echo $search ? " correspondant à '$search'" : ''; ?>.</p>
                    <?php endif; ?>
                </div>

                <!-- Colonne droite : PC actuellement en prêt -->
                <div class="stock-column">
                    <h2>PC actuellement en prêt</h2>
                    <?php if (count($pcs_prêt) > 0): ?>
                        <ul>
                            <?php 
                            $visible_prêt = array_slice($pcs_prêt, 0, 5);
                            $extra_prêt = array_slice($pcs_prêt, 5);
                            foreach ($visible_prêt as $pc): ?>
                                <li>
                                    <?php echo htmlspecialchars($pc['pc']); ?><br>
                                    <?php echo htmlspecialchars($pc['numero_reservation']); ?><br>
                                    (Utilisateur : <?php echo htmlspecialchars($pc['user']); ?>, Date de retour : <?php echo htmlspecialchars((new DateTime($pc['date_retour']))->format('d/m/Y H:i')); ?>)
                                    <form action="admin.php" method="POST" style="display:inline;">
                                        <button type="submit" name="retour" class="button retour">Retour</button>
                                        <input type="hidden" name="pc_id" value="<?php echo $pc['reservation_id']; ?>">
                                    </form>
                                    <form action="admin.php" method="POST" style="display:inline;">
                                        <button type="submit" name="delete_reservation" class="button delete">Supprimer</button>
                                        <input type="hidden" name="reservation_id" value="<?php echo $pc['reservation_id']; ?>">
                                    </form>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <?php if (count($extra_prêt) > 0): ?>
                            <form method="GET" action="admin.php">
                                <select name="selected_prêt" onchange="this.form.submit();">
                                    <option value="">Autres PC en prêt...</option>
                                    <?php foreach ($extra_prêt as $pc): ?>
                                        <option value="<?php echo $pc['reservation_id']; ?>">
                                            <?php echo htmlspecialchars($pc['pc'] . " - " . $pc['numero_reservation'] . " (" . $pc['user'] . ")"); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if ($search): ?>
                                    <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                                <?php endif; ?>
                            </form>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Aucun PC actuellement en prêt<?php echo $search ? " correspondant à '$search'" : ''; ?>.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- //////////////////Section des PC en maintenance//////////////// -->
            <div class="pc-sav">
                <h2>Références des PC en maintenance (SAV)</h2>
                <?php if (count($pcs_sav) > 0): ?>
                    <ul>
                        <?php 
                        $visible_sav = array_slice($pcs_sav, 0, 5);
                        $extra_sav = array_slice($pcs_sav, 5);
                        foreach ($visible_sav as $pc): ?>
                            <li>
                                <?php echo htmlspecialchars($pc['numero_serie']); ?>
                                <form action="admin.php" method="POST" style="display:inline;">
                                    <button type="submit" name="remise_en_stock" class="button remise">Remise en stock</button>
                                    <input type="hidden" name="pc_id" value="<?php echo $pc['id']; ?>">
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php if (count($extra_sav) > 0): ?>
                        <form method="GET" action="admin.php">
                            <select name="selected_sav" onchange="this.form.submit();">
                                <option value="">Autres PC en maintenance...</option>
                                <?php foreach ($extra_sav as $pc): ?>
                                    <option value="<?php echo $pc['id']; ?>">
                                        <?php echo htmlspecialchars($pc['numero_serie']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if ($search): ?>
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">
                            <?php endif; ?>
                        </form>
                    <?php endif; ?>
                <?php else: ?>
                    <p>Aucun PC en maintenance actuellement<?php echo $search ? " correspondant à '$search'" : ''; ?>.</p>
                <?php endif; ?>
            </div>

            <!-- /////////////////////Formulaire d'importation CSV //////////////////-->
            <div class="import-csv">
                <h2>Importer des PCs</h2>
                <form action="admin.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="csv_file" accept=".csv" required>
                    <button type="submit" name="import_csv" class="button import">Importer</button>
                </form>
                <?php if (isset($_GET['success'])): ?>
                    <p style="color: green;"><?php echo htmlspecialchars($_GET['success']); ?></p>
                <?php endif; ?>
                <a href="emploi-csv.php" target="_blank">Mode d'emploi du fichier CSV</a>
            </div>
        </div>
    </section>
</main>

</body>
</html>