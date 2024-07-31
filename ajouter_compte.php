<?php
require_once 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $code = $_POST['code'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $solde = $_POST['solde'];
    $datecreation = $_POST['datecreation'];

    // Vérifier si le code existe déjà
    $stmtCheckCode = $conn->prepare("SELECT code FROM compte WHERE code = :code");
    $stmtCheckCode->bindParam(':code', $code);
    $stmtCheckCode->execute();

    if ($stmtCheckCode->rowCount() > 0) {
        echo '<script>alert("Le code existe déjà. Veuillez choisir un autre code.");</script>';
    } else {
        // Le code n'existe pas, procéder à l'insertion
        try {
            $stmt = $conn->prepare("INSERT INTO compte (code, nom, prenom, solde, datecreation) VALUES (:code, :nom, :prenom, :solde, :datecreation)");
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':solde', $solde);
            $stmt->bindParam(':datecreation', $datecreation);

            $stmt->execute();

            echo '<script>alert("Compte ajouté avec succès!"); window.location.href = "index.php";</script>';
        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Compte</title>
    <style>
        body {
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
            font-family:Georgia,serif
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom:500px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 200px;
            height:50px;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            font-family:Georgia,serif;
            display: inline-block;
            border-radius:10px
        }

        input[type="date"] {
            padding: 8px;
            font-family:Georgia,serif;
            width: 400px;
            height:50px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-family:Georgia,serif;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: ##341572;
            text-decoration: none;
        }

        a:hover {
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
    margin-left:-1100px;
    
    
    > * {
        margin: 0 20px;
    }
}

nav {
            padding: 5px;
            text-align: right;
            background-color: #191970	;
            color: white;
            margin-top:0px;

            
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: -1100px;
            font-family:Georgia,serif;
            margin-top:5px;
        }

        nav a:hover {
            text-decoration: underline;
            font-family:Georgia,serif
        }

    </style>
    <script>
        function confirmerAjout() {
            var confirmation = confirm("Voulez-vous vraiment ajouter ce compte?");
            if (confirmation) {
            
                window.location.href = "index.php"; 
            } else {
                return false; 
            }
        }
    </script>
</head>
<body>
<nav>
<a href="login.php"><img src="logout.png" style="width:30px"/></a>

</nav>  
<a href="index.php"> <div class="arrow-wrapper">

<div class="arrow-left"></div>Retourne
</div></a>
   
</div>
    <h2 style="color:#00008B;margin-top:-20px">Ajouter un nouveau Compte</h2>

    <form method="post" action="" onsubmit="return confirmerAjout();">
        <div style="display: flex; justify-content: space-between;">
            <div style="width: 48%;">
                <label for="code">Code:</label>
                <input type="text" name="code" required placeholder="Entrer Code">
            </div>
            <div style="width: 48%;">
                <label for="nom">Nom:</label>
                <input type="text" name="nom" required placeholder="Entrer Nom">
            </div>
        </div>

        <div style="display: flex; justify-content: space-between;">
            <div style="width: 48%;">
                <label for="prenom">Prénom:</label>
                <input type="text" name="prenom" required placeholder="Entrer Prénom" style="font-family:Georgia,serif">
            </div>
            <div style="width: 48%;">
                <label for="solde">Solde:</label>
                <input type="number" name="solde" required placeholder="Entrer Solde">
            </div>
        </div>

        <label for="datecreation">Date de Création:</label>
        <input type="date" name="datecreation" required placeholder="Entre Date de création">

        <input type="submit" value="Ajouter" style="background-color: color:#00008B">
    </form>
    
</body>
</html>
