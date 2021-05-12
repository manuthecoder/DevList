<?php
session_start();
include('cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE roadmap SET name=".json_encode($_POST['name']).", startDate=".json_encode($_POST['start']).", endDate=".json_encode($_POST['end']).", percent=".json_encode($_POST['percent'])." WHERE id=".$_POST['id'];
  $stmt = $conn->prepare($sql);
  $stmt->execute();
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>