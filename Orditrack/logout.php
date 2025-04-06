<?php
require 'config.php';

session_unset();//La fonction supprime toutes les variables stockées dans la session (comme le nom d’utilisateur ou le rôle).
session_destroy();//La fonction détruit complètement la session, ce qui déconnecte l’utilisateur.
header("Location: index.php");
exit;
?>