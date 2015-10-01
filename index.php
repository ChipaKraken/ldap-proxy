<?php 
require_once 'auth.php';
$username = $_POST['username']; 
$password = $_POST['password'];
$status = user_login_ldap($username, $password);
echo '{"status":"$status"}'
 ?>
