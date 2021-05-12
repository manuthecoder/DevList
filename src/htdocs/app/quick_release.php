<?php
session_start();
include('cred.php');
?>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM releases WHERE project=" . $_GET['id']. " ORDER BY id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            <div class="card-content waves-effect" onclick=\'bug('.json_encode($row['id']).', this)\'>
                <h5 style="margin:0;"><b>'.$row['name'].'</b></h5>
                <p>'.$row['description'].'</p><br>
                <div>
                    <div class="chip">Version: '.$row['version'].'</div>
                    <div class="chip">Date released: '.$row['date'].'</div>
                    <div class="chip">Release ID: '.$row['id'].'</div>
                </div>
            </div>
             <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-release.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
        </div>';
    }
    }
    else {
        echo "<div class='no_results' id='release_container'><p style='color:gray'><img src='https://media.discordapp.net/attachments/805940199922204682/833149339647475712/thonk.png' width='300px'><br>No releases? :(</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 