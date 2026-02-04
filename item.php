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
$itemsql = "SELECT * FROM item WHERE item.item_id = '".$_GET['id']."' ";
$stmt = sqlsrv_query($conn, $itemsql) or die("Invalid query!");
$row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC );
$item_name = $row[ 'item_name' ];
$item_description = $row[ 'item_description' ];
$item_number_of_checkpoints = $row[ 'item_number_of_checkpoints' ];
$item_low_ipl = $row[ 'item_low_ipl' ];
$item_high_ipl = $row[ 'item_high_ipl' ];
$item_low_verniz = $row[ 'item_low_verniz' ];
$item_high_verniz = $row[ 'item_high_verniz' ];
$item_minlambda = $row[ 'item_minlambda' ];
$item_maxlambda = $row[ 'item_maxlambda' ];
break;
default:
$item_name = "";
$item_description = "";
$item_number_of_checkpoints = "";
$item_low_ipl = "";
$item_high_ipl = "";
$item_low_verniz = "";
$item_high_verniz = "";
$item_minlambda = "";
$item_maxlambda = "";
break;
}
?>
<html>
<head>
<TITLE>ProCoat - Thin Layer Analyzing System</TITLE>
</head>
<body>
	<p></p><a href="admin.php">Administration</a></p>
	<p></p><a href="logout.php">Logout</a></p>
	
<FORM action="commit.php?action=<?php echo $_GET['action']?>&type=item&id=<?php
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
item Name</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="item_name" value="<?php echo $item_name?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff">item Description</td>
<td bgcolor="#ffffff">
<input type="textarea" name="item_description" value="<?php echo $item_description?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff">
Number of Checkpoints</td>
<td bgcolor="#ffffff">
<input type="text" name="item_number_of_checkpoints" value="<?php echo $item_number_of_checkpoints?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
Low IPL Warning</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="item_low_ipl" value="<?php echo $item_low_ipl?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
High IPL Warning</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="item_high_ipl" value="<?php echo $item_high_ipl?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
Low Verniz Warning</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="item_low_verniz" value="<?php echo $item_low_verniz?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
High Verniz Warning</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="item_high_verniz" value="<?php echo $item_high_verniz?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff">
Lambda min (nm)</td>
<td bgcolor="#ffffff">
<input type="text" name="item_minlambda" value="<?php echo $item_minlambda?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" width="30%">
Lambda max (nm)</td>
<td bgcolor="#ffffff" width="70%">
<input type="text" name="item_maxlambda" value="<?php echo $item_maxlambda?>"></td>
</tr>
<tr>
<td bgcolor="#ffffff" colspan=2 align="center">
<INPUT type="SUBMIT" name="SUBMIT" value="<?php echo $_GET['action']?>">
</tr>
</table>
</FORM>
<?php if ($debugmode <> '0') {debugDisplay();} 
}
?>
</body>
</html>