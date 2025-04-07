<?php

////////////////////////////////////////////////////////////////////////////////////////////
/////////// !!  Taper la commande dans le terminal : php hash_passwords.php !! ////////////
//////////////////////////////////////////////////////////////////////////////////////////


/* Quand l'utilisateur existe déjà ==>
$password = '1234'; // Mot de passe actuel de user et admin
echo password_hash($password, PASSWORD_DEFAULT) . "\n";

// Pour modifier un mot de passe ==>
$new_password = 'nouveauMDP'; // Remplace par le mot de passe souhaité
echo password_hash($new_password, PASSWORD_DEFAULT) . "\n";
*/

//////// Création d'un nouveau mot de passe pour nouvel utilisateur ////////
// ====> Cela fournira un mot de passe hashé en fonction du MDP visible <====

$new_password = '1234'; // Mot de passe lisible choisi pour le nouvel utilisateur
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
echo "Mot de passe lisible : $new_password\n";
echo "Mot de passe haché : $hashed_password\n";

?>