<?php
// Fonctions réutilisables utilisant des requêtes préparées
function getUserById($connexion, int $id)
{
    $stmt = $connexion->prepare('SELECT id_user, nom, prenom, email, bio, titre_professionnel, photo FROM users WHERE id_user = ?');
    if ($stmt === false) {
        return null;
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    return $user ?: null;
}

function getProjectsByUser($connexion, int $id)
{
    $stmt = $connexion->prepare('SELECT id_projet, titre, description, image_url FROM projets WHERE id_user = ?');
    if ($stmt === false) {
        return [];
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $projects = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $stmt->close();
    return $projects;
}

function getCompetencesByUser($connexion, int $id)
{
    $stmt = $connexion->prepare('SELECT type, titre, niveau FROM Competences WHERE id_user = ?');
    if ($stmt === false) {
        return [];
    }
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $competences = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    $stmt->close();
    return $competences;
}
