<?php
session_start();

require "Authenticator.php";
if ($_SERVER['REQUEST_METHOD'] != "POST") {
    header("location: mfa.php");
    die();
}
$Authenticator = new Authenticator();

$username = $_SESSION['username'];

$myfile = ("users/$username");
$secrett = file_get_contents($myfile);

$checkResult = $Authenticator->verifyCode($secrett, $_POST['code']);
if (!$checkResult) {
    $_SESSION['failed'] = true;
    header("location: mfa.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Authentication Successful</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
        <meta name="description" content="Implement Google like Time-Based Authentication into your existing PHP application. And learn How to Build it? How it Works? and Why is it Necessary these days."/>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel='shortcut icon' href='/favicon.ico'  />

</head>
<body  class="bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3"  style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 100px;">
                <hr>
                    <div style="text-align: center;">
                           <h1>Authentication Successful</h1>
                           <p>You are loggin to dekel.com</p>
                    </div>
            </div>
        </div>
    </div>
</body>
</html>


