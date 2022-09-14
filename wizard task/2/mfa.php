<?php
//ini_set('display_errors', 1);

session_start();
require "Authenticator.php";

$Authenticator = new Authenticator();
$username = $_SESSION['username'];
$myfile = ("users/$username");
$secrett = file_get_contents($myfile);

if (!empty($secrett)){

    $_SESSION['auth_secret'] = $secrett;
}

if (!isset($_SESSION['auth_secret'])) {
    $secrett = $Authenticator->generateRandomSecret();
    $_SESSION['auth_secret'] = $secrett;
    $username = $_SESSION['username'];

    $myfile = fopen("users/$username", "w");
    fwrite($myfile, $secrett);
    fclose($myfile);
}

if (!file_exists("$myfile")){

    $qrCodeUrl = $Authenticator->getQR('myLdapServer', $secrett);
}

if (!isset($_SESSION['failed'])) {
    $_SESSION['failed'] = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>dekel.com</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>  
    <link rel='shortcut icon' href='/favicon.ico'  /> 
</head>
<body  class="bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3"  style="background: white; padding: 20px; box-shadow: 10px 10px 5px #888888; margin-top: 100px;">
                <h1>Ldap server Authentication</h1>
                <p style="font-style: italic;">A Google Authenticator</p>
                <hr>
                <form action="check.php" method="post">
                    <div style="text-align: center;">
                        <?php if ($_SESSION['failed']): ?>
                            <div class="alert alert-danger" role="alert">
                                        </strong> Invalid Code.
                            </div>
                            <?php   
                                $_SESSION['failed'] = false;
                            ?>
                        <?php endif ?>
                            
                            <img style="text-align: center;;" class="img-fluid" src="<?php   echo $qrCodeUrl ?>" alt="Verify this Google Authenticator"><br><br>  
                            <input type="text" class="form-control" name="code" placeholder="******" style="font-size: xx-large;width: 200px;border-radius: 0px;text-align: center;display: inline;color: #0275d8;"><br> <br>    
                            <button type="submit" class="btn btn-md btn-primary" style="width: 200px;border-radius: 0px;">Verify</button>

                    </div> 

                </form>
            </div>
        </div>
    </div>
</body>
</html>
