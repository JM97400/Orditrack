<?php
/*/////////////////////////////////////////////////////////*/
/*///////////////Tableau Historique Admin/////////////////*/
/*///////////////////////////////////////////////////////*/

require 'config.php';

// Vérification si l'utilisateur est admin et connecté
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?role=admin");
    exit;
}

// Connexion à la base de données pour récupérer les réservations
require 'config.php';

// Récupérer toutes les réservations
$sql_all_reservations = "SELECT r.id, u.username AS user, p.numero_serie AS pc, r.date_debut, r.date_retour, r.status
                         FROM reservations r
                         JOIN users u ON r.id_user = u.id
                         JOIN pcs p ON r.id_pc = p.id";
$stmt_all = $pdo->query($sql_all_reservations);
$all_reservations = $stmt_all->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Réservations</title>
    <link rel="stylesheet" href="tableau_history.css">
</head>
<body>
    <main>
        <section class="container">
            <div class="history-dashboard">
                <h1>Historique des Réservations</h1>

                <!-- Bouton Fermer avec JavaScript pour fermer l'onglet -->
                <button class="button close" onclick="window.close()">Fermer</button>

                <!-- Tableau des réservations -->
                <?php if (count($all_reservations) > 0): ?>
                    <table class="history-table" id="historyTable">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>PC</th>
                                <th>Date Début</th>
                                <th>Date Retour</th>
                                <th>Statut</th>
                            </tr>
                            <tr class="filter-row">
                                <th>
                                    <input type="text" class="filter-input" data-column="0" placeholder="Filtrer..." onkeyup="filterTable()">
                                </th>
                                <th>
                                    <input type="text" class="filter-input" data-column="1" placeholder="Filtrer..." onkeyup="filterTable()">
                                </th>
                                <th>
                                    <input type="text" class="filter-input" data-column="2" placeholder="Filtrer..." onkeyup="filterTable()">
                                </th>
                                <th>
                                    <input type="text" class="filter-input" data-column="3" placeholder="Filtrer..." onkeyup="filterTable()">
                                </th>
                                <th>
                                    <input type="text" class="filter-input" data-column="4" placeholder="Filtrer..." onkeyup="filterTable()">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_reservations as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['user']); ?></td>
                                    <td><?php echo htmlspecialchars($row['pc']); ?></td>
                                    <td><?php echo htmlspecialchars((new DateTime($row['date_debut']))->format('d/m/Y H:i')); ?></td>
                                    <td><?php echo htmlspecialchars((new DateTime($row['date_retour']))->format('d/m/Y H:i')); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune réservation dans l'historique.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <!-- Script JavaScript pour le filtrage -->
    <script>
        function filterTable() {
            const table = document.getElementById('historyTable');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const inputs = document.querySelectorAll('.filter-input');

            rows.forEach(row => {
                let showRow = true;

                inputs.forEach(input => {
                    const columnIndex = parseInt(input.getAttribute('data-column'));
                    const filterValue = input.value.trim().toLowerCase();
                    const cellValue = row.cells[columnIndex].textContent.trim().toLowerCase();

                    if (filterValue && !cellValue.includes(filterValue)) {
                        showRow = false;
                    }
                });

                row.style.display = showRow ? '' : 'none';
            });
        }
    </script>
</body>
</html>