<?php
session_start();
include('../../cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO calendar(title, startdate, enddate, login) 
VALUES(".json_encode($_POST['name']).", ".json_encode($_POST['startdate']).", ".$_POST['enddate'].", ".json_encode($_SESSION['id']).")";
  $conn->exec($sql);
} 
catch(PDOException $e) { echo $sql . "<br>" . $e->getMessage(); }
$conn = null;
?>