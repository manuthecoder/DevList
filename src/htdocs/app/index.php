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
    <meta name="theme-color" content="#121212">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.css' rel='stylesheet' />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.6.0/main.min.js"></script>  
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="https://i.ibb.co/gRCzWCN/Instagram-verifed.png">
    <style>
      .waves-light .waves-ripple {background: rgba(255,255,255,.2) !important;}
      .card-title {width: 100%;white-space: nowrap; overflow: hidden; text-overflow: ellipsis;}
      .fc-event{ cursor: pointer; padding:1.5px;margin-bottom: 4px;}
      button {transition: all .2s}
      .fc-event {transition: all .2s} 
      .fc-event:hover {background: rgba(0,0,0,0.1) !important}
      .modal-footer {background: var(--modal-color) !important}
      * {scroll-behavior: smooth}
      .modal-footer a {color: var(--font-color) !important;}
      [data-theme="dark"] table td,[data-theme="dark"] table,[data-theme="dark"] table div,[data-theme="dark"] tr, [data-theme="dark"] .fc-col-header-cell {border-color: #303030 !important}
      input::-webkit-outer-spin-button,
      input::-webkit-inner-spin-button {
        /* display: none; <- Crashes Chrome on hover */
        -webkit-appearance: none;
        margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
      }
      input[type=number] {
        -moz-appearance:textfield; /* Firefox */
        -webkit-appearance: none;
      }
      .btn-flat {background: transparent !important}
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="#slide-out" class="sidenav-trigger" style="margin:0" data-target="slide-out"><i class="material-icons left show-on-small-only">menu</i>Devlist</a></li>
      </ul>
      <ul class="right">
        <li><a class="waves-effect" style="border-radius:999px;margin-right: 10px" onclick="switchTheme()"><i class="material-icons" style="position:relative;top:-5px">dark_mode</i></a></li>
      </ul>
    </nav>
    <ul id="slide-out" class="sidenav sidenav-fixed">
      <li><div class="user-view">
        <div class="background">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUwMDD////wqdhXAAAACXBIWXMAAA7EAAAOxAGVKw4bAAAACklEQVQImWNgAAAAAgAB9HFkpgAAAABJRU5ErkJgggo=" width="100%">
        </div>
        <a href="#user"><img class="circle" src="<?php echo $_SESSION['avatar'];?>"></a>
        <a href="#name"><span class="white-text name"><?php echo $_SESSION['username']; ?></span></a>
        <a href="#email"><span class="white-text email"><?php echo $_SESSION['email']; ?></span></a>
        </div></li>
      <li><a href="#/dashboard" class="waves-effect" onclick="AJAX_LOAD('home.php')"><i class="material-icons">home</i>Home</a></li>
      <li><div class="divider"></div></li>
      <li><a class="subheader">Projects</a></li>
      <?php
      try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = "SELECT * FROM accounts_owned WHERE login=" . $_SESSION['id']. " ORDER BY id ASC";
        $users = $dbh->query($sql);
        foreach ($users as $row){
          echo '<li class="no-padding">
                    <ul class="collapsible">
                    <li>
                        <a class="collapsible-header waves-effect" id="project_'.strtolower(str_replace(' ', '-', $row['project'])).'" href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'" style="padding-left: 35px">'.$row['project'].'<i class="material-icons">'.$row['project_icon'].'</i></a>
                        <div class="collapsible-body" style="background: rgba(255,255,255,.1)">
                        <ul>
<li class="links"><a class="waves-effect sidenav-close" href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/todo" style="margin-left: 35px" onclick="AJAX_LOAD(\'todo.php?id='.$row['project_id'].'\')"><i class="material-icons">task_alt</i>Todo</a></li>
<li class="links"><a class="waves-effect sidenav-close" href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/bugs" style="margin-left: 35px" onclick="AJAX_LOAD(\'bugs.php?id='.$row['project_id'].'\')"><i class="material-icons">bug_report</i>Bugs</a></li>
<li class="links"><a href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/changelog" class="waves-effect sidenav-close" style="margin-left: 35px" onclick="AJAX_LOAD(\'changelog.php?id='.$row['project_id'].'\')"><i class="material-icons">history</i>Changelog</a></li>
<li class="links"><a href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/releases" class="waves-effect" style="margin-left: 35px" onclick="AJAX_LOAD(\'releases.php?id='.$row['project_id'].'\')"><i class="material-icons">new_releases</i>Releases</a></li>
<li class="links"><a  href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/links"class="waves-effect sidenav-close" style="margin-left: 35px" onclick="AJAX_LOAD(\'links.php?id='.$row['project_id'].'\')"><i class="material-icons">links</i>Links</a></li>
<li class="links"><a  href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/roadmap" class="waves-effect sidenav-close" style="margin-left: 35px" onclick="AJAX_LOAD(\'roadmap.php?id='.$row['project_id'].'\')"><i class="material-icons">map</i>Roadmap</a></li>
'.($row['permissions'] !== "View Only" ? '<li class="links"><a href="#/projects/'.$row['project_id'].'/'.strtolower(str_replace(' ', '-', $row['project'])).'/settings" class="waves-effect sidenav-close" style="margin-left: 35px" onclick="AJAX_LOAD(\'./project/settings.php?id='.$row['project_id'].'\')"><i class="material-icons">settings</i>Settings</a></li>' : "").'
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
      <li class="links"><a class="waves-effect sidenav-close" onclick="AJAX_LOAD('lofi.php')"><i class="material-icons">music_note</i>Focus music</a></li>
      <li class="links"><a class="waves-effect sidenav-close" onclick="AJAX_LOAD('notepad.php')"><i class="material-icons">note</i>Notepad</a></li>
      <li class="links"><a class="waves-effect sidenav-close" onclick="AJAX_LOAD('calendar.php')"><i class="material-icons">event</i>Calendar</a></li>
      <li class="links"><a class="waves-effect sidenav-close modal-trigger" href="#feedback_modal"><i class="material-icons">feedback</i>Feedback</a></li>
      <li class="links"><a class="waves-effect sidenav-close" href="https://manuthecoder.ml/"><i class="material-icons">more_horiz</i>More apps</a></li>
      <li class="links"><a class="waves-effect sidenav-close" onclick="AJAX_LOAD('logout.php')"><i class="material-icons">logout</i>Logout</a></li>
      <li><div class="divider"></div></li>
      <li><a class="subheader">Profile</a></li>
      <li class="links"><a class="waves-effect sidenav-close" onclick="AJAX_LOAD('./user/settings.php')"><i class="material-icons">settings</i>Settings</a></li>
      <li class="links"><a class="waves-effect sidenav-close" onclick="AJAX_LOAD('logout.php')"><i class="material-icons">logout</i>Logout</a></li>
    </ul>
    <div class="main">
      <div id="__ajaxLoader"></div>
      <div id='__AJAX_LOADER'></div>
    </div>
    <div id="roadmapModal" class="modal bottom-sheet" style="margin: auto !important;width: 90%;height: 70vh;min-height: 70vh">
      <div class='modal-content' id="mc">
      </div>
      </form>
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
  <div id="calendarModal" class="modal-fixed-footer modal bottom-sheet" style="width:50%;margin:auto !important">
    <div class="modal-content">
      <h3>Title</h3>
      <h6></h6><h5></h5>
    </div>
    <div class="modal-footer">
      <a href="#" id="calendarModalDelete" class="btn btn-flat waves-effect"><i class="material-icons">delete</i></a>
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
<script>
  var __hash_noReplace;
  var __hash = window.location.hash.replace('#', '');
  if(__hash.includes('/projects/')) {
    if(!__hash.includes('/todo') && !__hash.includes('/bugs') && !__hash.includes('/changelog') && !__hash.includes('/releases') && !__hash.includes('/links') && !__hash.includes('/links') && !__hash.includes('/settings') && !__hash.includes('/roadmap')) {
      __hash = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
      __hash_noReplace = __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
      window.addEventListener('load', function() {
        $('.collapsible').collapsible('close')
        document.getElementById(__hash).click();
        AJAX_LOAD('home.php');
      });
    }
    else if(__hash.includes('/todo')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('todo.php?id='+id);
    }
    else if(__hash.includes('/bugs')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('bugs.php?id='+id)
    }
    else if(__hash.includes('/changelog')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('changelog.php?id='+id)
    }
    else if(__hash.includes('/releases')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('releases.php?id='+id)
    }
    else if(__hash.includes('/links')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('links.php?id='+id)
    }
    else if(__hash.includes('/roadmap')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('roadmap.php?id='+id)
    }
    else if(__hash.includes('/settings')) {
      window.addEventListener('load', function() {
        __hash_noReplace = "project_" + __hash.replace('/projects/', '').replace(/[0-9]/g, '').replace('/', '');
        __hash_noReplace = __hash_noReplace.split('/')[0]
        var hash1 = window.location.hash;
        document.getElementById(__hash_noReplace).click();
        window.location.hash = hash1;
        setTimeout(function() {document.getElementById(__hash_noReplace).scrollIntoView();}, 1000)
      });
      __hash = __hash.replace('/projects/', '');
      var id = __hash.replace(/\D/g,'');
      AJAX_LOAD('./project/settings.php?id='+id)
    }
    else {
      window.addEventListener('load', function() {
        AJAX_LOAD('home.php');
      });
    }
  }
  else {
    window.addEventListener('load', function() {
      AJAX_LOAD('home.php');
    });
  }
</script>
</body>
</html>