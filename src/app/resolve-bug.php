<?php
include('cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "UPDATE bugs SET stats='Resolved' WHERE id=".$_GET['id'];
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  echo '<script>document.getElementById("__noResContainer").style.display="none";M.toast({html: "Resolved bug successfully"})</script>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
?>