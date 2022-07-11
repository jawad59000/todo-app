<?php
  session_start();
  require_once("./pdo.php");
  $success = $_SESSION["success"] ?? false;
  $error = $_SESSION["error"] ?? false;

  if (!isset($_SESSION["id"])){
    die("ACCES REFUSÉ");
  }

  if(isset($_POST["add"])){
   if(!empty($_POST["task"])){
    $sql = 'INSERT INTO tasks (title, user_id, task_id) VALUES (:title, :user_id, :task_id)';
    $insert = $pdo->prepare($sql);
     $insert->execute([
            ":title" => $_POST['task'],
            ":user_id" => $_SESSION['id'],
            ":task_id"=> $_SESSION['task_id']
        ]);
      $_SESSION["success"] = "tâche ajouté";
      header("Location: app.php");
      return;
  }
    else{
    $_SESSION["error"] = "Tous les champs sont requis";
    header("Location: app.php");
    return;
    }
  }
  $sql = "select * from tasks where user_id = :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ":user_id" => $_SESSION["id"]
  ]);
  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  // var_dump($data);
  
  
  if(isset($_POST['supprimer']) && isset($_POST["task_id"])){
    $sql = "DELETE FROM tasks WHERE task_id=:task_id ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ":task_id" => $_POST["task_id"]
    ]);
    $_SESSION["success"]= "La suppression à été correctement effectuée";
    header("Location: app.php");
    return;
  }
    if(isset($_POST['toutSupprimer'])){

    $sql = "DELETE FROM tasks WHERE user_id=:user_id ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      ":user_id" => $_SESSION["id"]
    ]);
    $_SESSION["success"]= "La suppression à été correctement effectuée";
    header("Location: app.php");
    return;
  }
  var_dump($_SESSION);
  
  
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>to do tache</title>
    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="normalize.css">
</head>
<body>
    <div class="form">
        <form method="POST">
            <h4>Tâches à faire </h4>
            <div>
             <?php
              if($success) {
              echo "<p>$success</p>";
              unset($_SESSION["success"]);
              }
              if($error) {
              echo "<p>$error</p>";
              unset($_SESSION["error"]);
              }
             
              
             ?></div>
            <div class="flex">
                <input type="text" name="task">
                <input type="submit" name="add" value="ajouter" class="btn">
            </div>
        </form>
        <div class="todo-item">
         <?php
            foreach ($data as $task) {
              $eol = <<<EOL
                <div>
                  <p>{$task['title']}</p>
                  <form method="POST" >
                    <input type="hidden" name="task_id" value="{$task['task_id']}" >
                    <input type="submit" name="supprimer" value="supprimer" class= "btn_delete">
                    <a href="./edit.php?task_id={$task['task_id']}">editer</a>
                  </form>
                </div>
              EOL;
              echo $eol;
            }
          ?>
        </div>
        <div>
          <form method = "POST">
          <input type="submit" value = 'tout supprimer' name = "toutSupprimer">
          </form>
        </div>

        <a href="./logout.php">Se déconnecter</a>
    </div>
</body>
</html>
</html>