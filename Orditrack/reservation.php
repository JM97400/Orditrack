<?php
/*/////////////////////////////////////////////////////////*/
/*/////////////Page de réservation utilisateur////////////*/
/*///////////////////////////////////////////////////////*/

session_start();

// Vérifier si l'utilisateur est connecté en utilisant le rôle 'user' dans la session
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Connexion à la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=gestion_pret_pc', 'test_user', 'test_password', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer l'ID de l'utilisateur basé sur son nom d'utilisateur
$query = $db->prepare("SELECT id FROM users WHERE username = :username");
$query->execute(['username' => $_SESSION['username']]);
$user_data = $query->fetch(PDO::FETCH_ASSOC);

if (!$user_data) {
    die("Erreur : utilisateur introuvable.");
}

$id_user = $user_data['id'];

// Récupérer le nombre de PC disponibles (initialement, sans filtre de date)
$query = $db->query("SELECT COUNT(*) AS available_pcs FROM pcs WHERE status = 'disponible'");
$data = $query->fetch(PDO::FETCH_ASSOC);
$available_pcs = $data['available_pcs'];

// Récupérer les réservations en attente pour l'utilisateur connecté//////////////
$query = $db->prepare("
    SELECT r.id, p.numero_serie AS pc, r.date_debut, r.date_retour, CONCAT('RES-', LPAD(r.id, 4, '0')) AS numero_reservation, r.status
    FROM reservations r
    JOIN pcs p ON r.id_pc = p.id
    WHERE r.id_user = :id_user AND r.status = 'en attente'
");
$query->execute(['id_user' => $id_user]);
$current_reservations = $query->fetchAll(PDO::FETCH_ASSOC);

// Gérer la sélection dans le menu déroulant pour remplacer la réservation affichée///////////////
if (isset($_GET['selected_reservation']) && !empty($_GET['selected_reservation'])) {
    $selected_id = $_GET['selected_reservation'];
    $selected_index = array_search($selected_id, array_column($current_reservations, 'id'));
    if ($selected_index !== false) {
        $selected_reservation = array_splice($current_reservations, $selected_index, 1)[0];
        array_unshift($current_reservations, $selected_reservation); // Place la réservation sélectionnée en premier
    }
}

// Gérer l'annulation d'une réservation///////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_reservation'])) {
    $reservation_id = $_POST['reservation_id'];
    $query = $db->prepare("DELETE FROM reservations WHERE id = :id AND id_user = :id_user AND status = 'en attente'");
    $query->execute(['id' => $reservation_id, 'id_user' => $id_user]);
    header("Location: reservation.php");
    exit;
}

