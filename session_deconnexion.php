<?php
session_start();  // Démarrer la session

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Rediriger l'utilisateur vers la page de connexion ou une autre page après la déconnexion
header("Location: login.php");
exit();
?>

