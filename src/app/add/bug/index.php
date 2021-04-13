<?php
session_start();
include('../../cred.php');
$name = str_replace("<", "",str_replace("?", "",  $_POST['name']));
$error = str_replace("<", "",str_replace("?", "", $_POST['error']));
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO bugs(name, error, language, project, login, stats) 
          VALUES(".json_encode($name).", ".json_encode($error).", \"\", ".json_encode($_POST['project']).",  ".json_encode($_SESSION['id']).", \"Active\")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null;
?>
