<?php
/*
$password = '1234'; // Mot de passe actuel de user et admin
echo password_hash($password, PASSWORD_DEFAULT) . "\n";

$new_password = 'nouveauMDP'; // Remplace par le mot de passe souhaité
echo password_hash($new_password, PASSWORD_DEFAULT) . "\n";
*/

// hash_passwords.php
$new_password = '1234'; // Mot de passe lisible choisi pour le nouvel utilisateur
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
echo "Mot de passe lisible : $new_password\n";
echo "Mot de passe haché : $hashed_password\n";





?>