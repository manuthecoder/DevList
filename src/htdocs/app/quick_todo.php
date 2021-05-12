<?php
session_start();
include('cred.php');
?>
<div class="col s4">
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
             <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'wip-task.php?id='.$row['id'].'\');document.getElementById(\'workInProgress_container\').appendChild(this.parentElement.parentElement)"><i class="material-icons">work</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'done-task.php?id='.$row['id'].'\');document.getElementById(\'doneContainer\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-task.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
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
    <div class="col s4" id="workInProgress_container">
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
                <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'done-task.php?id='.$row['id'].'\');document.getElementById(\'doneContainer\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-task.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
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
    <div class="col s4" id="doneContainer">
    <p class="center">Done</p>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM todo WHERE project=" . $_GET['id']. " AND stat='Done' ORDER by id DESC";
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
            <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-task.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
        </div>';
    }
    }
    else {
        echo "<div class='no_results' id='noTasks2'><p style='color:gray'>No tasks</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>