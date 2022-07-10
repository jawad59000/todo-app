<?php
session_start();
require_once("./pdo.php");
$success = $_SESSION["success"] ?? false;
$error = $_SESSION["error"] ?? false;
$task_id = $_GET["task_id"] ?? '';

$sql = "SELECT * FROM tasks WHERE task_id = :task_id";
$query = $pdo->prepare($sql);
$query->execute([
    ":task_id" => $_GET["task_id"]
]);
$result = $query->fetch(PDO::FETCH_ASSOC);


if (isset($_POST["save"])) {
  if (empty($_POST["title"])){
    $_SESSION["error"] = "veuillez remplir le champs";
    header("Location: edit.php?task_id=" . $task_id);
    return;
  }
  
    $title = $_POST["title"];
    $updateQuery = "UPDATE tasks SET title = :title WHERE task_id = :task_id";
    $query = $pdo->prepare($updateQuery);
    $query->execute([
        ":task_id" => $task_id,
        ":title" => $title
    ]);
    $_SESSION["success"] = "Tache modifiée avec succes";
    header("Location: app.php");
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editer</title>
</head>

<body>
    <h1>Editer une Tâche</h1>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editer</title>
</head>

<body>
 <?php
  if($success) {
    echo "<p>$success</p>";
    unset($_SESSION["success"]);
  }

  if($error) {
    echo "<p>$error</p>";
    unset($_SESSION["error"]);
  }
  ?>

  <div>
      <form method="POST">
      <input type="text" name="title" value=" <?= $result["title"]?>">
      <input type="submit" name="save" value="Enregistrer">
      <a href="./app.php">annuler</a>
      </form>
  </div> 

</body>

</html>
</body>

</html>