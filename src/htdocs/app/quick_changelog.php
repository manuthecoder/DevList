<?php 
session_start();
include('cred.php');
?>
<div class="container">
    <div class="changelog">
    <?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM changelog WHERE project=" . $_GET['id']. " ORDER by id DESC";
        $users = $dbh->query($sql);
        $row_count = $users->rowCount();
        if($row_count !== 0) {
        foreach ($users as $row){
            echo '<div onclick="change(this, '.$row['id'].', '.$_GET['project'].')" id="change'.$row['id'].'" class="time'.($row['milestone'] == 'true' ? ' milestone' : '').'"><h6><b>'.htmlspecialchars($row['name']).'</b></h6><p>'.htmlspecialchars($row['description']).'</p></div>';
            }
            }
            else {
                echo "<div class='no_results'><p style='color:gray'><img src='https://media.tenor.com/images/1de74e808439965324e3263f94e5ac95/tenor.gif' width='300px'><br>No changes?!?!?</p></div>";
            }
            $dbh = null;
            }
            catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
            ?> 
    </div>
</div>