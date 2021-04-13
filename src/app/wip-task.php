<?php
include('cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE todo SET stat='Work In Progress' WHERE id=".$_GET['id'];
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  echo '<script>document.getElementById("noTasks1").style.display="none";M.toast({html: "Moved task successfully"})</script>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>