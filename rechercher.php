<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de la recherche de compte</title>
    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family:Georgia,serif
        }

        .container {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 400px;
            max-width: 100%;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .result, .error {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
        }

        .result {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .error {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }
        .a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: ##341572;
            text-decoration: none;
        }

        .a:hover {
            text-decoration: underline;
        }
        .arrow-left {
    width: 15px;
    height: 26px;
    background-color: #341572;

    clip-path: polygon(100% 100%, 100% 0, 0 50%);
}
.arrow-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left:-100px;
    
    
    > * {
        margin: 0 20px;
    }
}


    </style>
</head>
<body>



    <?php
    require_once 'dbconfig.php';

    // Fonction de recherche par code
    function rechercherCompteParCode($code) {
        global $conn;
        try {
            $stmt = $conn->prepare("SELECT * FROM compte WHERE code = :code");
            $stmt->bindParam(':code', $code);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            exit;
        }
    }

    // Traitement de la requête GET
    if (isset($_GET['code_recherche'])) {
        $codeRecherche = $_GET['code_recherche'];

        // Appeler la fonction de recherche
        $compteRecherche = rechercherCompteParCode($codeRecherche);

        if ($compteRecherche) {
            echo '<div class="result">';
            echo "<h1>Compte trouvé</h1>";
            echo "<p><strong>Code:</strong> " . $compteRecherche['code'] . "</p>";
            echo "<p><strong>Nom:</strong> " . $compteRecherche['nom'] . "</p>";
            echo "<p><strong>Prénom:</strong> " . $compteRecherche['prenom'] . "</p>";
            echo "<p><strong>Solde (Euro):</strong> " . $compteRecherche['solde'] . "</p>";
            echo "<p><strong>Solde (Dinar):</strong> " . ($compteRecherche['solde'] * 3.2) . "</p>";
            echo "<p><strong>Date de Création:</strong> " . $compteRecherche['datecreation'] . "</p>";
            echo   "<a href='index.php'> Retourne</a>";

            echo '</div>';
        } else {
            echo '<div class="error">';
            echo "<h1>Aucun compte trouvé</h1>";
            echo "<p>Aucun compte trouvé pour le code : " . $codeRecherche . "</p>";
            echo   "<a href='index.php'> Retourne</a>";
            echo '</div>';
        }
    }
    ?>


</div>

</body>
</html>
