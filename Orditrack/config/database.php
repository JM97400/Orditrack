<?php
// database.php : Configuration de la connexion à la base de données

$host = 'localhost';
$dbname = 'gestion_pret_pc';
$username = 'root'; 
$password = ''; // Pas de mot de passe pour root, comme à l'origine

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
