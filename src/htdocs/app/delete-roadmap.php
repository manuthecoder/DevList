<?php
include('cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM roadmap WHERE id=".$_GET['id'];
  $conn->exec($sql);
  echo '<script>AJAX_LOAD(\'https://devlist.rf.gd/app/roadmap.php?id='.$_GET['project'].'\')</script>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>