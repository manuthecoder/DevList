<?php
session_start();
include('../cred.php');
if(isset($_GET['confirm'])) {
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM todo WHERE project=".$_GET['id'];
  $conn->exec($sql);
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
if(isset($_GET['confirm'])) {
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM bugs WHERE project=".$_GET['id'];
  $conn->exec($sql);
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM accounts_owned WHERE project_id=".$_GET['id']. " AND login=".$_SESSION['id'];
  $conn->exec($sql);
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM projects WHERE id=".$_GET['id'];
  $conn->exec($sql);
  echo '<script>M.toast({html: "Deleted project successfully"})</script>';
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
header('Location: ../');
}
}
?>
<div class="container center">
<div class="container center">
<div class="container center">
<h5>Delete?</h5>
<p>Are you <i>extremely</i> sure you want to delete this project? <b>This action is irreversible!</b> All your bugs, and tasks will be deleted too.</p>
<a class="btn waves-effect waves-light red darken-3 waves-light" style="width: 100%;line-height: 40px;height: 40px" href="./project/delete-project.php?confirm&id=<?php echo $_GET['id']?>">Delete</a>
</div></div></div>