<?php
session_start();
include('../../cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO links(project, content, img) 
VALUES(".json_encode($_POST['project']).", ".json_encode($_POST['content']).", ".json_encode(($_POST['image'] == true ? 'true' : '')).")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null; 
?>