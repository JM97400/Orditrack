<?php
// config.php : Connexion à la base de données

$host = 'localhost';
$dbname = 'gestion_pret_pc';
$username = 'root'; // À modifier selon votre config
$password = ''; // À modifier selon votre config

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connexion réussie à la base de données."; // Débogage
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
