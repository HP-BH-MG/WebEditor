<?php
// session_start();
require_once "config.php";
require_once "conn.inc.php";
if ($_SESSION['user_logged'] == "" || $_SESSION['user_password'] == "") {
	$redirect = "/procoat/index.php";
	header ("Location:  $redirect");}
else {
  $title = 'ProCoat Database Editor';  
		//	require_once "inc/header.php"
?>
<html>
<head>
<title>ProCoat - Layerthickness Measurement System</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #FFFFFF; }
-->
</style>
</head>
<body>
<h1>Welcome to the Administration Page</h1>
<a href="logout.php">Logout</a>
<?php
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

?>
<body> 
<table border=0 width="600" cellspacing=1 cellpadding=3 bgcolor="#353535"
align="center">
<td bgcolor="#ffffff" colspan=2 align="center">
Item <a href="item.php?action=add&id=">[ADD]</a></td>
<?php
$itemsql = "SELECT * FROM item order by item_name";
$stmt = sqlsrv_query($conn, $itemsql) or die("Invalid query!");
while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) )
  {
?>
<tr>
<td bgcolor="#ffffff" width="50%">
<?php echo $row['item_name']?></td>
<td bgcolor="#ffffff" width="50%" align="right">
<a href="item.php?action=edit&id=<?php echo
$row['item_id']?>">[EDIT]</a>
<a href="delete.php?type=item&id=<?php echo
$row['item_id']?>">[DELETE]</a></td>
</tr>
<?php
}
?>
<td bgcolor="#ffffff" colspan=2 align="center">
Users <a href="user.php?action=add&id=">[ADD]</a></td>
<?php
$usersql = "SELECT * FROM users order by user_name";
$stmt = sqlsrv_query($conn, $usersql) or die("Invalid query!");
while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC))
  {
?>
<tr>
<td bgcolor="#ffffff" width="50%">
<?php echo $row['user_name']?></td>
<td bgcolor="#ffffff" width="50%" align="right">
<a href="user.php?action=edit&id=<?php echo
$row['user_id']?>">[EDIT]</a>
<a href="delete.php?type=user&id=<?php echo
$row['user_id']?>">[DELETE]</a></td>
</tr>
<?php
}
?>
<td bgcolor="#ffffff" colspan=2 align="center">
Lacquer <a href="verniz.php?action=add&id=">[ADD]</a></td>
<?php
$vernizsql = "SELECT * FROM verniz order by verniz_name";
$stmt = sqlsrv_query($conn, $vernizsql) or die("Invalid query!");
while( $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC) )
  {
?>
<tr>
  <td bgcolor="#ffffff"><?php echo $row['verniz_name']?> </td>
  <td bgcolor="#ffffff" align="right"><a href="verniz.php?action=edit&id=<?php echo
$row['verniz_id']?>">[EDIT]</a> <a href="delete.php?type=verniz&id=<?php echo
$row['verniz_id']?>">[DELETE]</a> </td>
</tr>
<?php } ?>
    <td bgcolor="#ffffff" colspan=2 align="center"> Shutter </td>

<tr>
<?php
$shuttersql = "SELECT shutter_counts FROM shutter";
$stmt = sqlsrv_query($conn, $shuttersql);
$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
?>
<td bgcolor="#ffffff" width="50%">Shutter movements: <?php echo $row['shutter_counts'] ?></td>
<?php
if ($row['shutter_counts'] > '1000000') {?>
<td bgcolor="#ffffff" width="50%" align="right"><div align="center" class="style1">Shutter needs to be changed!</div></td> 
<?php } else { ?>
<td bgcolor="#ffffff" width="50%"> </td> <?php } ?>
</tr>
<?php } ?>
</table>
<?php if ($debugmode <> '0') {debugDisplay();} ?>

</body>
</html>