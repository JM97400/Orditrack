<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: auth.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur</title>
    <link rel="stylesheet" href="user-form.css"> <!-- Fichier CSS spécifique -->
</head>
<body>
    <header>
        <a href="logout.php" class="button logout">Déconnexion</a>
    </header>
    <div class="container">
        <h1>Profil Utilisateur</h1>
        <form action="update-user.php" method="POST">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="role">Rôle :</label>
            <select id="role" name="role">
                <option value="Utilisateur" selected>Utilisateur</option>
                <option value="Admin">Admin</option>
            </select>
            
            <button type="submit">Mettre à jour</button>
        </form>
    </div>
</body>
</html>
