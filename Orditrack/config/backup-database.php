<?php
// backup-database.php : Configuration de sauvegarde de la base de données
// Ce fichier peut être utilisé pour des configurations alternatives ou de test

$host = 'localhost';
$dbname = 'gestion_pret_pc';
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie à la base de données (backup)."; 
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
