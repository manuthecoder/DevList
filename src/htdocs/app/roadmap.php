<?php session_start(); include('cred.php');
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $nRows = $dbh->query('select count(*) from roadmap')->fetchColumn(); 
    $height = ($nRows*30) + 100;
    $dbh = null;
}
catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
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
<div class="container" id="changeLog">
<h4>Roadmap</h4><br>
  <script type="text/javascript">
  var rand = [' ', '  ', '   ', '    ', '     '];
  function random() {
      return rand[Math.floor(Math.random() * rand.length)];
  }
    google.charts.load('current', {'packages':['gantt']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
    
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Task ID');
      data.addColumn('string', 'Task Name');
      data.addColumn('string', 'Resource');
      data.addColumn('date', 'Start Date');
      data.addColumn('date', 'End Date');
      data.addColumn('number', 'Duration');
      data.addColumn('number', 'Percent Complete');
      data.addColumn('string', 'Dependencies');
      data.addRows([
<?php
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM roadmap WHERE project=".$_GET['id']." ORDER by id ASC";
    $users = $dbh->query($sql);
    foreach ($users as $row){
    echo "        ['id".$row['id']."', ".json_encode($row['name']).", random(), new Date('".$row['startDate']."'), new Date('".$row['endDate']."'), null, ".$row['percent'].", null],\n";
    }
$dbh = null;
}
catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
      ]);

      var options = {
        height: <?php echo $height;?>,
        gantt: {
          trackHeight: 40,
        },
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'select', function () {
        selection = chart.getSelection();
            if (selection.length > 0) {
                var id = (data.getValue(selection[0].row, 0)).replace('id', '');
                var name = data.getValue(selection[0].row, 1);
                var d1 = data.getValue(selection[0].row, 3);
                var d2 = data.getValue(selection[0].row, 4);
                var percent = data.getValue(selection[0].row, 6);
                <?php if($perms !== "View Only") { ?> roadmap(id, name, percent, d1, d2, <?php echo $_GET['id'];?>);<?php } ?>
            }
        });
      chart.draw(data, options);
    }
  </script>
  <div id="chart_div"></div>
</div>
<?php if($perms !== "View Only") { ?>
<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('add_popup').style.display = 'block';document.getElementById('__popup').style.display = 'block';document.getElementsByTagName('form')[0].reset();document.getElementById('name').focus()">
    <i class="large material-icons">add</i>
</a>
<style>
    @keyframes overlay {0%{opacity:0;} 100% {opacity:1}}
    @keyframes _popup {0%{transform:scale(0);}}
</style>
<div id="add_popup" class="overlay" onclick='this.style.display = "none";document.getElementById("__popup").style.display = "none"'></div>
    <div class="popup" id="__popup">
    <h4 style="margin:0;">Add</h4><br>
        <form action="./add/roadmap/index.php" method="POST" id="__addForm">
          <div class="input-field">
            <label>Name</label>
            <input type="text" id="name" name="name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Start Date</label>
            <input id="start" type="text" name="start" autocomplete="off" class="datepicker">
          </div>
          <div class="input-field">
            <label>End Date</label>
            <input id="end" type="text" name="end" autocomplete="off" class="datepicker">
          </div>
          <div class="input-field">
            <label>Percent</label>
            <input id="percent" type="number" name="percent" autocomplete="off">
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
$("#__addForm").submit(function(e) {
    if(document.getElementById('name').value == '' || document.getElementById('name').value == null || document.getElementById('start').value == '' || document.getElementById('start').value == null || document.getElementById('end').value == '' || document.getElementById('end').value == null || document.getElementById('percent').value == '' || document.getElementById('percent').value == null) {
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
            AJAX_LOAD("roadmap.php?id="+__id);
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
document.getElementById('add_popup').style.display = 'block';document.getElementById('__popup').style.display = 'block';document.getElementsByTagName('form')[0].reset();document.getElementById('name').focus()
    }
}
$('.datepicker').datepicker({
    format: 'mm/dd/yyyy'
});
</script>
<?php } ?>