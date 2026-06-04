<?php
// Script simple pour basculer l'utilisateur en session (utilise requêtes préparées)
session_start();
require __DIR__ . '/config.php';
require __DIR__ . '/db_helpers.php';

// Récupère l'id utilisateur depuis GET ou POST
$user_id = null;
if (isset($_REQUEST['user_id'])) {
    $user_id = (int) $_REQUEST['user_id'];
}

if ($user_id && $user_id > 0) {
    // Essaie de récupérer l'utilisateur depuis la base
    $user = getUserById($connexion, $user_id);
    if ($user) {
        $_SESSION['user_id'] = (int) $user['id_user'];
        $_SESSION['user_name'] = trim($user['prenom'] . ' ' . $user['nom']);
        $_SESSION['succes'] = "Connecté en tant que " . $_SESSION['user_name'];
    } else {
        // si pas en DB, stocke l'id sans nom
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = 'User#' . $user_id;
        $_SESSION['succes'] = "Connecté en tant qu'utilisateur {$user_id}";
    }
}

header('Location: index.php');
exit();
