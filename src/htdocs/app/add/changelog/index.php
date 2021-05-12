<?php
session_start();
include('../../cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO changelog(name, date, item_order, project, description, milestone) 
VALUES(".json_encode($_POST['changelog_name']).", ".json_encode($_POST['changelog_date']).", \"1\", ".json_encode($_POST['project']).",  ".json_encode($_POST['changelog_desc']).", ".json_encode(($_POST['milestone'] == true ? 'true' : '')).")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null; 
?>