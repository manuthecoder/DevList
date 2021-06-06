<?php
session_start();
include('./app/cred.php');
?>
<?php
try {
  $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $sql = "SELECT * FROM invites WHERE code=" . json_encode($_GET['id']);
  $users = $dbh->query($sql);
  $row_count = $users->rowCount();
  
  if($row_count !== 0) {
    foreach ($users as $row) { 
      $dbh1 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $sql1 = "SELECT * FROM `projects` WHERE id=" . json_encode($row['project']);
      $users1 = $dbh1->query($sql1);
      $row_count = $users1->rowCount();
      foreach ($users1 as $row1) {
        // echo $row1['name'];
      }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Join Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.1.0-alpha/dist/css/materialize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body style="background: #f5f5f5">
    <div class="container">
      <div class="container">
        <div class="container">
          <div class="center z-depth-2" style="padding: 20px;border-radius: 5px;margin-top: 40px;background: white;border-top: 5px solid #388e3c">
            <b><h3>Join project</h4></b>
            <p>You have been granted <?php echo  $row['permissions']; ?> access to <?php echo $row1['name'];?> via Devlist. </p>
            <p><i><?php echo $row1['description']; ?></i></p>
            <button class="btn blue-grey darken-3" onclick="$('#div1').load('../../join.php?id=<?php echo $row['project']; ?>&p=<?php echo $row['permissions']; ?>&icon=<?php echo urlencode($row1['icon']);?>&name=<?php echo urlencode($row1['name']);?>')">Join</button>
          </div>
        </div>
      </div>
    </div>
    <div id="div1"></div>
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.1.0-alpha/dist/js/materialize.min.js"></script>
  </body>
</html>
<?php
    }
  }
  else {
    $t = 1;
  }
  $dbh = null;
}
catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
if($t == 1){
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Invalid Link</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.1.0-alpha/dist/css/materialize.min.css">
  </head>
  <body>
    <div class="container">
      <div class="container">
        <div class="container">
          <div class="center z-depth-2" style="padding: 20px;border-radius: 5px;margin-top: 40px;border-top: 5px solid #d32f2f">
            <h3>404</h4>
            <p>Invalid Link</p>
            <p>Hmmm... This code doesn't exsist in our database. Try generating a new one</p>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.1.0-alpha/dist/js/materialize.min.js"></script>
  </body>
</html>
<?php } ?>