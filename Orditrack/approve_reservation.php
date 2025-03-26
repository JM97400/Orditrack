<?php

/*/////////////////////////////////////////////////////////*/
/*/////////////Page de validation réservation/////////////*/
/*///////////////////////////////////////////////////////*/

require 'config.php';

// Vérification de la session et des permissions
// MODIFICATION : session_start() supprimé car géré dans config.php
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php?role=admin");
    exit;
}

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Connexion à la base de données
   
    // Récupérer les informations de la réservation
    $sql = "SELECT r.id_user, u.username, u.email, r.date_debut, r.date_retour, r.id_pc
            FROM reservations r
            JOIN users u ON r.id_user = u.id
            WHERE r.id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$reservation_id]);
    $reservation = $stmt->fetch();

    if ($reservation) {
        // Générer le numéro de réservation au format RES-XXXX
        $numero_reservation = "RES-" . str_pad($reservation_id, 4, "0", STR_PAD_LEFT);

        // Mise à jour du statut de la réservation
        $update_sql = "UPDATE reservations SET status = 'validé' WHERE id = ?";
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->execute([$reservation_id]);

        // Mettre le PC en attente de prêt (déplacer le statut)
        $update_pc_sql = "UPDATE pcs SET status = 'réservé' WHERE id = ?";
        $stmt_update_pc = $pdo->prepare($update_pc_sql);
        $stmt_update_pc->execute([$reservation['id_pc']]);

        // Envoi de l'email de confirmation à l'utilisateur
        $to = $reservation['email'];
        $subject = "Réservation approuvée - Votre PC";
        $message = "Bonjour " . htmlspecialchars($reservation['username']) . ",\n\n" .
                   "Votre réservation de PC a été approuvée !\n" .
                   "Numéro de réservation : " . htmlspecialchars($numero_reservation) . "\n" .
                   "Date de début : " . htmlspecialchars($reservation['date_debut']) . "\n" .
                   "Date de retour : " . htmlspecialchars($reservation['date_retour']) . "\n\n" .
                   "Merci de votre réservation.\n\n" .
                   "Cordialement,\nL'équipe de gestion des PC";

        mail($to, $subject, $message);

        // Rediriger vers le tableau de bord
        header("Location: admin.php?success=1");
        exit;
    }
}