<?php
$host = "localhost";  // L'hôte de la base de données
$database = "banque";  // Nom de votre base de données
$username = "root";  // Nom d'utilisateur de la base de données
$password = "";  // Mot de passe de la base de données

try {
    $conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}
?>