// Gérer la soumission du formulaire de réservation////////////////
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['cancel_reservation'])) {
    $pc_id = $_POST['pc_id'];
    $date_debut = $_POST['date_debut'];
    $date_retour = $_POST['date_retour'];

    // Validation des dates
    if ($date_debut < date("Y-m-d\TH:i")) {
        die("La date de début ne peut pas être dans le passé.");
    }

    if ($date_retour <= $date_debut) {
        die("La date de retour doit être après la date de début.");
    }

    // Vérifier si le PC est toujours disponible pour la période donnée
    $query = $db->prepare("
        SELECT status 
        FROM pcs 
        WHERE id = :id_pc 
        AND status = 'disponible'
        AND NOT EXISTS (
            SELECT 1 
            FROM reservations 
            WHERE id_pc = :id_pc 
            AND (
                (:date_debut BETWEEN date_debut AND date_retour) 
                OR (:date_retour BETWEEN date_debut AND date_retour) 
                OR (date_debut BETWEEN :date_debut AND :date_retour)
            )
            AND status IN ('en attente', 'validé', 'en prêt')
        )
    ");
    $query->execute([
        'id_pc' => $pc_id,
        'date_debut' => $date_debut,
        'date_retour' => $date_retour
    ]);
    $pc = $query->fetch(PDO::FETCH_ASSOC);

    if (!$pc) {
        die("Ce PC n'est pas disponible pour la période sélectionnée.");
    }

    // Ajouter la réservation
    try {
        $query = $db->prepare("
            INSERT INTO reservations (id_user, id_pc, date_debut, date_retour, status, validated_by) 
            VALUES (:id_user, :id_pc, :date_debut, :date_retour, 'en attente', NULL)
        ");
        $query->execute([
            'id_user' => $id_user, 
            'id_pc' => $pc_id, 
            'date_debut' => $date_debut, 
            'date_retour' => $date_retour
        ]);
    
        header("Location: validation_user.php?reservation_id=" . $db->lastInsertId());
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de la réservation : " . $e->getMessage());
    }
}

// Gestion AJAX pour récupérer les PCs disponibles
if (isset($_GET['get_available_pcs']) && isset($_GET['date_debut']) && isset($_GET['date_retour'])) {
    $date_debut = $_GET['date_debut'];
    $date_retour = $_GET['date_retour'];

    $query = $db->prepare("
        SELECT id, numero_serie 
        FROM pcs 
        WHERE status = 'disponible'
        AND NOT EXISTS (
            SELECT 1 
            FROM reservations 
            WHERE id_pc = pcs.id 
            AND (
                (:date_debut BETWEEN date_debut AND date_retour) 
                OR (:date_retour BETWEEN date_debut AND date_retour) 
                OR (date_debut BETWEEN :date_debut AND :date_retour)
            )
            AND status IN ('en attente', 'validé', 'en prêt')
        )
    ");
    $query->execute(['date_debut' => $date_debut, 'date_retour' => $date_retour]);
    $pcs = $query->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($pcs);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réservation PC</title>
    <link rel="stylesheet" href="reservation.css">
</head>
<body>
    <div class="navbar">
        <div class="logo-container">
            <img src="img/edn.png" alt="Logo edn" class="logo-edn">
        </div>
        <button class="button logout-button" onclick="window.location.href='logout.php'">Déconnexion</button>
    </div>

    <!--////// Tableau des réservations en attente (en haut à droite) //////////-->
    <?php if (count($current_reservations) > 0): ?>
        <div class="current-reservations">
            <h3>Réservations déjà effectuées</h3>
            <table class="current-reservations-table">
                <thead>
                    <tr>
                        <th>Réservation</th>
                        <th>PC</th>
                        <th>Début</th>
                        <th>Retour</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $visible_reservations = array_slice($current_reservations, 0, 1); // 1 seule réservation visible
                    $extra_reservations = array_slice($current_reservations, 1); // Réservations supplémentaires
                    foreach ($visible_reservations as $reservation): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($reservation['numero_reservation']); ?></td>
                            <td><?php echo htmlspecialchars($reservation['pc']); ?></td>
                            <td><?php echo htmlspecialchars((new DateTime($reservation['date_debut']))->format('d/m/Y')); ?></td> <!--format avec heure :('d/m/Y H:i')-->
                            <td><?php echo htmlspecialchars((new DateTime($reservation['date_retour']))->format('d/m/Y')); ?></td> <!--format avec heure :('d/m/Y H:i')-->
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                    <button type="submit" name="cancel_reservation" class="button cancel-button">Annuler</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (count($extra_reservations) > 0): ?>
                        <tr>
                            <td colspan="5">
                                <form method="GET" action="reservation.php">
                                    <select name="selected_reservation" onchange="this.form.submit();">
                                        <option value="">Autres en attente...</option>
                                        <?php foreach ($extra_reservations as $reservation): ?>
                                            <option value="<?php echo $reservation['id']; ?>">
                                                <?php echo htmlspecialchars($reservation['numero_reservation'] . " - " . $reservation['pc'] . " (" . (new DateTime($reservation['date_debut']))->format('d/m/Y H:i') . " - " . (new DateTime($reservation['date_retour']))->format('d/m/Y H:i') . ")"); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>


    <!--////// Indication du nombre de pc disponibles //////////-->
    <h2>Réservation de PC</h2>
    <p class="echo">Il y a actuellement <strong><?php echo htmlspecialchars($available_pcs); ?></strong> PC disponibles.</p>
    

    <!--////// Formulaire de réservation //////////-->

    <form method="POST" action="">
        <label for="date_debut">Sélectionner la date et l'heure de début de prêt :</label>
        <input type="datetime-local" name="date_debut" id="date_debut" required><br>

        <label for="date_retour">Sélectionner la date et l'heure de retour de prêt :</label>
        <input type="datetime-local" name="date_retour" id="date_retour" required><br>

        <label for="pc_id">Choisir un PC à réserver :</label>
        <select name="pc_id" id="pc_id" required>
            <option value="">Sélectionnez les dates d'abord</option>
        </select><br>

        <button type="submit">Réserver</button>
    </form>

    <script>
        const dateDebutInput = document.getElementById('date_debut');
        const dateRetourInput = document.getElementById('date_retour');
        const pcSelect = document.getElementById('pc_id');

        function updatePcList() {
            const dateDebut = dateDebutInput.value;
            const dateRetour = dateRetourInput.value;

            if (dateDebut && dateRetour && dateRetour > dateDebut) {
                fetch(`reservation.php?get_available_pcs=1&date_debut=${encodeURIComponent(dateDebut)}&date_retour=${encodeURIComponent(dateRetour)}`)
                    .then(response => response.json())
                    .then(data => {
                        pcSelect.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(pc => {
                                const option = document.createElement('option');
                                option.value = pc.id;
                                option.textContent = pc.numero_serie;
                                pcSelect.appendChild(option);
                            });
                        } else {
                            pcSelect.innerHTML = '<option value="">Aucun PC disponible</option>';
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            }
        }

        dateDebutInput.addEventListener('change', updatePcList);
        dateRetourInput.addEventListener('change', updatePcList);
    </script>
</body>
</html>