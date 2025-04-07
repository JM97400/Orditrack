<?php
// config.php : Connexion à la base de données et configuration des sessions

$host = 'localhost';
$dbname = 'gestion_pret_pc';
$username = 'root'; 
$password = ''; 

// Configuration des paramètres de session (Protection des cookies)
// Vérifier si la session n'est pas déjà active avant de définir les paramètres
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,           // Expire à la fermeture du navigateur
        'path' => '/',             // Disponible sur tout le site
        'domain' => '',            // Domaine actuel
        'secure' => false,         // Mettre true en production avec HTTPS
        'httponly' => true,        // Protection contre XSS
        'samesite' => 'Strict'     // Protection contre CSRF
    ]);
    // Démarrer la session uniquement si elle n'est pas déjà active
    session_start();
}

// Générer un jeton CSRF s’il n’existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Token aléatoire sécurisé
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie à la base de données."; // Commenter en production
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>