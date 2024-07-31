<?php
require_once 'dbconfig.php';

// Vérifier si un message de suppression est présent dans la session
$messageSuppression = '';
if (isset($_SESSION['suppression_message'])) {
    $messageSuppression = $_SESSION['suppression_message'];
    unset($_SESSION['suppression_message']); // Supprimer le message après l'avoir affiché
}

// Récupérer la liste complète des comptes
try {
    $stmt = $conn->prepare("SELECT * FROM compte");
    $stmt->execute();
    $comptes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit; // Arrête le script en cas d'erreur
}

// Traitement de la requête de recherche
if(isset($_GET['code_recherche'])) {
    $codeRecherche = $_GET['code_recherche'];
    header("Location: rechercher.php?code_recherche=" . urlencode($codeRecherche));
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Banque</title>
    
    <script>
         function confirmerSuppression(code) {
            var confirmation = confirm("Êtes-vous sûr de vouloir supprimer ce compte ?");
            if (confirmation) {
                window.location.href = "supprimer_compte.php?code=" + code;
            }
        }
         function convertirEnDinar(code) {
            // Récupérer le solde actuel
            var soldeElement = document.getElementById('solde_' + code);
            var solde = parseFloat(soldeElement.innerHTML);
            
            // Convertir en dinar
            var soldeEnDinar = solde * 3.2;

            // Mettre à jour le contenu de la boîte de dialogue
            var conversionResult = "Solde converti en dinar : " + soldeEnDinar.toFixed(2) + " DT";
            document.getElementById('conversion-result').innerHTML = conversionResult;

            // Afficher la boîte de dialogue
            openConversionModal();
        }

        function openConversionModal() {
            document.getElementById('conversion-modal').style.display = 'flex';
        }

        function closeConversionModal() {
            document.getElementById('conversion-modal').style.display = 'none';
        }
    </script>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
            font-family:Georgia,serif;

        }

        h1 {
            text-align: center;
            color: #191970;
            margin-bottom: 30px;
        }

        button {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-family:Georgia,serif
        }

        button:hover {
            background-color: #555;
        }

        form {
            text-align: center;
            margin-top:20px;
            margin-left:-800px
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #191970	;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .success-message {
            color: #008000;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            font-family:Georgia,serif
        }

        .confirmation-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            font-family:Georgia,serif
        }

        .confirmation-modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-family:Georgia,serif
        }

        .confirmation-modal button {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            font-family:Georgia,serif
        }

        .confirmation-modal button.cancel {
            background-color: #ccc;
            font-family:Georgia,serif
        }

        a {
            color: #333;
            text-decoration: none;
            font-family:Georgia,serif
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
        }
        #aa{margin-top:10px;}
        nav {
            padding: 5px;
            text-align: right;
            background-color: #191970	;
            color: white;
            
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-family:Georgia,serif
        }

        nav a:hover {
            text-decoration: underline;
            font-family:Georgia,serif
        }
        #conversion-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            text-align: center;
            color: 	#191970;
            font-family: Georgia, serif;
        }

        #conversion-modal-content {
            background-color: 	#191970;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            font-family: Georgia, serif;
        }

        #conversion-modal button {
            background-color: #333;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
            font-family: Georgia, serif;
        }
    </style>
</head>
<body>
<div class="confirmation-modal" id="conversion-modal">
        <div class="confirmation-modal-content">
            <span id="conversion-result"></span>
            <button onclick="closeConversionModal()">Fermer</button>
        </div>
    </div>
<nav>
        <a href="login.php"><img src="logout.png" style="width:30px"/></a>
    </nav>
    <?php if(!empty($messageSuppression)): ?>
        <div style="color: green; font-weight: bold;"><?php echo $messageSuppression; ?></div>
    <?php endif; ?>
    <i class="fa fa-sign-out" aria-hidden="true"></i>
    <h1>Liste des Comptes</h1>
    <a href="ajouter_compte.php" >
        <button style="background-color:#C71585;margin-left:1000px" id="aa">Ajouter un nouveau compte</button>
    </a>

    <!-- Formulaire de recherche -->
    <form method="get" action="">
        <label for="code_recherche">Rechercher par code :</label>
        <input type="text" name="code_recherche" required style="font-family:Georgia,serif">
        <input type="submit" value="Rechercher" style="font-family:Georgia,serif;background-color:#483D8B;color:white">
    </form>

    <?php if(isset($comptes) && !empty($comptes)): ?>
        <table border="1">
            <tr>
                <th>Code</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Solde</th>
                <th>Date de Création</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($comptes as $compte): ?>
                <tr>
                    <td><?php echo htmlspecialchars($compte['code']); ?></td>
                    <td><?php echo htmlspecialchars($compte['nom']); ?></td>
                    <td><?php echo htmlspecialchars($compte['prenom']); ?></td>
                    <td id="solde_<?php echo htmlspecialchars($compte['code']); ?>"><?php echo htmlspecialchars($compte['solde']); ?> €</td>
                    <td><?php echo htmlspecialchars($compte['datecreation']); ?></td>
                    <td>
                    <button style="background-color: #006400"><a href="modifier_compte.php?code=<?php echo htmlspecialchars($compte['code']); ?>" style="text-decoration: none; color: white;">Modifier</a></button>

                    <button onclick="confirmerSuppression('<?php echo htmlspecialchars($compte['code']); ?>')"  style="background-color:#8B0000">Supprimer</button>
                        <button style="background-color:#ADD8E6" onclick="convertirEnDinar('<?php echo htmlspecialchars($compte['code']); ?>')">Convertir</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Aucun compte trouvé.</p>
    <?php endif; ?>
</body>
</html>
