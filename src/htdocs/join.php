<?php
session_start();
include('./app/cred.php');
$id = $_GET['id'];
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO accounts_owned(login, project_id, project, project_name, project_icon, permissions) 
  VALUES(".json_encode($_SESSION['id']).", ".json_encode($_GET['id']).", ".json_encode($_GET['name']).", ".json_encode($_GET['name']).", ".json_encode($_GET['icon']).", ".json_encode($_GET['p']).")";
  $conn->exec($sql);
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>
<script>window.location.href="https://devlist.rf.gd/app/";</script>