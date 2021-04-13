<?php 
if(isset($_GET['valid'])) {
session_start();
session_destroy();
header('Location: ./login');
exit();
}
?>

<div class="container center">
<div class="container center">
<div class="container center">
<h5>Logout?</h5>
<p>Are you sure you want to log out? You will have to log back in next time</p>
<a class="btn waves-effect waves-light red darken-3 waves-light" style="width: 100%;line-height: 40px;height: 40px" href="logout.php?valid">Logout</a>
</div></div></div>