<?php
session_start();
include('../cred.php');
if(isset($_GET['confirm'])) {
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM accounts WHERE id=".$_SESSION['id'];
  $conn->exec($sql);
  header('Location: https://devlist.rf.gd/app/logout.php?valid');exit();
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
}
else {
?>
<div class="container center">
<div class="container center">
<div class="container center">
<h5>Delete?</h5>
<p>Are you <i>extremely</i> sure you want to delete your account? <b>This action is irreversible!</b> All your projects will deleted too!</p>
<a class="btn waves-effect waves-light red darken-3 waves-light" style="width: 100%;line-height: 40px;height: 40px" href="./user/delete.php?confirm">Delete</a>
</div></div></div>
<?php } ?>