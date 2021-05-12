<?php 
session_start();
include('cred.php');
?>
<div id="changeLog">
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
                    echo "<div class='no_results'><img src='https://media.tenor.com/images/1de74e808439965324e3263f94e5ac95/tenor.gif' width='300px'><br><p style='color:gray'>No changes?!?!?</p></div>";
                }
                $dbh = null;
                }
                catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
                ?> 
        </div>
    </div>
</div>


<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('changelog_popup').style.display = 'block';document.getElementById('changelog__popup').style.display = 'block';document.getElementById('changelog_name').focus()">
    <i class="large material-icons">add</i>
</a>
<style>
    #changelog_popup {position:fixed;top:0;left:0;transition: all .2s;width:100%;display:none;background: rgba(0,0,0,0.3);height:100%;z-index:99999999;animation: overlay .2s forwards}
    @keyframes overlay {0%{opacity:0;} 100% {opacity:1}}
</style>
<div id="changelog_popup" class="overlay" onclick='this.style.display = "none";document.getElementById("changelog__popup").style.display = "none"'></div>
    <div class="popup" id="changelog__popup">
    <h4 style="margin:0;">Add</h4><br>
        <form action="./add/changelog/index.php" method="POST" id="__changelogForm">
          <div class="input-field">
            <label>Name</label>
            <input type="text" id="changelog_name" name="changelog_name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Description</label>
            <textarea type="text" name="changelog_desc" class="materialize-textarea" id="changelog_desc" autocomplete="off"></textarea>
          </div>
          <div class="input-field">
            <label>Date</label>
            <input type="text" name="changelog_date" class="datepicker" id="changelog_date" autocomplete="off">
          </div>
          <div>
            <label>
                <input type="checkbox" name="milestone" value="true">
                <span>Milestone?</span>
            </label>
          </div><br>
          <input type="hidden" name="project" value="<?php echo $_GET['id'];?>">
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='__changelogBanner'>
                Successfully added task! You can keep adding more.
            </div>
            <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='__changelogErrorBanner'>
                All fields are required
            </div>
          </form>
    </div>
<script>
var __id = <?php echo $_GET["id"];?>;
// this is the id of the form
$("#__changelogForm").submit(function(e) {
    if(document.getElementById('changelog_name').value == '' || document.getElementById('changelog_name').value == null || document.getElementById('changelog_date').value == '' || document.getElementById('changelog_date').value == null || document.getElementById('changelog_desc').value == '' || document.getElementById('changelog_desc').value == null ) {
        document.getElementById('__changelogBanner').style.display = 'none';
        document.getElementById('__changelogErrorBanner').style.display = 'none';
        document.getElementById('__changelogErrorBanner').style.display = 'block';
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
            $("#changeLog").load("quick_changelog.php?id="+__id);
            document.getElementById('__changelogForm').reset();
            document.getElementById('changelog_name').focus()
            document.getElementById('__changelogBanner').style.display = 'none';
            document.getElementById('__changelogErrorBanner').style.display = 'none';
            document.getElementById('__changelogBanner').style.display = 'block'
           }
         });
});
$('.datepicker').datepicker();
window.onkeyup = null;
window.onkeyup = function(e) {
    if(e.keyCode == 191) {
        document.getElementById('changelog_popup').style.display = 'block';document.getElementById('changelog__popup').style.display = 'block';document.getElementById('changelog_name').focus()
    }
}
</script>