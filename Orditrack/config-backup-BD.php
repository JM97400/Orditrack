<?php
// config.php : Connexion à la base de données et configuration des sessions

$host = 'localhost';
$dbname = 'gestion_pret_pc';
$username = 'root'; 
$password = ''; // Pas de mot de passe pour root, comme à l'origine

// Durée maximale de la session : 30 minutes (en secondes)
$session_timeout = 1800; // soit 30 * 60 = 1800 secondes

// Vérifier si la session n'est pas déjà active avant de définir les paramètres
if (session_status() === PHP_SESSION_NONE) {
    // Configure les paramètres du cookie de session
    session_set_cookie_params([
        'lifetime' => $session_timeout, // Le cookie expire après 30 minutes
        'path' => '/',                  // Disponible sur tout le site
        'domain' => '',                 // Domaine actuel
        'secure' => false,              // Mettre true en production avec HTTPS
        'httponly' => true,             // Protection contre XSS
        'samesite' => 'Strict'          // Protection contre CSRF
    ]);
    // Démarrer la session uniquement si elle n'est pas déjà active
    session_start();
    
    // Si c'est une nouvelle session, initialise la dernière activité
    if (!isset($_SESSION['last_activity'])) {
        $_SESSION['last_activity'] = time(); // Heure actuelle en secondes
    }
}

// Vérifie si la session a expiré (30 minutes d'inactivité)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $session_timeout) {
    // Si plus de 30 minutes se sont écoulées, détruire la session
    session_unset();   // Supprime toutes les variables de session
    session_destroy(); // Détruit la session
    header("Location: login.php"); // Redirige vers la page de connexion
    exit;
}

// Met à jour la dernière activité à chaque chargement de page
$_SESSION['last_activity'] = time();

// Génère un jeton CSRF s’il n’existe pas
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Token aléatoire sécurisé
}

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Pour compatibilité avec login.php
    ]);
    // echo "Connexion réussie à la base de données."; 
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>