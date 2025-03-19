<?php
session_start();

// Vérifier si l'utilisateur est connecté avec le rôle 'user'
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Vérifier si un ID de réservation est passé en paramètre
if (!isset($_GET['reservation_id'])) {
    header("Location: reservation.php");
    exit;
}

$reservation_id = $_GET['reservation_id'];

// Connexion à la base de données
try {
    $db = new PDO('mysql:host=localhost;dbname=gestion_pret_pc', 'test_user', 'test_password', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupérer les détails de la réservation
$query = $db->prepare("
    SELECT r.id, r.date_debut, r.date_retour, p.numero_serie 
    FROM reservations r 
    JOIN pcs p ON r.id_pc = p.id 
    WHERE r.id = :reservation_id AND r.id_user = (
        SELECT id FROM users WHERE username = :username
    )
");
$query->execute([
    'reservation_id' => $reservation_id,
    'username' => $_SESSION['username']
]);
$reservation = $query->fetch(PDO::FETCH_ASSOC);

if (!$reservation) {
    die("Erreur : réservation introuvable ou non autorisée.");
}

// Générer un numéro de réservation (par exemple, "RES-XXXX" basé sur l'ID)
$numero_reservation = "RES-" . str_pad($reservation['id'], 4, "0", STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Réservation</title>
    <link rel="stylesheet" href="validation.css">
</head>
<body>
    <div class="navbar">
        <div class="logo-container">
            <img src="img/edn.png" alt="Logo edn" class="logo-edn">
        </div>
        <button class="button logout-button" onclick="window.location.href='logout.php'">Déconnexion</button>
    </div>

    <div class="confirmation-container">
        <h2>Réservation en cours de validation</h2>
        <div class="confirmation-card">
            <div class="icon-success">
                <span>✔</span>
            </div>
            <p>Votre réservation <strong><?php echo htmlspecialchars($numero_reservation); ?></strong> a été enregistrée avec succès et est en attente de validation par un administrateur.</p>
            <p>Un email de confirmation vous sera envoyé à l’adresse <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>.</p>
            <div class="reservation-details">
                <p><strong>Date de début :</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($reservation['date_debut']))); ?></p>
                <p><strong>Date de retour :</strong> <?php echo htmlspecialchars(date('d/m/Y H:i', strtotime($reservation['date_retour']))); ?></p>
                <p><strong>PC réservé :</strong> <?php echo htmlspecialchars($reservation['numero_serie']); ?></p>
            </div>
            <button class="button return-button" onclick="window.location.href='reservation.php'">Retour aux réservations</button>
        </div>
    </div>
</body>
</html>