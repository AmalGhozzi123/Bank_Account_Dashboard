<?php
session_start(); // Démarre la session

// Vérifiez le nom d'utilisateur et le mot de passe ici
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] == 'admin' && $_POST['password'] == 'admin123') {
        // Les informations d'identification sont correctes, redirigez vers la page d'accueil ou autre page sécurisée
        $_SESSION['logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        // Les informations d'identification sont incorrectes, redirigez vers la page de connexion avec un message d'erreur
        header('Location: login.php?loginError=true');
        exit;
    }
}
?>
