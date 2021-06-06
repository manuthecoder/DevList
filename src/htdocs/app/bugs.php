<?php
session_start();
include('cred.php');
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
<div class='row' style="padding:0 30px" id="bugLoader">
    <div class="col s12 m6">
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
             '. ($perms !== "View Only" ? '<div class="card-action">
                <a href="#!" onclick="this.style.display=\'none\'; $(\'#__AJAX_LOADER\').load(\'resolve-bug.php?id='.$row['id'].'\');document.getElementById(\'res_task\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-bug.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>': ""). '
        </div>';
    }
    }
    else {
        echo "<div class='no_results' id='__noResBugContainer'><p style='color:gray'><img src='https://www.columnfivemedia.com/wp-content/uploads/2019/01/Motion-graphics-examples.gif' width='300px'><br><br>No bugs!!!<br><a href='https://www.wwf.org.uk/thingsyoucando'>Meanwhile, learn what you can do to save our dear mother earth!</a></p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
    </div>
    <div class="col s12 m6" id="res_task">
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
             '. ($perms !== "View Only" ? ' <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-bug.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>': ""). '
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
</div>

<!-- href="./add/task/?id=<?php echo $_GET['id']; ?>""   -->
<?php if($perms !== "View Only") {
    ?>
<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('bug_popup').style.display = 'block';document.getElementById('bug__popup').style.display = 'block';document.getElementById('bug_name').focus()">
    <i class="large material-icons">add</i>
</a>
<div id="bug_popup" class="overlay" onclick='this.style.display = "none";document.getElementById("bug__popup").style.display = "none"'></div>
    <div class="popup" id="bug__popup">
    <h4 style="margin:0;">Add</h4><br>
        <form action="./add/bug/index.php" method="POST" id="__bugForm">
          <div class="input-field">
            <label>Name</label>
            <input type="text" id="bug_name" name="name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Error Message/description</label>
            <textarea type="text" name="error" class="materialize-textarea" id="error" autocomplete="off"></textarea>
          </div>
          <input type="hidden" name="project" value="<?php echo $_GET['id'];?>">
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='bug__banner'>
                Successfully added task! You can keep adding more.
            </div>
            <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='bug_err__banner'>
                All fields are required
            </div>
          </form>
    </div>
<script>
var __id = <?php echo $_GET["id"];?>;
// this is the id of the form
$("#__bugForm").submit(function(e) {
    if(document.getElementById('bug_name').value == '' || document.getElementById('bug_name').value == null || document.getElementById('error').value == '' || document.getElementById('error').value == null ) {
        document.getElementById('bug__banner').style.display = 'none';
        document.getElementById('bug_err__banner').style.display = 'none';
        document.getElementById('bug_err__banner').style.display = 'block';
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
            $("#bugLoader").load("quick_bug.php?id="+__id);
            document.getElementById('__bugForm').reset();
            document.getElementById('__noResBugContainer').style.display = 'none';
            document.getElementById('bug_name').focus()
            document.getElementById('bug__banner').style.display = 'none';
            document.getElementById('bug_err__banner').style.display = 'none';
            document.getElementById('bug__banner').style.display = 'block'
           }
         });
});
window.onkeyup = null;
window.onkeyup = function(e) {
    if(e.keyCode == 191) {
        document.getElementById('bug_popup').style.display = 'block';document.getElementById('bug__popup').style.display = 'block';document.getElementById('bug_name').focus()
    }
}
</script>
<?php } ?>