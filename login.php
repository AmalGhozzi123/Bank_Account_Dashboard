<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f5f5f5;
            font-family: Georgia, serif;
            color: black;

        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
            font-family: Georgia, serif

        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(
                #497AEC,
                #81E8B4
            );
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(
                to right,
                #EA7E69,
                #EEC183
            );
            right: -30px;
            bottom: -80px;
        }

        form {
            height: 520px;
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            color: black;
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
            font-family: Georgia, serif;

        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
            font-family: Georgia, serif;

        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
            font-family: Georgia, serif;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #4169E1;
            color: white;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;

            font-family: Georgia, serif;
        }

        button:hover {
            background-color: #071A52;
            color: white;
        }
    </style>

</head>

<body>

    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <form method="post" action="process_login.php">
        <img src="Banque_image.webp" style="width:300px;margin-left:200px;margin-top:-115px;" />

        <h2 style="font-family:Georgia,serif;text-align:center;margin-top:-90px;color:#080849">Connexion</h2>
        <label for="username" style="color:color:#080849">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" style="font-family:Georgia,serif;" required>

        <label for="password" style="color:color:#080849">Mot de passe:</label>
        <input type="password" id="password" name="password" style="font-family:Georgia,serif;" required>

        <button type="submit">Se connecter</button>
    </form>

    <div id="loginErrorModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center;">
        <div style="background-color: white; padding: 20px; border-radius: 5px; text-align: center;">
            <p style="color: red;">Le nom d'utilisateur ou le mot de passe est incorrect.</p>
            <button onclick="closeModal()">Fermer</button>
        </div>
    </div>

    <script>
        <?php
        if (isset($_GET['loginError']) && $_GET['loginError'] == 'true') {
            echo 'displayModal();';
        }
        ?>

        function displayModal() {
            document.getElementById('loginErrorModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('loginErrorModal').style.display = 'none';
        }
    </script>

</body>

</html>
