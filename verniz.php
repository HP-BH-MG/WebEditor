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


switch( $_GET['action'] ){
case "edit":
$vernizsql = "SELECT * FROM verniz WHERE verniz_id = '".$_GET['id']."' ";
$stmt = sqlsrv_query($conn, $vernizsql) or die("Invalid query!");
$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC );
$verniz_name = $row[ 'verniz_name' ];
$verniz_description = $row[ 'verniz_description' ];
$verniz_supplier = $row[ 'verniz_supplier' ];
$verniz_ri_verniz = $row[ 'verniz_RI_verniz' ];
$verniz_ri_ipl = $row[ 'verniz_RI_IPL' ];

break;
default:
$verniz_name = "";
$verniz_description = "";
$verniz_supplier = "";
$verniz_ri_verniz = "";
$verniz_ri_ipl = "";
break;
}
?>
<html>
<head>
<TITLE>Add Lacquer</TITLE>
</head>
<body>
	<p></p><a href="admin.php">Administration</a></p>
	<p></p><a href="logout.php">Logout</a></p>
	
<FORM action="commit.php?action=<?php echo $_GET['action']?>&type=verniz&id=<?php
echo $_GET['id']?>" method="post">
<?php if ($debugmode <> '0') {debugDisplay();} ?>
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
Lacquer Name</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="verniz_name" value="<?php echo $verniz_name?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff">Lacquer Description</td>
<td bgcolor="#ffffff">
<input type="textarea" name="verniz_description" value="<?php echo $verniz_description?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff">
Supplier</td>
<td bgcolor="#ffffff">
<input type="text" name="verniz_supplier" value="<?php echo $verniz_supplier?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
RI Lacquer</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="verniz_ri_verniz" value="<?php echo $verniz_ri_verniz?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
RI IPL</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="verniz_ri_ipl" value="<?php echo $verniz_ri_ipl?>"></td>
</tr>

<tr>
<td bgcolor="#ffffff" colspan=2 align="center">
<INPUT type="SUBMIT" name="SUBMIT" value="<?php echo $_GET['action']?>"></td>
</tr>
</table>
</FORM>
<?php if ($debugmode <> '0') {debugDisplay();} 
}
?>
</body>
</html>