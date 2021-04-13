<?php 
session_start();
include('cred.php');
?>
<div class="container">
<h5 id="greeting"></h5>
<div class="row">
    <div class='col s6'>
    <p>Recent Projects</p>
<?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM projects WHERE login=" . $_SESSION['id']. " LIMIT 10";
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '
      <div class="card" style="border-radius: 5px;box-shadow:none !important;border: 1px solid rgba(200,200,200,.3)">
        <div class="card-content waves-effect" onclick="AJAX_LOAD(\'todo.php?id='.$row['id'].'\')">
        <span class="card-title"><i class="material-icons left">'.$row['icon'].'</i>'.$row['name'].'</span>
        </div>
      </div>
      ';
        }
        $dbh = null;
        }
        catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
    ?> 
    </div>

    <div class='col s6'>
    <p>Recent Tasks</p>
<?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM todo WHERE login=" . $_SESSION['id']. " ORDER BY RAND() LIMIT 10";
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '
      <div class="card" style="border-radius: 5px;box-shadow:none !important;border: 1px solid rgba(200,200,200,.3)">
        <div class="card-content waves-effect" onclick="AJAX_LOAD(\'todo.php?id='.$row['id'].'\')">
        <p><b>'.$row['name'].'</b></p>
        <p style="width:100%;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">'.$row['description'].'</p>
        </div>
      </div>
      ';
        }
        $dbh = null;
        }
        catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
    ?> 
    </div>
    </div>
</div>

<script>
var today = new Date()
var curHr = today.getHours()

if (curHr >= 0 && curHr < 6) {
    document.getElementById("greeting").innerHTML = '👋 What are you doing that early?';
} else if (curHr >= 6 && curHr < 11) {
    document.getElementById("greeting").innerHTML = '👋 Good Morning! Today\'s going to be a great day!';
} else if (curHr >= 11 && curHr < 17) {
    document.getElementById("greeting").innerHTML = '👋 Good Afternoon! Hope your day\'s been going well! ';
} else {
    document.getElementById("greeting").innerHTML = '👋 Good Evening! Hope your day went well!';
}
</script>