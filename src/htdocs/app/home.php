<?php 
session_start();
include('cred.php');
?>
<script>
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    selectable: true,
    eventBackgroundColor: 'transparent',
    eventDisplay: 'block',
    eventBorderColor: 'black',
    nowIndicator: true,
    buttonText: {
    today:    'Today',
    month:    'Month view',
    week:     'Week View',
    day:      'day',
    list:     'List View',
    },
    displayEventTime: false,
allDaySlot: false,
headerToolbar: {
  start: 'title', // will normally be on the left. if RTL, will be on the right
  center: '',
  end: 'listWeek,dayGridMonth,dayGridWeek today prev,next' // will normally be on the right. if RTL, will be on the left
},
    eventTextColor: 'var(--font-color)',
    events: [
        // { title: 'The Title', start: '2020-09-01', end: '2018-09-02' },
        <?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM calendar WHERE login=" . $_SESSION['id'];
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '{title: '.json_encode($row['title']).', start: '.json_encode($row['startdate']).',allDay: true, end: '.json_encode($row['enddate']).', id: '.json_encode($row['id']).'},';
        }
        $dbh = null;
        }
        catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
        ?> 
    ],
    eventClick: function(info) {
        calendarModal(info.event.title, info.event.start, info.event.end, info.event.id);
    }
});
calendar.render();
</script>
<a class="btn-floating btn-large blue-grey darken-1" style="position:fixed;bottom:20px;right:20px;transform:none !important" onclick="document.getElementById('__calendarPopup').style.display = 'block';document.getElementById('calendarPopup').style.display = 'block';$('input').focus();$('#calendarName').focus()">
<i class="large material-icons">insert_invitation</i>
</a>
<style>#calendar a {color:var(--font-color)}</style>
<div class="container">
<h5 id="greeting"></h5>
<div class="row">
    <div class='col s12 m6'>
    <p>Recent Projects</p>
<?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM projects WHERE login=" . $_SESSION['id']. " ORDER BY RAND() LIMIT 10";
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '
      <div class="card" style="border-radius: 5px;box-shadow:none !important;border: 1px solid rgba(200,200,200,.3)">
        <div class="card-content waves-effect" onclick="history.pushState(null, null, \'https://devlist.rf.gd/app/#/'.str_replace(' ', '-', strtolower($row['name'])).'\');AJAX_LOAD(\'todo.php?id='.$row['id'].'\')">
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

    <div class='col s12 m6'>
    <p>Recent Tasks</p>
<?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM todo WHERE login=" . $_SESSION['id']. " ORDER BY RAND() LIMIT 20";
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '
      <div class="card" style="border-radius: 5px;box-shadow:none !important;border: 1px solid rgba(200,200,200,.3)">
        <div class="card-content waves-effect" onclick="AJAX_LOAD(\'todo.php?id='.$row['project'].'\')">
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
    <div id='calendar'></div>
</div>
<script>
var today = new Date()
var curHr = today.getHours()
if (curHr >= 0 && curHr < 3) {
    document.getElementById("greeting").innerHTML = '👋 What are you doing that early?';
} else if (curHr >= 3 && curHr < 11) {
    document.getElementById("greeting").innerHTML = '👋 Good Morning! Today\'s going to be a great day!';
} else if (curHr >= 11 && curHr < 17) {
    document.getElementById("greeting").innerHTML = '👋 Good Afternoon! Hope your day\'s been going well! ';
} else {
    document.getElementById("greeting").innerHTML = '👋 Good Evening! Hope your day went well!';
}
</script>


<div id="__calendarPopup" class="overlay" onclick='this.style.display = "none";document.getElementById("calendarPopup").style.display = "none"'></div>
    <div class="popup" id="calendarPopup">
    <h5 style="margin:0;">Add event</h5><br>
        <form action="./add/calendar/index.php" method="POST" id="__calendarForm">
          <div class="input-field">
            <label>Name</label>
            <input type="text" id="calendarName" name="name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Start date</label>
            <input name="startdate" type="text" class="datepicker" id="i1" value="<?php echo date('Y-m-d');?>">
          </div>
          <div class="input-field">
            <label>End date</label>
            <input name="enddate" type="text" class="datepicker" id="i2" value="<?php echo date('Y-m-d');?>">
          </div>
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='__calendarSuccess'>
                Successfully added task! You can keep adding more.
            </div>
            <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='__calendarErr'>
                All fields are required
            </div>
          </form>
    </div>
<script>
// this is the id of the form
$("#__calendarForm").submit(function(e) {
    if(document.getElementById('calendarName').value == '' || document.getElementById('calendarName').value == null || document.getElementById('i1').value == '' || document.getElementById('i1').value == null || document.getElementById('i2').value == '' || document.getElementById('i2').value == null ) {
        document.getElementById('__calendarSuccess').style.display = 'none';
        document.getElementById('__calendarErr').style.display = 'none';
        document.getElementById('__calendarErr').style.display = 'block';
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
            AJAX_LOAD('home.php?scroll_to_bottom');
           }
         });
});
window.onkeyup = null;
window.onkeyup = function(e) {
    if(e.keyCode == 191) {
        document.getElementById('__calendarPopup').style.display = 'block';document.getElementById('calendarPopup').style.display = 'block';document.getElementById('calendarName').focus()
    }
}
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
});

<?php if(isset($_GET['scroll_to_bottom'])) {
    echo 'document.getElementById("calendar").scrollIntoView()';
}?>
</script>