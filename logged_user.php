<?php
session_start();
if ($_SESSION['user_logged'] == "" || $_SESSION['user_password'] == "") {
	$redirect = "/procoat/index.php";
	header ("Location:  $redirect");}
else {
$user_type = $_SESSION['usertype'];
$user_name = $_SESSION['user_logged'];
// Debug info Display
function debugDisplay(){
?>
<PRE>
$_POST
<?php
print_r($_POST);
?>
$_GET
<?php
print_r($_GET);
?>
$_SESSION
<?php
print_r($_SESSION);
?>
$_SERVER
<?php
print_r($_SERVER);
?>
</PRE>
<?php
}
require "config.php";

?>
<html>
<head>
<title>ProCoat - Thin Layer Analyzing System</title>
</head>
<body>
<h1>Welcome <?php echo $user_name;?> to ProCoat!</h1>
And thank you for logging into ProCoat.<br>
<?php

if ($user_type == 1) {echo "Sorry $user_name, you do not have the permission to access this page.";
$_SESSION['usertype'] = '';
$_SESSION['user_logged'] = '';
//$redirect = 'index.php';
?>
You may now <a href="index.php">click here</a>
to return to the Index.<?php
//header ("Refresh: 5; $redirect");
if ($debugmode <> '0') {debugDisplay();}
}
else { if ($_SESSION['usertype'] == 3) { echo "$user_name, you are GodAmin and you have unrestricted rights do edit and delete data from the database.";} else {echo "$user_name, you are Administrator but you do not have the right to delete data from the database.";}?>
<br/>
You may now <a href="admin.php">click here</a>
to go to the administration area.
<?php }
if ($debugmode <> '0') {debugDisplay();}
}
 ?>
</body>
</html>