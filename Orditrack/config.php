<?php
// config.php : Connexion à la base de données

$host = 'localhost';
$dbname = 'gestion_pret_pc';
$username = 'root'; // À modifier selon config
$password = ''; // À modifier selon config

// Configuration des paramètres de session ====> (Protection des cookies) <====
session_set_cookie_params([
    'lifetime' => 0,           // Expire à la fermeture du navigateur
    'path' => '/',             // Disponible sur tout le site
    'domain' => '',            // Domaine actuel
    'secure' => false,         // Mettre true en production avec HTTPS
    'httponly' => true,        // Protection contre XSS (empêche les scripts côté client (comme JavaScript) d’accéder au cookie de session. Cela protège contre les attaques XSS (Cross-Site Scripting))
    'samesite' => 'Strict'     // Protection contre CSRF (limite l’envoi du cookie aux requêtes provenant du même site (pas de requêtes cross-site). Cela protège contre les attaques CSRF (Cross-Site Request Forgery))
]);


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données."; // Débogage
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
