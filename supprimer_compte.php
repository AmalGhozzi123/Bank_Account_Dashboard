<?php
session_start();
require_once 'dbconfig.php';

if (isset($_GET['code'])) {
    $codeCompte = $_GET['code'];

    // Supprimer le compte
    try {
        $stmt = $conn->prepare("DELETE FROM compte WHERE code = :code");
        $stmt->bindParam(':code', $codeCompte);
        $stmt->execute();

        // Stocker le message de suppression dans la session
        $_SESSION['suppression_message'] = "Compte supprimé avec succès.";

        // Rediriger vers la page d'index
        header('Location: index.php');
        exit;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }
} else {
    // Rediriger vers la page d'index si le code n'est pas spécifié
    header('Location: index.php');
    exit;
}
?>
