<?php
require_once "config.php";
require_once "conn.inc.php";
?>
<html>
<head>
<TITLE>Verniz database</TITLE>
</head>
<body>
<table border=0 width="600" cellspacing=1 cellpadding=3 bgcolor="#353535"
align="center">
<td bgcolor="#ffffff" colspan=2 align="center">
Verniz <a href="verniz.php?action=add&id=">[ADD]</a>
</td>
<?php
$vernizsql = "SELECT * FROM verniz";
$result = odbc_exec($sqlconnect, $vernizsql)
or die("Invalid query!");

while( $row = odbc_fetch_array($result) ){
?>
<tr>
<td bgcolor="#ffffff" width="50%">
<?php echo $row['verniz_short_description']?>
</td>
<td bgcolor="#ffffff" width="50%" align="right">
<a href="verniz.php?action=edit&id=<?php echo
$row['id']?>">[EDIT]</a>
<a href="delete.php?type=verniz&id=<?php echo
$row['id']?>">[DELETE]</a>
</td>
</tr>
<?php
}
?>
<td bgcolor="#ffffff" colspan=2 align="center">
item <a href="item.php?action=add&id=">[ADD]</a>
</td>
<?php
$itemsql = "SELECT * FROM item";
$result = odbc_exec($sqlconnect, $itemsql)
or die("Invalid query!");
while( $row = odbc_fetch_array($result) ){
?>
<tr>
<td bgcolor="#ffffff" width="50%">
<?php echo $row['item_short_description']?>
</td>
<td bgcolor="#ffffff" width="50%" align="right">
<a href="item.php?action=edit&id=<?php echo
$row['id']?>">[EDIT]</a>
<a href="delete.php?type=item&id=<?php echo
$row['id']?>">[DELETE]</a>
</td>
</tr>
<?php
}
?>
<td bgcolor="#ffffff" colspan=2 align="center">
User <a href="user.php?action=add&id=">[ADD]</a>
</td>
<?php
$usersql = "SELECT * FROM users";
$result = odbc_exec($sqlconnect, $usersql)
or die("Invalid query!");
while( $row = odbc_fetch_array($result) ){
?>
<tr>
<td bgcolor="#ffffff" width="50%">
<?php echo $row['user_name']?>
</td>
<td bgcolor="#ffffff" width="50%" align="right">
<a href="user.php?action=edit&id=<?php echo
$row['id']?>">[EDIT]</a>
<a href="delete.php?type=people&id=<?php echo
$row['id']?>">[DELETE]</a>
</td>
</tr>
<?php
}
?>
</table>
</body>
</html>