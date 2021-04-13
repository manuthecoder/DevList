<?php
session_start();
include('./app/cred.php');
if(isset($_POST['submit'])) {
    try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO accounts (username, email, password, profile_picture)
    VALUES (".json_encode($_POST['username']).", ".json_encode($_POST['email']).", ".json_encode(hash('sha256', $_POST['password'])).", \"https://icon-library.com/images/google-user-icon/google-user-icon-21.jpg\")";
    $conn->exec($sql);
    header('Location: ./app/login/?new');
    } catch(PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/css/materialize.min.css">
        <title>
        Devlist - The free developer todo list app!
        </title>
        <style>
        body {background: #fff;margin:0;}
        .card {height: 200px}
        .waves-ripple {transition-duration: .5s !important}
        </style>
    </head>
    <body>
        <nav style="background: #303030">
            <ul>
                <li><a href="#">Devlist</a></li>
            </ul>
            <ul class="right">
                <li><a href="./app/login/">Login</a></li>
            </ul>
        </nav>
        <div class="header" style="background: url(https://wallpapercave.com/wp/wp3988363.png);background-size:cover;color:white;padding: 40px 30px">
            <div class="row container">
                <div class="col s6">
                    <h1>Devlist</h1>
                    <p>Devlist is a website where you can keep track of your coding projects! Become more productive by using our kanban todo list and our bug tracker!</p>
                </div>
                <div class="col s6">
                    <div style="background:white;padding: 10px;text-align:center;border-radius:5px;">
                        <form method="POST">
                        <h5 style="color:black">Join now!</h5>
                            <div class="input-field">
                                <label>Username</label>
                                <input type="text" name="username" required autocomplete="off" autofocus>
                            </div>
                            <div class="input-field">
                                <label>Email</label>
                                <input type="email" name="email" required autocomplete="off">
                            </div>
                            <div class="input-field">
                                <label>Password</label>
                                <input type="password" name="password" required autocomplete="off">
                            </div>
                            <button name="submit" class="btn blue-grey darken-3 waves-effect waves-light" style="width: 100%;height: 40px;line-height: 40px">Join!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <h4 class="center">Features</h4>
            <div class="row">
                <div class="col s4">
                    <div class="card center">
                        <div class="card-content">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg><br>
                        <span class="card-title">To-do list</span>
                        <p>We have a built-in todo list that lets you keep track of your progress!</p>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card center">
                        <div class="card-content">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-code"><polyline points="16 18 22 12 16 6"></polyline><polyline points="8 6 2 12 8 18"></polyline></svg><br>
                        <span class="card-title">Projects</span>
                        <p>You can create multiple projects!</p>
                        </div>
                    </div>
                </div>
                <div class="col s4">
                    <div class="card center">
                        <div class="card-content">
                        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg><br>
                        <span class="card-title">Bug tracker</span>
                        <p>Keep track of your bugs, and fix them!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <footer class="page-footer blue-grey darken-4">
          <div class="container">
            <div class="row">
              <div class="col l6 s12">
                <h5 class="white-text">Devlist</h5>
                <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p>
              </div>
              <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container">
            © <?php echo date('Y'); ?> Copyright
            </div>
          </div>
        </footer>
        <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/js/materialize.min.js"></script>
    </body>
</html>