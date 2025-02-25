<?php
require 'config.php';

if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Mettre à jour le statut de la réservation
    $sql = "UPDATE reservations SET status = 'annulé' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$reservation_id]);

    // Redirection vers la page d'admin après refus
    header("Location: admin.php");
    exit;
}
?>
