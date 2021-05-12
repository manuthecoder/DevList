<!DOCTYPE html>
<html>
  <head>
    <title>Add a task | Devlist</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <style>* {font-family: 'Nunito', sans-serif !important;} .waves-ripple {transition-duration: .5s !important}</style>
  </head>
  <body>
    <form action="../../add.php" method="POST" class="container">
      <div class="container">
        <div class="container">
          <center><h3>Add a task</h3></center>
          <div class="input-field">
            <label>Name</label>
            <input type="text" name="name" autofocus autocomplete="off">
          </div>
          <div class="input-field">
            <label>Priority (1-5)</label>
            <input type="text" name="priority" autocomplete="off" value="3">
          </div>
          <div class="input-field">
            <label>Description</label>
            <textarea type="text" name="description" class="materialize-textarea" autocomplete="off"></textarea>
          </div>
          <input type="hidden" name="project" value="<?php echo $_GET['id']; ?>">
          <button class="blue-grey darken-3 btn waves-effect waves-light" style="height: 40px;line-height:40px;width:100%">Add</button>
          </form>
      </div>
      </div>
     <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/js/materialize.min.js"></script>
  </body>
</html>