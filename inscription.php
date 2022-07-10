<?php
session_start();
require_once("./pdo.php");

$error = $_SESSION["error"] ?? false;
// $name = $_POST["name"] ?? "";

if (isset($_POST["submit"])){
  if(!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['password_retype'])) {
     if(hash('sha256', $_POST['password']) === (hash('sha256', $_POST['password_retype']))){
      $password = hash('sha256', $_POST['password']);
      $sql = 'INSERT INTO users (name, password) VALUES (:name, :password)';
      $insert = $pdo->prepare($sql);

      $insert->execute([
        ':name' => $_POST['name'],
        ':password' => $password
      ]);
      $_SESSION["success"] = "utilisateur ajouté";
      header("Location: index.php");
      return;
  } else {
     $_SESSION["error"] = "les deux champs mots de passe doivent etre identique";
    header("Location: inscription.php");
    return;
  }
  } else {
    $_SESSION["error"] = "Veuillez remplir tous les champs";
    header("Location: inscription.php");
    return;
  }
}

//     $name = htmlspecialchars($_POST["name"]);
//     $password = htmlspecialchars($_POST["password"]);
//     $password_retype = htmlspecialchars($_POST["password_retype"]);

//     // on vérifie s'il existe deja dans la base de données
//     $check = $pdo->prepare('SELECT name, password FROM users where name = ?');
//     $check->execute(array($name));
//     // on stocke les données dans data
//     $data = $check->fetch();
//     $row = $check->rowCount();

//    {$err_vide = 'Erreur un champ est vide!';}
//    unset($_SESSION[$err_vide]);

            
//     if($row == 0){
//         if($password == $password_retype){
//             $password = hash('sha256', $password);

//             // on fait une requête pour ajouter le nouvel utilisateur dans la bdd qu'on stocke dans une variable(facultatif)
            // $sql = 'INSERT INTO users (name, password) VALUES (:name, :password)';
            // $insert = $pdo->prepare($sql);

            // $insert->execute([
            //     'name' => $name,
            //     'password' => $password
            // ]);
            

//             header("Location: inscription.php?reg_err=success");
//         }else header("Location: inscription.php?reg_err=password");
//     }else header("Location: inscription.php?reg_err=already");

// }

//             if(isset($_GET['reg_err'])){
//                 $err = htmlspecialchars($_GET['reg_err']);

//                 switch($err){

//                     case 'success' :
                         ?>
<!-- //                         <div class="alert alert-success">
//                             <strong>Succès</strong> inscription réussie
//                         </div> -->
                        <?php
//                         break;

//                    case 'password' :
                        ?>
<!-- //                         <div class="alert alert-danger">
//                             <strong>Erreur</strong> mot de passe différent
//                         </div> -->
                       <?php
//                         break;

//                     case 'already' :
//                         ?>
<!-- //                         <div class="alert alert-danger">
//                             <strong>Erreur</strong> compte déjà existant
//                         </div> -->
                        <?php
//                         break;
//                 }
//             }          
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'enregistrer</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./normalize.css">
</head>
<body>

<?php
// if(isset($_Post[$err_vide])){
//   echo ("Erreur un champ est vide!");
// }
?>
    <div class="title">
        <h2>enregistrez-vous</h2>
        <div class="title-underline"></div>
    </div>
    <?php
      if($error) {
        echo "<p>$error</p>";
        unset($_SESSION["error"]);
      }
    ?>
    <form method="POST" class="form">
        <div class="form-row">
            <label for="name" class="form-label">nom d'utilisateur : </label>
            <input type="text" name="name" class="form-input">
        </div>
        <div class="form-row">
            <label for="password" class="form-label">mot de passe : </label>
            <input type="password" name="password" class="form-input">
        </div>
        <div class="form-row">
            <label for="password-retype" class="form-label">confirmer le mot de passe : </label>
            <input type="password" name="password_retype" class="form-input">
        </div>
        <button type="submit" name="submit" class="btn btn-block">s'enregistrer</button>
        <br>
        <a href="./index.php">Annuler</a>
    </form>
</body>
</html>