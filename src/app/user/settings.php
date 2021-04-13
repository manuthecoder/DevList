<?php 
session_start();
include('../cred.php');
?>

<div class="container"><br>
<a class='modal-trigger' onclick="$('#avatar_modal').modal('open')" href='#avatar_modal'><div class="waves-effect hover-zoom" style="border-radius:999px;width:100px;height:100px"><img src="<?php echo $_SESSION['avatar'];?>" height="100px" width="100px" style="border-radius:999px;"></div></a>
    <h2><b><?php echo $_SESSION['username'];?></b></h2>
    <h3><?php echo $_SESSION['email'];?></h3>
    <h4>User ID: <?php echo $_SESSION['id'];?></h4>
    <a class='modal-trigger btn blue-grey darken-3' href='#email_modal'>Change Email</a>
    <a class='modal-trigger btn blue-grey darken-3' href='#feedback_modal'>Send Feedback!</a>
</div>