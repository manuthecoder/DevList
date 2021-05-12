<?php
session_start();
if(isset($_POST['submit'])) {
include('../../cred.php');
$name = str_replace("<", "",str_replace("?", "", str_replace("'", "", $_POST['name'])));
$qty = str_replace("<", "",str_replace("?", "", str_replace("'", "",$_POST['icon'])));
$type = str_replace("<", "",str_replace("?", "", str_replace("'", "",$_POST['type'])));
$loginId = $_SESSION['id'];
try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO projects(name, type, login, icon, description) 
  VALUES(".json_encode($name).", ".json_encode($type).", ".json_encode($_SESSION['id']).", ".json_encode($qty).", ".json_encode($_POST['desc']).")";
  $conn->exec($sql);
  $id = $conn->lastInsertId();
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "INSERT INTO accounts_owned(login, project_id, project, project_name, project_icon, permissions) 
  VALUES(".json_encode($_SESSION['id']).", ".json_encode($id).", ".json_encode($_POST['name']).", ".json_encode($_POST['name']).", ".json_encode($_POST['icon']).", \"Admin\")";
  $conn->exec($sql);
  header("Location: ../../");
} catch(PDOException $e) {
  echo $sql . "<br>" . $e->getMessage();
}

$conn = null;
}
?><head> <script async src="https://www.googletagmanager.com/gtag/js?id=G-S0PH6N0Z7E"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
    
      gtag('config', 'G-S0PH6N0Z7E');
    </script> <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>   <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
<title>Add a project</title>

    
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
.dropdown-content a {color:gray !important;}
a {text-decoration:none}
@import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');
form {
    height: 100%;
}
* {
-webkit-touch-callout:none;                /* prevent callout to copy image, etc when tap to hold */
-webkit-text-size-adjust:none;             /* prevent webkit from resizing text to fit */
-webkit-tap-highlight-color:rgba(0,0,0,0); /* prevent tap highlight color / shadow */
}

form {
width:40vw;
position:relative;
margin: auto;
padding: 10px;
box-shadow: 25px 25px 100px #eee;
border-radius: 4px;
animation: form .2s forwards;
animation-delay: .5s;
transform: scale(.8);
opacity: 0;
transition: all .2s !important;
}
@keyframes form {
0% {
    opacity: 0;
}
100% {
    opacity: 1;
    transform: scale(1)
}
}
* {
box-sizing: border-box;
font-family: 'Poppins', sans-serif;
}
input {background: whitesmoke;outline: 0;border: 0;padding: 15px;width: 100%;transition: all .2s;margin-bottom: 10px;}
button {background: #1e88e5;outline: 0;border: 0;padding: 15px;width: 100%;margin-top: 10px;color:white;cursor: pointer;transition: all .2s;margin-bottom: 10px;}
button:hover {background: #1565c0}
button:active {background: #0d47a1;transform: scale(.95)}
form:before {
    background:linear-gradient(to left, #c4268c, #9a0b72);
    content: "";
    width: 100%;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: 4px;
    height: 5px
}
a {
    display: inline-block;
    margin:0;
}
.gray {outline: 0;border: 0;padding: 15px;width: 48%;margin-top: 10px;cursor: pointer;transition: all .2s;color:gray;}
.gray:hover {
   background: #eee;
}
@media only screen and (max-width: 900px) {
form {
width: 75vw
}
@media only screen and (max-width: 600px) {
form {
width: 95vw
}
}
</style>
<div style="text-align:center;position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);font-family: 'Open Sans', sans-serif;" >
<form method="POST">
    <h5>Create new project</h5>
<div class="row">
    <div class="col s12">
            <input name="name" placeholder="Project name" required autofocus><br>
    </div>
    <div class="col s8 m9">
            <input placeholder="Choose icon..." value="label_outline" required name="icon" readonly id="icon1"><br>
</div>

<div class="col s4 m3">  <a class='dropdown-trigger btn purple btn-largea waves-effect'style="width:100%" href='#' data-target='dropdown1'>Choose</a>
</div>
<div class="input-field col s12">
<label>Description</label>
<textarea name="desc" class="materialize-textarea" required></textarea>
</div>
  <div class="input-field col s12">
                <select name="type" required>
                <option value="" disabled selected>Type of project</option>
                <option value="SaaS">SaaS</option>
                <option value="Open Source">Open Source</option>
                <option value="PaaS">PaaS</option>
                <option value="IaaS">IaaS</option>
                <option value="Other">Other</option>
                </select>
            </div>
</div>  <!-- Dropdown Trigger -->
  <!-- Dropdown Structure -->
  <ul id='dropdown1' class='dropdown-content' style='min-width: 300px;margin-top: 10px;'>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">masks</i>masks <span class='badge new'></span></a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">label_outline</i>Default</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">kitchen</i>Kitchen</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">add_shopping_cart</i>Shopping Cart</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">attach_file</i>File</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">backup</i>Cloud</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_activity</i>Ticket</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_airport</i>Plane</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_atm</i>ATM</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_bar</i>Beverage</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_cafe</i>Cafe</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_car_wash</i>Car Wash</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_convenience_store</i>Store</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_dining</i>Dining room</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_drink</i>Beverage</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_florist</i>Flower</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_gas_station</i>Gas</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_grocery_store</i>Grocery Store</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_hospital</i>Medical supplies</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_hotel</i>Hotel</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_laundry_service</i>Laundry</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_library</i>Book (Library)</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_mall</i>Mall</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_movies</i>Movie</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_offer</i>Local Offer</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_pharmacy</i>Pharmacy</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_phone</i>Phone</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">local_pizza</i>Food</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">coronavirus</i>Coronavirus</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">cake</i>Cake</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">deck</i>Deck</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">domain</i>domain</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">fireplace</i>Fireplace</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">piano</i>Piano</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">sports_esports</i>sports_esports</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">sports_basketball</i>sports_basketball</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">sports_cricket</i>sports_cricket</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">sports_football</i>sports_football</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">sports_golf</i>sports_golf</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">sports_mma</i>sports_mma</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">backpack</i>backpack</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">cabin</i>cabin</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">beach_access</i>beach_access</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">cottage</i>cottage</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">tapas</i>tapas</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">engineering</i>engineering</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">kayaking</i>kayaking</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">kitesurfing</i>kitesurfing</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">outdoor_grill</i>outdoor_grill</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">public</i>public</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">hiking</i>hiking</a></li>
    <li><a href="#!" onclick="icon.value = this.innerHTML.value = this.getElementsByTagName('i')[0].innerHTML"><i class="material-icons">medication</i>medication</a></li>
  </ul>
    <button name="submit">Create</button>
</form>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
$(document).ready(function(){
  $('.dropdown-trigger').dropdown();
  $('select').formSelect();
});
var icon = document.getElementById('icon1');
</script>