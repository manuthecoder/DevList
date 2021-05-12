<?php 
session_start();
include('cred.php');
?>
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM links WHERE project=" . $_GET['id']. " ORDER BY id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            '.($row['img'] == 'true' ? '<img src="'.$row['content'].'" width="100%" class="materialboxed"><div class="card-content"><br><span class="center card-title"><a target="_blank" href="'.$row['content'].'">'.$row['content'].'</a></span>' : '<div class="card-content"><a target="_blank" href="'.$row['content'].'"><span class="card-title">'.$row['content'].'</span></a>').'
            </div>
            <div class="card-action">
            <a href="#" onclick="this.parentElement.parentElement.style.display=\'none\';$(\'#__AJAX_LOADER\').load(\'delete-link.php?id='.$row['id'].'\');"><i class="material-icons">delete</i></a>
            </div>
        </div>';
    }
    }
    else {
        echo "<div class='no_results'><p style='color:gray'>No links. Keep \"to-read-later\" blog posts, images, and links here!</a></p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 