<?php
// Script de test de connexion MySQL
require __DIR__ . '/config.php';

// Si config.php a échoué, il aura déjà affiché/terminé.
if (!$connexion) {
    echo "Erreur: connexion non initialisée.";
    exit;
}

if ($connexion->connect_error) {
    echo 'Connexion échouée: ' . htmlspecialchars($connexion->connect_error);
    exit;
}

echo 'Connexion MySQL OK — serveur: ' . htmlspecialchars($connexion->server_info);

$connexion->close();

?>
