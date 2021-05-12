<?php 
session_start();
include('cred.php');
?>
<div class="container" id="linkLoader">
<?php
    try {
    $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $sql = "SELECT * FROM links WHERE project=" . $_GET['id']. " ORDER BY id DESC";
    $users = $dbh->query($sql);
    $row_count = $users->rowCount();
    if($row_count !== 0) {
    foreach ($users as $row){
        echo '
        <div class="card">
            '.($row['img'] == 'true' ? '<img src="'.$row['content'].'" width="100%" class="materialboxed"><div class="card-content"><br><span class="center card-title"><a target="_blank" href="'.$row['content'].'">'.$row['content'].'</a></span>' : '<div class="card-content"><a target="_blank" href="'.$row['content'].'"><span class="card-title">'.$row['content'].'</span></a>').'
            </div>
            <div class="card-action">
            <a href="#" onclick="this.parentElement.parentElement.style.display=\'none\';$(\'#__AJAX_LOADER\').load(\'delete-link.php?id='.$row['id'].'\');"><i class="material-icons">delete</i></a>
            </div>
        </div>';
    }
    }
    else {
        echo "<div class='no_results'><p style='color:gray'>No links. Keep \"to-read-later\" blog posts, images, and links here!</a></p></div>";
    }
    $dbh = null;
    }
    catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
?> 
</div>
<a class="btn-floating btn-large blue-grey darken-3" style="position:fixed;bottom:20px;right:20px;z-index:2" onclick="document.getElementById('link_popup').style.display = 'block';document.getElementById('__linkPopup').style.display = 'block';document.getElementById('__linkPopupFormName').focus();document.getElementById('__linkPopupFormBanner').style.display = 'none'; document.getElementById('err__linkPopupFormBanner').style.display = 'none';">
    <i class="large material-icons">add</i>
</a>

<div id="link_popup" class="overlay" onclick='this.style.display = "none";document.getElementById("__linkPopup").style.display = "none"'></div>
    <div class="popup" id="__linkPopup">
    <h4 style="margin:0;">Add</h4><br>
        <form action="./add/links/index.php" method="POST" id="__linkPopupForm">
          <div class="input-field">
            <label>Link</label>
            <input type="text" id="__linkPopupFormName" name="content" autofocus autocomplete="off">
          </div>
          <div>
            <label>
                <input type="checkbox" name="image">
                <span>Image?</span>
            </label>
          </div><br>
          <input type="hidden" name="project" value="<?php echo $_GET['id'];?>">
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='__linkPopupFormBanner'>
                Successfully added link! You can keep adding more.
            </div>
            <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='err__linkPopupFormBanner'>
                All fields are required
            </div>
          </form>
    </div>
<script>
var __id = <?php echo $_GET["id"];?>;
$("#__linkPopupForm").submit(function(e) {
    if(document.getElementById('__linkPopupFormName').value == '' || document.getElementById('__linkPopupFormName').value == null) {
        document.getElementById('__linkPopupFormBanner').style.display = 'none';
        document.getElementById('err__linkPopupFormBanner').style.display = 'none';
        document.getElementById('err__linkPopupFormBanner').style.display = 'block';
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
            $("#linkLoader").load("quick_links.php?id="+__id);
            document.getElementById('__linkPopupForm').reset();
            document.getElementById('__linkPopupFormName').focus()
            document.getElementById('__linkPopupFormBanner').style.display = 'none';
            document.getElementById('err__linkPopupFormBanner').style.display = 'none';
            document.getElementById('__linkPopupFormBanner').style.display = 'block'
           }
         });
});
$('.materialboxed').materialbox();
window.onkeyup = null;
window.onkeyup = function(e) {
    if(e.keyCode == 191) {
        document.getElementById('link_popup').style.display = 'block';document.getElementById('__linkPopup').style.display = 'block';document.getElementById('__linkPopupFormName').focus();document.getElementById('__linkPopupFormBanner').style.display = 'none'; document.getElementById('err__linkPopupFormBanner').style.display = 'none';
    }
}
</script>