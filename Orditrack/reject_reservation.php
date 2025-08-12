<?php
require_once 'config/main.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?role=admin");
    exit;
}

// Vérifier si l'ID est présent dans l'URL (requête GET)
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Récupérer les informations de la réservation pour l'email
    $sql_info = "SELECT r.id, u.username AS user, u.email AS user_email, p.numero_serie AS pc, r.date_debut, r.date_retour, CONCAT('RES-', LPAD(r.id, 4, '0')) AS numero_reservation
                 FROM reservations r
                 JOIN users u ON r.id_user = u.id
                 JOIN pcs p ON r.id_pc = p.id
                 WHERE r.id = ?";
    $stmt_info = $pdo->prepare($sql_info);
    $stmt_info->execute([$reservation_id]);
    $reservation = $stmt_info->fetch();

    if ($reservation) {
        // Mettre à jour le statut de la réservation à 'annulé'
        $sql_reservation = "UPDATE reservations SET status = 'annulé' WHERE id = ?";
        $stmt_reservation = $pdo->prepare($sql_reservation);
        $stmt_reservation->execute([$reservation_id]);

        // Rendre le PC disponible dans la table pcs
        $sql_pc = "UPDATE pcs SET status = 'disponible' WHERE id = (SELECT id_pc FROM reservations WHERE id = ?)";
        $stmt_pc = $pdo->prepare($sql_pc);
        $stmt_pc->execute([$reservation_id]);

        // Préparer l'URL mailto avec le message prérempli, en imitant le format du bouton "Commentaire"
        $to = htmlspecialchars($reservation['user_email']);
        $subject = "Refus de votre réservation " . htmlspecialchars($reservation['numero_reservation']);
        $body = "Bonjour " . htmlspecialchars($reservation['user']) . ",%0D%0A%0D%0A" .
                "Votre demande de réservation pour le PC " . htmlspecialchars($reservation['pc']) . " (Réservation n°" . htmlspecialchars($reservation['numero_reservation']) . ") " .
                "du " . htmlspecialchars((new DateTime($reservation['date_debut']))->format('d/m/Y H:i')) . " " .
                "au " . htmlspecialchars((new DateTime($reservation['date_retour']))->format('d/m/Y H:i')) . " a été refusée.%0D%0A%0D%0A" .
                "Motif du refus : [Veuillez préciser ici]%0D%0A%0D%0A" .
                "N’hésitez pas à me contacter si vous avez des questions.%0D%0A%0D%0A" .
                "Cordialement,%0D%0A" . htmlspecialchars($_SESSION['username']) . " (Administrateur)";

        // Rediriger vers mailto pour ouvrir le client email
        header("Location: mailto:$to?subject=$subject&body=$body");
        exit;
    } else {
        die("Erreur : Réservation non trouvée.");
    }
} else {
    die("Erreur : ID de réservation manquant.");
}
?>