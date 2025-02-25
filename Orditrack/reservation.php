<?php
session_start();

// Vérifier si l'utilisateur est connecté en utilisant le rôle 'user' dans la session
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php"); // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté ou s'il n'est pas un utilisateur
    exit;
}

// Connexion à la base de données pour récupérer le nombre de PC disponibles
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

// Récupérer le nombre de PC disponibles
$query = $db->query("SELECT COUNT(*) AS available_pcs FROM pcs WHERE status = 'disponible'");
$data = $query->fetch(PDO::FETCH_ASSOC);
$available_pcs = $data['available_pcs'];

// Gérer la réservation lorsque le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    // Vérifier si le PC est toujours disponible
    $query = $db->prepare("SELECT status FROM pcs WHERE id = :id_pc");
    $query->execute(['id_pc' => $pc_id]);
    $pc = $query->fetch(PDO::FETCH_ASSOC);

    if (!$pc || $pc['status'] != 'disponible') {
        die("Ce PC n'est plus disponible.");
    }

    // Ajouter la réservation dans la base de données
    try {
        $query = $db->prepare("INSERT INTO reservations (id_user, id_pc, date_debut, date_retour, status, validated_by) 
                               VALUES (:id_user, :id_pc, :date_debut, :date_retour, 'en attente', NULL)");
        $query->execute([
            'id_user' => $id_user, 
            'id_pc' => $pc_id, 
            'date_debut' => $date_debut, 
            'date_retour' => $date_retour
        ]);
    
        header("Location: index.php?reservation=success");
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de l'ajout de la réservation : " . $e->getMessage());
    }
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
        <button class="logout-button" onclick="window.location.href='logout.php'">Déconnecter</button>
    </div>

    <h2>Réservation de PC</h2>
    <p>Il y a actuellement <strong><?php echo htmlspecialchars($available_pcs); ?></strong> PC disponibles.</p>

    <form method="POST" action="">
        <label for="pc_id">Choisir un PC à réserver :</label>
        <select name="pc_id" id="pc_id" required>
            <?php
            $query = $db->query("SELECT id, numero_serie FROM pcs WHERE status = 'disponible'");
            while ($pc = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($pc['id']) . "'>" . htmlspecialchars($pc['numero_serie']) . "</option>";
            }
            ?>
        </select><br>

        <label for="date_debut">Date de début :</label>
        <input type="datetime-local" name="date_debut" id="date_debut" required><br>

        <label for="date_retour">Date de retour :</label>
        <input type="datetime-local" name="date_retour" id="date_retour" required><br>

        <button type="submit">Réserver</button>
    </form>
</body>
</html>
