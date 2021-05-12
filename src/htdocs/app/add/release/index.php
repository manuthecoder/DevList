<?php
session_start();
include('../../cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO releases(name, description, version, date, project) 
VALUES(".json_encode($_POST['name']).", ".json_encode($_POST['description']).", ".json_encode($_POST['version']).", ".json_encode($_POST['date']).",  ".json_encode($_POST['project']).")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null; 
?>