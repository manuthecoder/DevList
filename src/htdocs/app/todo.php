<?php
session_start();
include('cred.php');
?>
<?php
$perms = 'Admin';
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM accounts_owned WHERE project_id=" . $_GET['id']. " AND login='".$_SESSION['id']."' ORDER by id DESC";
    $users = $dbh->query($sql);
    foreach($users as $row) {
        $perms = $row['permissions'];
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?>
<div class='row' style="padding:0 30px" id="TODO_LOADER">
    <div class="col s12 m4">
    <p class="center">Todo</p>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM todo WHERE project=" . $_GET['id']. " AND stat='Todo' ORDER by id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            <div class="card-content waves-effect" onclick=\'todo('.json_encode($row['id']).', this)\'>
                <h5 style="margin:0;">'.$row['name'].'</h5>
                <h6>'.htmlspecialchars($row['description']).'</h6><p>Priority: '.$row['priority'].'</p>
            </div>
               '.($perms !== "View Only" ? '<div class="card-action"><a href="#!" onclick="this.style.display=\'none\';$(\'#__AJAX_LOADER\').load(\'wip-task.php?id='.$row['id'].'\');document.getElementById(\'workInProgress_container\').appendChild(this.parentElement.parentElement)"><i class="material-icons">work</i></a>
                <a href="#!" onclick="this.style.display=\'none\';$(\'#__AJAX_LOADER\').load(\'done-task.php?id='.$row['id'].'\');document.getElementById(\'doneContainer\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-task.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a></div>': ""). '
        </div>';
    }
    }
    else {
        echo "<div class='no_results' id='noTasks'><p style='color:gray'>No tasks</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>
    <div class="col s12 m4" id="workInProgress_container">
    <p class="center">WIP</p>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM todo WHERE project=" . $_GET['id']. " AND stat='Work In Progress' ORDER by id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
        foreach ($users as $row){
            echo '
            <div class="card">
                <div class="waves-effect card-content" onclick=\'todo('.json_encode($row['id']).', this)\'>
                    <h5 style="margin:0;">'.$row['name'].'</h5>
                    <h6>'.htmlspecialchars($row['description']).'</h6><p>Priority: '.$row['priority'].'</p>
                </div>
                '.($perms !== "View Only" ? ' <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'done-task.php?id='.$row['id'].'\');document.getElementById(\'doneContainer\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-task.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>': ""). '
            </div>';
        }
    }
    else {
        echo "<div class='no_results' id='noTasks1'><p style='color:gray'>No tasks</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>
    <div class="col s12 m4" id="doneContainer">
    <p class="center">Done</p>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM todo WHERE project=" . $_GET['id']. " AND stat='Done' ORDER by id DESC LIMIT 10";
    $users = $dbh->query($sql);
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card" >
            <div class="card-content waves-effect" onclick=\'todo('.json_encode($row['id']).', this)\'>
                <h5 style="margin:0;">'.$row['name'].'</h5>
                <h6>'.htmlspecialchars($row['description']).'</h6><p>Priority: '.$row['priority'].'</p>
            </div>
           '.($perms !== "View Only" ? '  <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-task.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>': ""). '
        </div>
        ';
    }
    echo '<button onclick="AJAX_LOAD(\'extend-task.php?id='.$_GET['id'].'&count=20\')" class="btn darken-3 red waves-effect waves-light" style="width: 100%;display:block;">Load More</button>';
    }
    else {
        echo "<div class='no_results' id='noTasks2'><p style='color:gray'>No tasks</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>
</div>
<?php if($perms !== "View Only") {
    ?>
<!-- href="./add/task/?id=<?php echo $_GET['id']; ?>""   -->
<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('add_popup').style.display = 'block';document.getElementById('__popup').style.display = 'block';document.getElementById('add_priority').focus();document.getElementById('add_name').focus();document.getElementById('__banner').style.display = 'none'; document.getElementById('err__banner').style.display = 'none';">
    <i class="large material-icons">add</i>
</a>
<style>
    @keyframes overlay {0%{opacity:0;} 100% {opacity:1}}
    @keyframes _popup {0%{transform:scale(0);}}
</style>
<div id="add_popup" class="overlay" onclick='this.style.display = "none";document.getElementById("__popup").style.display = "none"'></div>
    <div class="popup" id="__popup">
    <h4 style="margin:0;">Add</h4><br>
        <form action="add.php" method="POST" id="__addForm">
          <div class="input-field">
            <label>Name</label>
            <input type="text" id="add_name" name="name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Priority (1-5)</label>
            <input id="add_priority" type="text" name="priority" autocomplete="off" value="3">
          </div>
          <div class="input-field">
            <label>Description</label>
            <textarea type="text" name="description" class="materialize-textarea" autocomplete="off"></textarea>
          </div>
          <input type="hidden" name="project" value="<?php echo $_GET['id'];?>">
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='__banner'>
                Successfully added task! You can keep adding more.
            </div>
            <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='err__banner'>
                All fields are required
            </div>
          </form>
    </div>
<script>
var __id = <?php echo $_GET["id"];?>;
// this is the id of the form
$("#__addForm").submit(function(e) {
    if(document.getElementById('add_name').value == '' || document.getElementById('add_name').value == null || document.getElementById('add_priority').value == '' || document.getElementById('add_priority').value == null ) {
        document.getElementById('__banner').style.display = 'none';
        document.getElementById('err__banner').style.display = 'none';
        document.getElementById('err__banner').style.display = 'block';
        return false;
    }
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(),
           success: function(data)
           {
            $("#TODO_LOADER").load("quick_todo.php?id="+__id);
            document.getElementById('__addForm').reset();
            document.getElementById('add_priority').value = 1;
            document.getElementById('add_priority').focus();
            document.getElementById('add_name').focus()
            document.getElementById('__banner').style.display = 'none';
            document.getElementById('err__banner').style.display = 'none';
            document.getElementById('__banner').style.display = 'block'
           }
         });
});
window.onkeyup = null;
window.onkeyup = function(e) {
    if(e.keyCode == 191) {
        document.getElementById('add_popup').style.display = 'block';document.getElementById('__popup').style.display = 'block';document.getElementById('add_priority').focus();document.getElementById('add_name').focus();document.getElementById('__banner').style.display = 'none'; document.getElementById('err__banner').style.display = 'none';
    }
}
</script>
<?php } ?>