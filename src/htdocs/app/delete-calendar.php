<?php
include('cred.php');
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM calendar WHERE id=".$_GET['id'];
  $conn->exec($sql);
  echo '<script>$(".modal").modal("close");AJAX_LOAD(\'https://devlist.rf.gd/app/home.php?scroll_to_bottom\')</script>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
?>