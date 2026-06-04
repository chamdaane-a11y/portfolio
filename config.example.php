<?php
// Modèle de configuration — copiez ce fichier en `config.php` puis renseignez vos identifiants.
//   cp config.example.php config.php

define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_USER', 'root');
define('DB_PASS', '');          // <-- votre mot de passe MySQL
define('DB_NAME', 'portofolio');

try {
    // Connexion TCP (127.0.0.1 + port) pour éviter les soucis de socket Unix
    $connexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if ($connexion->connect_error) {
        die('Erreur de connexion : ' . $connexion->connect_error);
    }

    $connexion->set_charset('utf8');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>
