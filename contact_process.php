<?php
session_start();
include 'config.php';

// Vérifier si c'est une requête POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupérer et nettoyer les données
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $sujet = isset($_POST['sujet']) ? trim($_POST['sujet']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validation des champs
    $erreurs = [];
    
    if (empty($nom)) {
        $erreurs[] = 'Le nom est requis';
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = 'Une adresse email valide est requise';
    }
    
    if (empty($message)) {
        $erreurs[] = 'Le message est requis';
    }
    
    // Si pas d'erreurs, insérer dans la base de données
    if (empty($erreurs)) {
        try {
            // Utilise l'ID utilisateur stocké en session si présent, sinon valeur par défaut 1
            $user_id = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : 1;

            $stmt = $connexion->prepare("INSERT INTO Messages (`nom-exp`, `mail-exp`, sujet, message, date_envoie, user_id) VALUES (?, ?, ?, ?, NOW(), ?)");
            
            if ($stmt === false) {
                die('Erreur de préparation : ' . $connexion->error);
            }
            
            $stmt->bind_param('ssssi', $nom, $email, $sujet, $message, $user_id);
            
            if ($stmt->execute()) {
                // Succès
                $_SESSION['succes'] = 'Votre message a été envoyé avec succès !';
                header('Location: index.php');
                exit();
            } else {
                die('Erreur lors de l\'insertion : ' . $stmt->error);
            }
            
            $stmt->close();
            
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    } else {
        // Retourner les erreurs
        $_SESSION['erreurs'] = $erreurs;
        header('Location: index.php');
        exit();
    }
}

$connexion->close();
?>
