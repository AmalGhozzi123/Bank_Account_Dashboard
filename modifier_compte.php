<?php
require_once 'dbconfig.php';

// Vérifier si le paramètre 'code' est présent dans l'URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Récupérer les détails du compte depuis la base de données
    try {
        $stmt = $conn->prepare("SELECT * FROM compte WHERE code = :code");
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        $compte = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le compte existe
        if (!$compte) {
            echo "Compte non trouvé.";
            exit;
        }
    } catch(PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }

    // Traitement du formulaire de modification
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newNom = $_POST['new_nom'];
        $newPrenom = $_POST['new_prenom'];
        $newSolde = $_POST['new_solde'];
        $newDateCreation = $_POST['new_datecreation'];

        // Mettre à jour les informations du compte dans la base de données
        try {
            $updateStmt = $conn->prepare("UPDATE compte SET nom = :nom, prenom = :prenom, solde = :solde, datecreation = :datecreation WHERE code = :code");
            $updateStmt->bindParam(':nom', $newNom);
            $updateStmt->bindParam(':prenom', $newPrenom);
            $updateStmt->bindParam(':solde', $newSolde);
            $updateStmt->bindParam(':datecreation', $newDateCreation);
            $updateStmt->bindParam(':code', $code);
            $updateStmt->execute();
            echo '<script>alert("Compte mis à jour avec succès!"); window.location.href = "index.php";</script>';

        } catch(PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
} else {
    echo "Paramètre 'code' manquant.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Compte</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            
            margin: 20px;
            font-family:Georgia,serif
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border-radius:5px
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
            font-family:Georgia,serif;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
            font-family:Georgia,serif
        }

        a {
            display: block;
            margin-top: px;
            color: #337ab7;
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
    margin-top:10px;
    
    
    > * {
        margin: 0 20px;
    }
}
nav {
            padding: 2px;
            text-align: right;
            background-color: #191970	;
            color: white;
            margin-top:-20px;
            margin-right :-20px;
            margin-left:-20px;
            
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-family:Georgia,serif;
            margin-bottom:10px;
        }

        nav a:hover {
            text-decoration: underline;
            font-family:Georgia,serif
        }
    </style>
    <script>
    function confirmerModification() {
        var confirmation = confirm("Voulez-vous vraiment modifier ce compte ?");
        return confirmation;
    }
</script>

</head>
<body>
<nav>
        <a href="login.php"><img src="logout.png" style="width:30px"/></a>

    </nav>
    <a href="index.php"> <div class="arrow-wrapper"  style="margin-top:10px;">

<div class="arrow-left"></div>Retourne
</div></a>
    <h2 style="color:#00008B">Modifier un Compte</h2><br>

<form method="post" action="" onsubmit="return confirmerModification();">

        <label for="new_nom">Nouveau Nom:</label>
        <input type="text" name="new_nom" value="<?php echo $compte['nom']; ?>" required style=" font-family:Georgia,serif"><br>

        <label for="new_prenom">Nouveau Prénom:</label>
        <input type="text" name="new_prenom" value="<?php echo $compte['prenom']; ?>" required  style=" font-family:Georgia,serif"><br>

        <label for="new_solde">Nouveau Solde:</label>
        <input type="text" name="new_solde" value="<?php echo $compte['solde']; ?>" required  style=" font-family:Georgia,serif"><br>

        <label for="new_datecreation">Nouvelle Date de Création:</label>
        <input type="date" name="new_datecreation" value="<?php echo $compte['datecreation']; ?>" required style=" font-family:Georgia,serif"><br>

        <input type="submit" value="Modifier" style="background-color:#4B0082;border-radius:5px">
    </form>
    
    <br>

</body>
</html>
