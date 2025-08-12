<?php
/*/////////////////////////////////////////////////////////*/
/*/////////////Page de connexion User et Admin////////////*/
/*///////////////////////////////////////////////////////*/

require_once 'config/main.php'; // Inclut session_start() et génère $_SESSION['csrf_token']

// Traitement de la connexion de l'utilisateur ou de l'administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier le jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $error = "Erreur : Jeton CSRF invalide.";
    } else {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = isset($_GET['role']) ? $_GET['role'] : ''; // Récupère le rôle depuis l'URL

        // Vérification du rôle dans l'URL
        if (empty($role)) {
            $error = "Le rôle n'est pas spécifié dans l'URL.";
        } else {
            // Préparer la requête pour vérifier l'utilisateur dans la base
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND role = :role");
            $stmt->execute(['username' => $username, 'role' => $role]);
            $user = $stmt->fetch();

            // Vérifier si l'utilisateur existe et si le mot de passe est correct (haché)
            if ($user && password_verify($password, $user['password'])) {
                // Enregistre l'utilisateur dans la session
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                // Régénérer le jeton CSRF après une connexion réussie
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

                // Redirection vers la page appropriée
                if ($role == 'user') {
                    header("Location: reservation.php");
                } elseif ($role == 'admin') {
                    header("Location: admin.php");
                }
                exit;
            } else {
                $error = "Identifiants incorrects pour le rôle $role.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
</head>
<body>

<header>
    <a href="index.php" class="button">Retour à l'accueil</a>
    <img src="img/edn.png" alt="Logo edn" class="edn-header">
</header>

<div class="container">
    <div class="content">
        <h1>Connexion</h1>
        
        <!-- Affichage du message d'erreur -->
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        
        <form method="POST" class="login-form">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
            <div class="input-group">
                <label for="username">Nom de l'utilisateur</label>
                <input type="text" id="username" name="username" placeholder="Entrez votre nom d'utilisateur" required>
            </div>

            <div class="input-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe" required>
            </div>

            <button type="submit" class="submit-btn">Se connecter</button>
        </form>
    </div>
</div>

</body>
</html>