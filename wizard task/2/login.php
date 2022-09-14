<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$ldapconfig['host'] = '44.201.85.125';
$ldapconfig['port'] = '389';
$ldapconfig['basedn'] = 'dc=example,dc=com';
$ldapconfig['usersdn'] = 'ou=people';
$ds=ldap_connect($ldapconfig['host'], $ldapconfig['port']);

ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
ldap_set_option($ds, LDAP_OPT_NETWORK_TIMEOUT, 10);

$dn="uid=".$username.",".$ldapconfig['usersdn'].",".$ldapconfig['basedn'];
if(isset($_POST['username'])){
if ($bind=ldap_bind($ds, $dn, $password)) {

   header('Location: mfa.php');
   $filename = "users/$username";
   $_SESSION['username']=$username;

} else {

 echo "Login Failed: Please check your username or password";
}
}

$filename = "/var/www/html/users/".$username;

?>

<!DOCTYPE html>
<html>
        <head>
                <title>Ldap Login</title>
        </head>
                <h3 style="color:black">Ldap Login</h3>

                <form action="" method="post" style="display:inline-block;">
                        <table style="display:inline-block;">
                                <tr>
                                        <td>User</td>
                                        <td><input type="text" name="username" value="" maxlength="50"></td>
                                </tr>
                                <tr>
                                        <td>Password</td>
                                        <td><input type="password" name="password" value="" maxlength="50"></td>
                                </tr>
                                <tr>
                                        <td colspan="2"><input type="submit" name="ldapLogin" value="sumbit"></t>
                                </tr>
                        </table>
                </form>
        </body>
</html>


