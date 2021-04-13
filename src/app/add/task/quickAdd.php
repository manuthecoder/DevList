<?php
include('cred.php');
$name = str_replace("<", "",str_replace("?", "",  $_GET['name']));
$description = str_replace("<", "",str_replace("?", "", $_GET['description']));
$priority = str_replace("<", "",str_replace("?", "", $_GET['priority']));
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO todo(name, description, priority, project,stat) 
  VALUES(".json_encode($name).", ".json_encode($description).", ".json_encode($priority).", ".json_encode($_GET['project']).", \"todo\")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null;
?>