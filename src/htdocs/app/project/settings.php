<?php
session_start();
include('../cred.php');
?>


<div class='container'>
<?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM projects WHERE id=" . $_GET['id'];
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '<center><h1 style="width:auto;margin-bottom:0;"><b><form action="./project/edit-title.php" method="POST" id="edit_title_project_form"><input style="text-align:center;transition: all .2s;cursor:pointer;margin:0;border:0;font-size: 80px;height: auto;padding:3px;" onfocus="document.getElementById(\'edit_title_span\').innerHTML = \'Hit enter to save\'" onblur="document.getElementById(\'edit_title_span\').innerHTML = \'Click to edit\'" value="'.$row['name'].'" name="name" id="edit_title_project_form_value" autocomplete="off"><input type="hidden" value="'.$_GET['id'].'" name="id"></b></form></h1><span style="font-size: 13px;color:gray" id="edit_title_span">Click to edit</span>';
            echo '
            <div class="container">
                <form action="https://devlist.rf.gd/app/project/edit-desc.php" method="POST" id="editDescForm">
                    <textarea style="border:0;outline:0;height:auto" class="materialize-textarea" id="txt" name="desc" onfocus="document.getElementById(\'_descBtn\').style.display=\'block\'">'.$row['description'].'</textarea>
                    <input type="hidden" value="'.$_GET['id'].'" name="id">
                    <button id="_descBtn" style="display:none" type="submit" class="btn blue-grey darken-3 waves-effect waves-light">Save</button><br>
                </form>
            </div>';
            echo "<div class='chip'>".$row['type']."</div>";
            echo "<div class='chip'>ID: ".$row['id']."</div>";
            echo "<div class='chip'>Icon: ".$row['icon']."</div>";
            echo "<div class='chip'>Login ID: ".$row['login']."</div></center>";
            echo '<div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id="title_banner">
                Successfully changed title. You may have to reload the page to see the results
            </div><div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id="desc_banner">
                Successfully changed description. You may have to reload the page to see the results
            </div><div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id="title_err_banner">
                All fields are required
            </div><div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id="desc_err_banner">
                All fields are required
            </div><br><br><div class="container"><div class="container"><button class="btn purple darken-3 waves-effect" onclick="AJAX_LOAD(\'./project/invite-project.php?id='.$_GET['id'].'\')">Invite People</button></div></div><br><div class="container"><div class="container" style="border: 1px solid red;padding: 10px;border-radius: 5px"><h5 style="margin-bottom:0;">Danger zone</h5><br><button class="btn red darken-3 waves-effect" onclick="AJAX_LOAD(\'./project/delete-project.php?id='.$_GET['id'].'\')">Delete project</button></div></div>';
        }
        $dbh = null;
        }
        catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
    ?> 
</div>
<script>
$("#edit_title_project_form").submit(function(e) {
    if (document.getElementById('edit_title_project_form_value').value == '' || document.getElementById('edit_title_project_form_value').value == null) {
        document.getElementById('title_banner').style.display = 'none';
        document.getElementById('title_err_banner').style.display = 'block'
        return false;
    }
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data) {
            document.getElementById('title_banner').style.display = 'block';
            document.getElementById('title_err_banner').style.display = 'none'
        }
    });
});
$("#editDescForm").submit(function(e) {
    if (document.getElementById('txt').value == '' || document.getElementById('txt').value == null) {
        document.getElementById('desc_banner').style.display = 'none';
        document.getElementById('desc_err_banner').style.display = 'block'
        return false;
    }
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        success: function(data) {
            AJAX_LOAD('./project/settings.php?id=<?php echo $_GET['id']; ?>');
        }
    });
});
</script>