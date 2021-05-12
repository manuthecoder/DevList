<?php session_start();include('cred.php'); ?>
    <div class="col s6">
    <p class="center">Active</p>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM bugs WHERE project=" . $_GET['id']. " AND stats='Active' ORDER BY id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            <div class="card-content waves-effect" onclick=\'bug('.json_encode($row['id']).', this)\'>
                <h5 style="margin:0;">'.$row['name'].'</h5>
                <p>Error: '.$row['error'].'</p>
            </div>
             <div class="card-action">
                <a href="#!" onclick="this.style.display=\'none\'; $(\'#__AJAX_LOADER\').load(\'resolve-bug.php?id='.$row['id'].'\');document.getElementById(\'res_task\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-bug.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
        </div>';
    }
    }
    else {
        echo "<div class='no_results'><p style='color:gray'><img src='https://www.columnfivemedia.com/wp-content/uploads/2019/01/Motion-graphics-examples.gif' width='300px'><br><br>No bugs!!!<br><a href='https://www.wwf.org.uk/thingsyoucando'>Meanwhile, learn what you can do to save our dear mother earth!</a></p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>
    <div class="col s6" id="res_task">
    <p class="center">Resolved</p>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM bugs WHERE project=" . $_GET['id']. " AND stats='Resolved' ORDER BY id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            <div class="card-content waves-effect" onclick=\'bug('.json_encode($row['id']).', this)\'>
                <h5 style="margin:0;">'.$row['name'].'</h5>
                <p>Error: '.$row['error'].'</p>
            </div>
             <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-bug.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
        </div>';
    }
    }
    else {
        echo "<div class='no_results' id='__noResContainer'><p style='color:gray'>No resolved bugs</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>