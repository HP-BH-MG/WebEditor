<?php
require_once "config.php";
require_once "conn.inc.php";
//session_start();
if ($_SESSION['user_logged'] == "" || $_SESSION['user_password'] == "") {
	$redirect = "/procoat/index.php";
	header ("Location:  $redirect");}
else {
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
</PRE>
<?php
}

$usertype = $_SESSION['usertype'];
$username = $_SESSION['user_logged'];
$usersql = "SELECT * FROM users";
$stmt = sqlsrv_query($conn, $usersql) or die("Invalid query!");
$row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC );
while( $row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC )){
$user = $row['user_name'];
}
switch( $_GET['action'] ){
case "edit":
$usersql = "SELECT * FROM users WHERE user_id = '".$_GET['id']."' ";
$stmt = sqlsrv_query($conn, $usersql) or die("Invalid query!");
$row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC );
$user_name = $row[ 'user_name' ];
$user_pwd = $row[ 'user_pwd' ];
$user_is_online = $row[ 'user_is_online' ];
$user_type = $row[ 'user_type' ];
if ($user_type == 3) {$_SESSION['GodAdmin'] = true;} else {$_SESSION['GodAdmin'] = false;}
break;
default:
$user_name = "";
$user_pwd = "";
$user_is_online = "0";
$user_type = "";
break;
}
?>
<html>
<head>
<TITLE><?php echo $_GET['action']?> user</TITLE>
</head>
<body>
	<p></p><a href="admin.php">Administration</a></p>
	<p></p><a href="logout.php">Logout</a></p>

<FORM action="commit.php?action=<?php echo $_GET['action']?>&type=user&id=<?php
echo $_GET['id']?>" method="post">
<?php
if ( !empty($_GET['error']) ){
echo "<div align=\"center\" style=\"color:#FFFFFF;background-color:#ff0000;fontweight:
bold\">".nl2br(urldecode( $_GET['error']))."</div><br />";
}
?>
<table border=0 width="750" cellspacing=1 cellpadding=3 bgcolor="#353535"
align="center">
<tr>
<td bgcolor="#ffffff" width="30%">
User Name</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="user_name" value="<?php echo $user_name?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
User Password</td>
<?php 
if ($usertype < 3 and $user_type == 3) {
?>
<td bgcolor="#ffffff" width="70%">
<?php echo "********";?></td>
<?php }  
else {
?>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="user_pwd" value="<?php echo $user_pwd;?>"></td>
<?php } ?>
</tr>
<tr>
<td bgcolor="#ffffff">
User Type
</td>

<td bgcolor="#ffffff">
<SELECT id="game" name="user_type" style="width:150px">
<option value="" SELECTED>Select a User type...</option>
<?php
$tsql = "SELECT
usertype_id,
usertype_label
FROM
usertype
ORDER BY
usertype_id
";
$stmt = sqlsrv_query($conn, $tsql)
or die("<font color=\"#181111\">Query Error</FONT>");
while ( $row = sqlsrv_fetch_array($stmt,SQLSRV_FETCH_ASSOC) ){

	if ($usertype < 3 AND $row['usertype_id'] == '3') {break;}
	if ( $row['usertype_id'] == $user_type){$selected = " SELECTED";}
	else {$selected = "";}

echo '<OPTION
value="'.$row['usertype_id'].'"'.$selected.'>'.$row['usertype_label'].'</OPTION>'
."\r\n";
}
?>
</SELECT>
</td>
</tr>
<tr>
<td bgcolor="#ffffff" colspan=2 align="center">
<INPUT type="SUBMIT" name="SUBMIT" value="<?php echo $_GET['action']?>"></td>
</tr>
</table>
</FORM>
<?php
}
?>
</body>
</html>