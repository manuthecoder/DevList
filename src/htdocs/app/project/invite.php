<?php 
session_start();
include('../cred.php');
$hash = hash('crc32b', rand(0, 10000));
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO invites (permissions, project, code)
VALUES (".json_encode($_POST['perms']).", ".json_encode($_POST['id']).", ".json_encode($hash).")";
if ($conn->query($sql) === TRUE) {
  echo $hash;
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>