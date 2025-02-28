<?php
// Vérification si l'utilisateur est admin et connecté
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?role=admin");
    exit;
}

// Connexion à la base de données pour récupérer les réservations
require 'config.php';

// Récupérer les réservations en attente
$sql = "SELECT r.id, u.username AS user, p.numero_serie AS pc, r.date_debut, r.date_retour, r.status
        FROM reservations r
        JOIN users u ON r.id_user = u.id
        JOIN pcs p ON r.id_pc = p.id
        WHERE r.status = 'en attente'";
$stmt = $pdo->query($sql);
$reservations = $stmt->fetchAll();

// Récupérer le stock de PC disponibles
$sql_stock = "SELECT id, numero_serie, status FROM pcs WHERE status = 'disponible'";
$stmt_stock = $pdo->query($sql_stock);
$pcs_disponibles = $stmt_stock->fetchAll();

// Récupérer les PC en maintenance (SAV)
$sql_sav = "SELECT id, numero_serie FROM pcs WHERE status = 'en réparation'";
$stmt_sav = $pdo->query($sql_sav);
$pcs_sav = $stmt_sav->fetchAll();

// Récupérer les PC en prêt (colonne de droite)
$sql_prêt = "SELECT r.id AS reservation_id, r.date_debut, r.date_retour, u.username AS user, p.numero_serie AS pc
             FROM reservations r
             JOIN users u ON r.id_user = u.id
             JOIN pcs p ON r.id_pc = p.id
             WHERE r.status = 'validé'";
$stmt_prêt = $pdo->query($sql_prêt);
$pcs_prêt = $stmt_prêt->fetchAll();

// Compter le total des PC
$total_pcs_disponibles = count($pcs_disponibles);
$total_pcs_sav = count($pcs_sav);
$total_pcs_prêt = count($pcs_prêt);

// Traitement de l'exportation vers XLS
if (isset($_GET['export_history'])) {
    // Récupérer toutes les réservations
    $sql_all_reservations = "SELECT r.id, u.username AS user, p.numero_serie AS pc, r.date_debut, r.date_retour, r.status
                             FROM reservations r
                             JOIN users u ON r.id_user = u.id
                             JOIN pcs p ON r.id_pc = p.id";
    $stmt_all = $pdo->query($sql_all_reservations);
    $all_reservations = $stmt_all->fetchAll();

    // Nom du fichier
    $filename = "historique_reservations_" . date('Ymd') . ".xls";

    // En-têtes HTTP pour forcer le téléchargement
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Ouvrir la sortie comme un "fichier"
    $output = fopen("php://output", "w");

    // Ajouter les en-têtes du tableau
    fputcsv($output, array('ID', 'Utilisateur', 'PC', 'Date Debut', 'Date Retour', 'Statut'), "\t");

    // Ajouter les données
    foreach ($all_reservations as $row) {
        fputcsv($output, array(
            $row['id'],
            $row['user'],
            $row['pc'],
            $row['date_debut'],
            $row['date_retour'],
            $row['status']
        ), "\t");
    }

    fclose($output);
    exit();
}

