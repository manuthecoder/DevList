<?php
session_start();
include('cred.php');
?>
<div class='row' style="padding:0 30px" id="bugLoader">
    <div class="col s6">
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
             <div class="card-action">
                <a href="#!" onclick="this.style.display=\'none\'; $(\'#__AJAX_LOADER\').load(\'resolve-bug.php?id='.$row['id'].'\');document.getElementById(\'res_task\').appendChild(this.parentElement.parentElement)"><i class="material-icons">check</i></a>
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-bug.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
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
    <div class="col s6" id="res_task">
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
             <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-bug.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
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
<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('bug_popup').style.display = 'block';document.getElementById('bug__popup').style.display = 'block';document.getElementById('bug_name').focus()">
    <i class="large material-icons">add</i>
</a>
<style>
    #bug_popup {position:fixed;top:0;left:0;transition: all .2s;width:100%;display:none;background: rgba(0,0,0,0.3);height:100%;z-index:99999999;animation: overlay .2s forwards}
    .popup {position:fixed;display:none;z-index:999999999;bottom:80px;right:20px;width:300px;background:var(--bg-color);padding: 15px;border-radius:5px;animation: _popup .2s forwards;transform-origin:bottom right;box-shadow:0 6px 7px -4px rgba(0,0,0,.2),0 11px 15px 1px rgba(0,0,0,.14),0 4px 20px 3px rgba(0,0,0,.12)!important}
    @keyframes overlay {0%{opacity:0;} 100% {opacity:1}}
    @keyframes _popup {0%{transform:scale(0);}}
</style>
<div id="bug_popup" onclick='this.style.display = "none";document.getElementById("bug__popup").style.display = "none"'></div>
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
</script>