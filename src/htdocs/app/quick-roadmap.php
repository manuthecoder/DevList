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
    echo "        ['aaaaaaaaaaa".$row['id']."', ".json_encode($row['name']).", random(), new Date(".$row['startDate']."), new Date(".$row['endDate']."), null, ".$row['percent'].", null],";
    }
$dbh = null;
}
catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
      ]);

      var options = {
        height: 500,
        gantt: {
          trackHeight: 40
        }
      };

      var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

      chart.draw(data, options);
    }
  </script>
  <div id="chart_div"></div>
  <table><thead><tr><td>Title</td><td>Start</td><td>End</td><td>Percent complete</td><td>Actions</td></tr></thead>
  <?php
try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM roadmap WHERE project=".$_GET['id']." ORDER by id ASC";
    $users = $dbh->query($sql);
    foreach ($users as $row){
    echo "<tr><td>".$row['name']."</td><td>".$row['startDate']."</td><td>".$row['endDate']."</td><td>".$row['percent']."</td><td><a onclick='$(\"#__AJAX_LOADER\").load(\"delete-roadmap.php?id=".$row['id']."&project=".$_GET['id']."\")' href='#!'><i class='material-icons'>delete</i></a></td></tr>";
    }
$dbh = null;
}
catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
</table>