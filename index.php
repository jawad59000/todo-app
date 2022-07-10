<?php
session_start();
$success = $_SESSION["success"] ?? false;

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>page d'accueil</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="normalize.css">
</head>
<body>
    <?php
    if($success) {
        echo "<p>$success</p>";
        unset($_SESSION["success"]);
      }
      ?>
   <h1>bienvenue dans la base de données des tâches</h1>
   <p id="identification" ><a href="./inscription.php">Enrengistrer-Vous</a> / <a href="connection.php">Connecter-Vous</a></p>
   <p  > Essayez d'<a href="app.php">app.php</a> sans vous connecter.</p>
</body>
</html>