<?php
include('cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM todo WHERE id=".$_GET['id'];
  $conn->exec($sql);
  echo '<script>M.toast({html: "Deleted task successfully"})</script>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>