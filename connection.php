<?php
session_start();
require_once("./pdo.php");

if (isset($_POST["submit"])){
  if(!empty($_POST['name']) && !empty($_POST['password'])) {
    $name = htmlspecialchars($_POST['name']);
    $password = hash('sha256', $_POST['password']);
    // $user_id = $_POST["user_id"];
    $recupUser = $pdo->prepare("SELECT * FROM users WHERE name = ? AND password = ?");
    $recupUser->execute(array($name, $password,));
    if ($recupUser->rowCount()> 0){
      $_SESSION['name'] = $name ;
      $_SESSION['id'] = $recupUser->fetch()['user_id'];
      $_SESSION['success']= "Utilisateur connecté";
      header("Location: app.php");
    }
    else {
      $_SESSION['error']= "votre pseudo ou mot de passe est incorrect";
    }
  }
  else{
   $_SESSION['error']= "veuillez remplir tout les champs";
   header("Location: connection.php");
   return;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connection</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="normalize.css">
</head>
<body>
     <form method="POST" class="form">

      <?php 
      if (isset($_SESSION['error'] )) {
        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
        unset($_SESSION['error']);
      }
      ?>
      
  <div class="form-row">
    <label for="name">Enter your user name: <br></label>
    <input type="text" name="name" id="name" >
  </div>
  <div class="form-row">
    <label for="password">Enter your email: <br></label>
    <input type="password" name="password" id="password">
  </div>
  <div class="btn btn-block">
    <input type="submit" name = "submit">
  </div>
   <div>
    <a href="./index.php">annuler</a>
  </div>
</form>
</body>
</html>