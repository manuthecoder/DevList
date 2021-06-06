<?php
session_start();
include('cred.php');
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
<div class="container" id="release_loader">
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM releases WHERE project=" . $_GET['id']. " ORDER BY id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            <div class="card-content waves-effect" onclick=\'bug('.json_encode($row['id']).', this)\'>
                <h5 style="margin:0;"><b>'.$row['name'].'</b></h5>
                <p>'.$row['description'].'</p><br>
                <div>
                    <div class="chip">Version: '.$row['version'].'</div>
                    <div class="chip">Date released: '.$row['date'].'</div>
                    <div class="chip">Release ID: '.$row['id'].'</div>
                </div>
            </div>
            '. ($perms !== "View Only" ? '
             <div class="card-action">
                <a href="#!" onclick="$(\'#__AJAX_LOADER\').load(\'delete-release.php?id='.$row['id'].'\');this.parentElement.parentElement.style.display=\'none\'"><i class="material-icons">delete</i></a>
            </div>
            ': ""). '
        </div>';
    }
    }
    else {
        echo "<div class='no_results' id='release_container'><p style='color:gray'><img src='https://media.discordapp.net/attachments/805940199922204682/833149339647475712/thonk.png' width='300px'><br>No releases? :(</p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
</div>


<?php if($perms !== "View Only") {
    ?>

<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('release_popup_bg').style.display = 'block';document.getElementById('release_popup').style.display = 'block';document.getElementById('release_name').focus()">
    <i class="large material-icons">add</i>
</a>
<div class="overlay" id="release_popup_bg" onclick='this.style.display = "none";document.getElementById("release_popup").style.display = "none"'></div>
    <div class="popup" id="release_popup">
    <h4 style="margin:0;">Add</h4><br>
        <form action="./add/release/index.php" method="POST" id="release_form">
          <div class="input-field">
            <label>Name</label>
            <input type="text" id="release_name" name="name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Description</label>
            <textarea type="text" name="description" class="materialize-textarea" id="release_description" autocomplete="off"></textarea>
          </div>
          <div class="input-field">
            <label>Version</label>
            <input type="text" id="release_version" name="version" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Date</label>
            <input type="text" id="release_date" name="date" class="datepicker" autofocus autocomplete="off">
          </div>
          <input type="hidden" name="project" value="<?php echo $_GET['id'];?>">
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='release__banner'>
                Successfully added release! You can keep adding more.
            </div>
            <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='release_err_banner'>
                All fields are required
            </div>
          </form>
    </div>
<script>
$('.datepicker').datepicker();
var __id = <?php echo $_GET["id"];?>;
// this is the id of the form
$("#release_form").submit(function(e) {
    if(document.getElementById('release_name').value == '' || document.getElementById('release_name').value == null || document.getElementById('release_description').value == '' || document.getElementById('release_description').value == null || document.getElementById('release_date').value == '' || document.getElementById('release_date').value == null || document.getElementById('release_version').value == '' || document.getElementById('release_version').value == null) {
        document.getElementById('release__banner').style.display = 'none';
        document.getElementById('release_err_banner').style.display = 'none';
        document.getElementById('release_err_banner').style.display = 'block';
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
        $("#release_loader").load("quick_release.php?id="+__id);
        document.getElementById('release_form').reset();
        if(document.getElementById('release_container')) {document.getElementById('release_container').style.display = 'none';}
        document.getElementById('release_name').focus()
        document.getElementById('release__banner').style.display = 'none';
        document.getElementById('release_err_banner').style.display = 'none';
        document.getElementById('release__banner').style.display = 'block'
        }
    });
});
</script>
<?php } ?>