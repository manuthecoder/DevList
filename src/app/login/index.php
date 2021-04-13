<?php 
session_start();
include('../cred.php');
if(isset($_SESSION['valid'])) {
    header('Location: ../');
    exit();
}
if(isset($_POST['submit'])) {
    try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $sql = $dbh->query('SELECT * FROM accounts WHERE username=' . json_encode($_POST['username']). " AND password=".json_encode(hash('sha256', $_POST['password'])));
        $row_count = $sql->rowCount();
        if($row_count == 1) {
            $dbh1 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $sql1 = 'SELECT * FROM accounts WHERE username=' . json_encode($_POST['username']). " AND password=".json_encode(hash('sha256', $_POST['password']));
            $users = $dbh1->query($sql1);
            foreach ($users as $row){
                $_SESSION['valid'] = '__VALID__';
                $_SESSION['email'] = $row['email'];
                $_SESSION['id'] = $row['id'];
                $t = $row['profile_picture'];
                if(!isset($t) || empty($t)) {
                    $_SESSION['avatar'] = 'https://icon-library.com/images/google-user-icon/google-user-icon-21.jpg';
                }
                else {$_SESSION['avatar'] = $row['profile_picture'];}
                $_SESSION['username'] = $row['username'];
            }
            header('Location: ../');
            exit();
        }
        else {
            header('Location: ./?incorrect');
        }
        $dbh = null;
    }
    catch(PDOexception $e){ echo "Error is: " . $e->etmessage(); }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/css/materialize.min.css">
    </head>
    <body>
        <div class="container">
            <div class="container">
                <div class="container">
                    <form class="center" method="POST">
                        <h4>Login</h4>
                        <div class="input-field">
                            <label>Username</label>
                            <input name="username" type="text" autofocus>
                        </div>
                        <div class="input-field">
                            <label>Password</label>
                            <input name="password" type="password">
                        </div>
                        <button class="btn blue-grey waves-effect waves-light" name="submit" type="submit" style="height: 40px;line-height: 40px;width:100%">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <script>
        <?php 
            if(isset($_GET['incorrect'])) { 
        ?>
            window.onload = function() {M.toast({html: 'Incorrect username or password'})}
        <?php 
        } 
            if(isset($_GET['new'])) {
        ?>
            window.onload = function() {M.toast({html: 'Successfully created account. Please log in to your account'})}
        <?php
        } 
        ?>
        </script>
        <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/js/materialize.min.js"></script>
    </body>
</html>