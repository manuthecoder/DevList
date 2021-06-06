<?php 
session_start();
?>
<form method="POST" action="./project/invite.php" id="form_invite">
    <div class="container">
    <div class="container"><button onclick="AJAX_LOAD('./project/invite-project.php?id=<?php echo $_GET['id']; ?>')" class="btn right red darken-3" type="button">Refresh</button></div><br><br>
        <div class="input-field col s12 container">
        <input disabled id="url" type="text" value="Fill out permissions to create link">
        </div>
        <input name="id" value="<?php echo $_GET['id']; ?>" type="hidden">
        <div class="input-field col s12 container">
            <select name="perms">
                <option value="" disabled selected>Permissions</option>
                <option value="Admin">Admin</option>
                <option value="View Only">View Only</option>
                <!--<option value="Write Only">Write Only</option>-->
            </select>
            <br>
            <br>
            <button type="submit" class="btn blue-grey darken-1">Create</button>
        </div>
    </div>
</form>
<script>
var id = <?php echo $_GET['id']; ?>;
$('select').formSelect();
// this is the id of the form
$("#form_invite").submit(function(e) {
    e.preventDefault(); // avoid to execute the actual submit of the form.
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
           type: "POST",
           url: url,
           data: form.serialize(), // serializes the form's elements.
           success: function(data)
           {
               document.getElementById('url').value = "https://devlist.rf.gd/invite/" + data
           }
         });
});
</script>