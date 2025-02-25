<?php
require 'config.php';

// Vérification si la méthode est POST pour la réservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'], $_POST['pc_id'], $_POST['date_debut'], $_POST['date_retour'])) {
    $user_id = $_POST['user_id'];
    $pc_id = $_POST['pc_id'];
    $date_debut = $_POST['date_debut'];
    $date_retour = $_POST['date_retour'];

    $sql = "INSERT INTO reservations (id_user, id_pc, date_debut, date_retour, statut) VALUES (?, ?, ?, ?, 'en attente')";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$user_id, $pc_id, $date_debut, $date_retour])) {
        echo "<p>Réservation enregistrée avec succès.</p>";
    } else {
        echo "<p>Erreur lors de la réservation.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prêt de PC - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<script>
    // Vérifie si l'URL contient "?reservation=success"
    if (window.location.search.includes("reservation=success")) {
        alert("Votre réservation est en cours de validation.");
    }
</script>

<body>

<header>

    
    <!-- Liens pour accéder aux pages de connexion -->
<div class="button-container">
        <a href="login.php?role=user" class="button">Réserver un PC</a>
        <a href="login.php?role=admin" class="button">Accès Admin</a>
</div>
</header>

<div class="container">
    <div class="content">
        <h1>Bienvenue sur le système de prêt de PC</h1>
        <p>Réservez un ordinateur portable en quelques clics.</p>
        <!-- Ajoute ici ton logo sous le titre -->
        <img src="img/orditrack.png" alt="Logo Système de Prêt" class="logo-below-title">
    </div>

    
</div>




</body>
</html>
