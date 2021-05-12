<?php
session_start();
include('../../cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO `roadmap`(`startDate`, `endDate`, `name`, `duration`, `percent`, `project`)
VALUES(".json_encode($_POST['start']).", ".json_encode($_POST['end']).", ".json_encode($_POST['name']).",  ".json_encode(1).", ".json_encode($_POST['percent']).", ".json_encode($_POST['project']).")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null;
?>