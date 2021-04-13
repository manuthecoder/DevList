<?php 
session_start();
include('cred.php');
if(!isset($_SESSION['valid'])) {
    header('Location: ./login/');
    exit();
}?>
<!DOCTYPE html>
<html>
  <head>
    <title>Devlist</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./resources/interface.css">
    <link rel="shortcut icon" href="https://images.vexels.com/media/users/3/137617/isolated/preview/c45afb857e72b86e87baaf255f71ff37-geometric-logo-abstract-by-vexels.png">
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="#slide-out" class="sidenav-trigger" style="margin:0" data-target="slide-out"><i class="material-icons left show-on-small-only">menu</i>Devlist</a></li>
      </ul>
      <ul class="right">
        <li><a href="#!" class="waves-effect" style="border-radius:999px;margin-right: 10px" onclick="switchTheme()"><i class="material-icons" style="position:relative;top:-5px">dark_mode</i></a></li>
      </ul>
    </nav>
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li><div class="user-view">
        <div class="background">
          <img src="https://cdn.hipwallpaper.com/i/81/9/dMNIzV.jpg">
        </div>
        <a href="#user"><img class="circle" src="<?php echo $_SESSION['avatar'];?>"></a>
        <a href="#name"><span class="white-text name"><?php echo $_SESSION['username']; ?></span></a>
        <a href="#email"><span class="white-text email"><?php echo $_SESSION['email']; ?></span></a>
        </div></li>
      <li><a href="#!" class="waves-effect" onclick="AJAX_LOAD('home.php')"><i class="material-icons">home</i>Home</a></li>
      <li><div class="divider"></div></li>
      <li><a class="subheader">Projects</a></li>
      <?php
        try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM projects WHERE login=" . $_SESSION['id'];
        $users = $dbh->query($sql);
        foreach ($users as $row){
            echo '<li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                    <li>
                        <a class="collapsible-header waves-effect" style="padding-left: 35px">'.$row['name'].'<i class="material-icons">'.$row['icon'].'</i></a>
                        <div class="collapsible-body" style="background: rgba(255,255,255,.1)">
                        <ul>
                            <li class="links"><a class="waves-effect" style="margin-left: 35px" onclick="AJAX_LOAD(\'todo.php?id='.$row['id'].'\')"><i class="material-icons">task_alt</i>Todo</a></li>
                            <li class="links"><a class="waves-effect" style="margin-left: 35px" onclick="AJAX_LOAD(\'bugs.php?id='.$row['id'].'\')"><i class="material-icons">bug_report</i>Bugs</a></li>
                            <li class="links"><a class="waves-effect" style="margin-left: 35px" onclick="AJAX_LOAD(\'./project/settings.php?id='.$row['id'].'\')"><i class="material-icons">settings</i>Settings</a></li>
                        </ul>
                        </div>
                    </li>
                    </ul>
                </li>
      '; } $dbh = null; }
        catch(PDOexception $e) { echo "Error is: " . $e->etmessage(); }
    ?> 
    <li class="links"><a class="waves-effect" href="./add/project/"><i class="material-icons">add</i>Create project</a></li>
    <li><div class="divider"></div></li>
    <li><a class="subheader">Other</a></li>
    <li class="links"><a class="waves-effect" onclick="AJAX_LOAD('lofi.php')"><i class="material-icons">music_note</i>Focus music</a></li>
    <li class="links"><a class="waves-effect modal-trigger" href="#feedback_modal"><i class="material-icons">feedback</i>Feedback</a></li>
    <li class="links"><a class="waves-effect" href="https://manuthecoder.ml/"><i class="material-icons">more_horiz</i>More apps</a></li>
    <li class="links"><a class="waves-effect" onclick="AJAX_LOAD('logout.php')"><i class="material-icons">logout</i>Logout</a></li>
     <li><div class="divider"></div></li>
    <li><a class="subheader">Profile</a></li>
    <li class="links"><a class="waves-effect" onclick="AJAX_LOAD('./user/settings.php')"><i class="material-icons">settings</i>Settings</a></li>
    <li class="links"><a class="waves-effect" onclick="AJAX_LOAD('logout.php')"><i class="material-icons">logout</i>Logout</a></li>
    </ul>
    <div class="main">
        <div id="__ajaxLoader"></div>
        <div id='__AJAX_LOADER'></div>
    </div>
    <div id="avatar_modal" class="modal bottom-sheet">
        <div class="modal-content">
            <form action="./user/avatar.php" method="POST" id="__avatarForm">
                <center><a class='modal-trigger' onclick="$('#avatar_modal').modal('open')" href='#avatar_modal'><div class="waves-effect hover-zoom" style="border-radius:999px;width:100px;height:100px"><img id="__avatarImg" src="<?php echo $_SESSION['avatar'];?>" height="100px" width="100px" style="border-radius:999px;"></div></a></center>
                <div class="input-field">
                    <label>Avatar URL</label>
                    <input type="url" name="avatar" autocomplete='off' onkeyup="document.getElementById('__avatarImg').src=this.value" id='avatar_url'>
                </div>
                <button class="btn blue-grey darken-3 waves-effect waves-light" id="_avatarBtn" style="line-height:40px;height: 40px" onclick="setTimeout(function(){this.disabled=true}, 200)">Change</button>
                <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='avatar__banner'>
                Successfully changed avatar. You may have to log out and log back in to see the results. 
            </div>
                <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='avatar_err__banner'>
                    All fields are required
                </div>
            </form>
        </div>
        </div>
        <div id="email_modal" class="modal bottom-sheet" style="width:50%;margin:auto !important">
        <div class="modal-content">
            <form action="./user/email.php" method="POST" id="__emailForm">
                <div class="input-field">
                    <label>Change Email</label>
                    <input type="email" name="email" autocomplete='off' id='user_change_email_address'>
                </div>
                <button class="btn blue-grey darken-3 waves-effect waves-light" id="_emailBtn" style="line-height:40px;height: 40px" onclick="setTimeout(function(){this.disabled=true}, 200)">Change</button>
                <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='email__banner'>
                Successfully changed email. You may have to log out and log back in to see the results. 
            </div>
                <div class="banner red darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='email_err__banner'>
                    All fields are required
                </div>
            </form>
        </div>
        </div>
        <div id="feedback_modal" class="modal bottom-sheet" style="width:50%;margin:auto !important">
        <div class="modal-content">
            <form id="my-form" action="https://formspree.io/f/xwkakdgw" method="POST">
                <input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>"/>
                <div class="input-field">
                    <label>Message:</label>
                    <textarea name="message" class="materialize-textarea" required/></textarea>
                </div>
                <button id="my-form-button" class="btn blue-grey darken-3 waves-effect waves-light">Submit</button>
                <div class="banner green darken-3 white-text" style="margin-top: 10px;padding: 10px;display:none" id='my-form-status'>
                Successfully submitted! Thank you for sharing your feedback!
            </div>
                </form>
        </div>
        </div>
      <div id="todo_popup" class="modal bottom-sheet" style='height:60vh;min-height:60vh;margin:auto !important;width:90%'> <div class="modal-content"> <h4 id="todo_title">Modal Header</h4> <h5 id="todo_priority">A bunch of text</h5> <p id="todo_desc">A bunch of text</p> </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="./resources/app.js"></script>
  </body>
</html>