// Traitement pour valider un prêt, retour, ou mise en SAV
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
        exit();
    }

    if (isset($_POST['delete_pending_reservation'])) {
        $reservation_id = $_POST['reservation_id'];
        $delete_sql = "DELETE FROM reservations WHERE id = :reservation_id";
        $stmt_delete = $pdo->prepare($delete_sql);
        $stmt_delete->execute([':reservation_id' => $reservation_id]);
        header("Location: admin.php");
        exit();
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
                $numero_serie = str_replace("’", "'", $data[0]); // Nettoyage des caractères problématiques
                $status = isset($data[1]) ? $data[1] : 'disponible';
                $stmt_insert->execute([
                    ':numero_serie' => $numero_serie,
                    ':status' => $status
                ]);
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
    <div class="header-content">
        <a href="admin.php?export_history=1" class="button history">Historique</a>
        <a href="logout.php" class="button logout">Déconnexion</a>
    </div>

    <div class="stats-container">
        <p>📦 Pcs en Stock : <?php echo $total_pcs_disponibles; ?> PC(s)</p>
        <p>🔄 Pcs en prêt : <?php echo $total_pcs_prêt; ?> PC(s)</p>
        <p>🛠️ Pcs en maintenance : <?php echo $total_pcs_sav; ?> PC(s)</p>
    </div>
</header>

<main>
    <section class="container">
        <div class="dashboard">
        <img src="img/edn.png" alt="Logo edn" class="edn">

            <h1>Tableau de bord Administratif</h1>
            <h2>Réservations en attente</h2>

            <!-- Tableau des réservations -->
            <?php if (count($reservations) > 0): ?>
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>PC</th>
                        <th>Date de début</th>
                        <th>Date de retour</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['user']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['pc']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date_debut']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['date_retour']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                            <td>
                                <div class="button-container">
                                    <a href="approve_reservation.php?id=<?php echo $reservation['id']; ?>" class="button approve">Approuver</a>
                                    <a href="reject_reservation.php?id=<?php echo $reservation['id']; ?>" class="button reject">Refuser</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <p>Aucune réservation en attente.</p>
            <?php endif; ?>

           
            <!-- Section stock des PC -->
            <div class="pc-stock">

    <!-- Colonne gauche : Références des PC disponibles -->
<div class="stock-column">
    <h2>Réf des PC disponibles</h2>
    <?php if (count($pcs_disponibles) > 0): ?>
        <ul>
            <?php foreach ($pcs_disponibles as $pc): ?>
                <li>
                    <?php echo htmlspecialchars($pc['numero_serie']); ?>
                    <form action="admin.php" method="POST" style="display:inline;">
                        <button type="submit" name="sav" class="button sav" value="1">Mettre en SAV</button>
                        <input type="hidden" name="pc_id" value="<?php echo $pc['id']; ?>">
                    </form>
                    <form action="admin.php" method="POST" style="display:inline;">
                        <button type="submit" name="delete" class="button delete" value="1">Supprimer</button>
                        <input type="hidden" name="pc_id" value="<?php echo $pc['id']; ?>">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun PC disponible en stock.</p>
    <?php endif; ?>
</div>

<!-- Colonne centrale : PC en attente de prêt -->
<div class="stock-column">
    <h2>PC en attente de prêt</h2>
    <?php if (count($reservations) > 0): ?>
        <ul>
            <?php foreach ($reservations as $reservation): ?>
                <li>
                    <?php echo htmlspecialchars($reservation['pc']); ?><br>
                    (Utilisateur : <?php echo htmlspecialchars($reservation['user']); ?>, Date de début : <?php echo htmlspecialchars($reservation['date_debut']); ?>)
                    <form action="admin.php" method="POST" style="display:inline;">
                        <button type="submit" name="prêt" class="button approve" value="1">Prêter</button>
                        <input type="hidden" name="pc_id" value="<?php echo $reservation['id']; ?>">
                    </form>
                    <form action="admin.php" method="POST" style="display:inline;">
                        <button type="submit" name="delete_pending_reservation" class="button delete" value="1">Supprimer</button>
                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun PC en attente de validation.</p>
    <?php endif; ?>
</div>

<!-- Colonne droite : PC actuellement en prêt -->
<div class="stock-column">
    <h2>PC actuellement en prêt</h2>
    <?php if (count($pcs_prêt) > 0): ?>
        <ul>
            <?php foreach ($pcs_prêt as $pc): ?>
                <li>
                    <?php echo htmlspecialchars($pc['pc']); ?> <br>
                    (Utilisateur : <?php echo htmlspecialchars($pc['user']); ?>, Date de retour : <?php echo htmlspecialchars($pc['date_retour']); ?>)
                    <form action="admin.php" method="POST" style="display:inline;">
                        <button type="submit" name="retour" class="button retour">Retour</button>
                        <input type="hidden" name="pc_id" value="<?php echo $pc['reservation_id']; ?>">
                    </form>
                    <form action="admin.php" method="POST" style="display:inline;">
                        <button type="submit" name="delete_reservation" class="button delete" value="1">Supprimer</button>
                        <input type="hidden" name="reservation_id" value="<?php echo $pc['reservation_id']; ?>">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun PC actuellement en prêt.</p>
    <?php endif; ?>
</div>

            </div>

<!-- Section des PC en maintenance -->
            <div class="pc-sav">
                <h2>Références des PC en maintenance (SAV)</h2>
                <?php if (count($pcs_sav) > 0): ?>
                    <ul>
                        <?php foreach ($pcs_sav as $pc): ?>
                            <li>
                                <?php echo htmlspecialchars($pc['numero_serie']); ?>
                                <form action="admin.php" method="POST" style="display:inline;">
                                    <button type="submit" name="remise_en_stock" class="button remise" value="1">Remise en stock</button>
                                    <input type="hidden" name="pc_id" value="<?php echo $pc['id']; ?>">
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun PC en maintenance actuellement.</p>
                <?php endif; ?>
            </div>
             <!-- Formulaire d'importation CSV -->
             <div class="import-csv">
             <h2>Importer des PCs via CSV</h2>
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