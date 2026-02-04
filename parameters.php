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
$_SESSION
<?php
print_r($_SESSION);
?>
</PRE>
<?php
}

switch( $_GET['action'] ){
case "edit":
$paramsql = "SELECT * FROM parameters";
$stmt = sqlsrv_query($conn, $paramsql) or die("Invalid query!");
$row = sqlsrv_fetch_array( $stmt , SQLSRV_FETCH_ASSOC);
$parameters_integrationtime = $row[ 'parameters_integrationtime' ];
$parameters_average = $row[ 'parameters_average' ];
$parameters_maxpeaksnumber = $row[ 'parameters_maxpeaksnumber' ];
$parameters_minthickness = $row[ 'parameters_minthickness' ];
$parameters_maxthickness = $row[ 'parameters_maxthickness' ];
$parameters_maxnoise = $row[ 'parameters_maxnoise' ];
break;
default:
$parameters_integrationtime = "";
$parameters_average = "";
$parameters_maxpeaksnumber = "";
$parameters_minthickness = "";
$parameters_maxthickness = "";
$parameters_maxnoise = "";
break;
}
?>
<html>
<head>
<TITLE>Edit parameters</TITLE>
</head>
<body>
<FORM action="commit.php?action=<?php echo $_GET['action']?>&type=parameters&id=<?php
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
Integration Time (ms)</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="parameters_integrationtime" value="<?php echo $parameters_integrationtime?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff">Average</td>
<td bgcolor="#ffffff">
<input type="textarea" name="parameters_average" value="<?php echo $parameters_average?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
Number of Layer(s) </td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="parameters_maxpeaksnumber" value="<?php echo $parameters_maxpeaksnumber?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
Start FFT Graph (um)</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="parameters_minthickness" value="<?php echo $parameters_minthickness?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
End FFT Graph (um)</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="parameters_maxthickness" value="<?php echo $parameters_maxthickness?>">
</td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
Signal/Noise ratio (dB)</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="parameters_maxnoise" value="<?php echo $parameters_maxnoise?>">
</td>
</tr>
<tr>
<td bgcolor="#ffffff" colspan=2 align="center">
<INPUT type="SUBMIT" name="SUBMIT" value="<?php echo $_GET['action']?>">
</tr>
</table>
</FORM>
<?php
}
?>
</body>
</html>