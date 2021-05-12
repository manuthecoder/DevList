<?php
session_start();
include('cred.php');
$name = str_replace("<", "",str_replace("?", "",  $_POST['name']));
$description = str_replace("<", "",str_replace("?", "", $_POST['description']));
$priority = str_replace("<", "",str_replace("?", "", $_POST['priority']));
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO todo(name, description, priority, project, stat, login) 
VALUES(".json_encode($name).", ".json_encode($description).", ".json_encode($priority).", ".json_encode($_POST['project']).", \"todo\", ".json_encode($_SESSION['id']).")";
  $conn->exec($sql);
//   header("Location: ./");
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null;
?>