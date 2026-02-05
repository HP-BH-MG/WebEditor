<?php
require_once "config.php";
require_once "conn.inc.php";
//session_start();
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
if ($_SESSION['user_logged'] == "" || $_SESSION['user_password'] == "") {
	$redirect = "/procoat/unlogged_user.php";
	header ("Location:  $redirect");}
else {
$user_type = $_SESSION['usertype'];
$user_name = $_SESSION['user_logged'];

 if ($debugmode <> '0') {debugDisplay();} 
// DELETE SCRIPT
if ( !isset( $_GET['do'] ) || $_GET['do'] != 1 ){
	?>
	<p align="center" style="color:#FF0000">
	Are you sure you want to delete this <?php echo $_GET['type']?>?<br/>
	<a href="<?php echo $_SERVER['REQUEST_URI']?>&do=1">yes</a> or <a
	href="admin.php">Administration</a>
	</p>
	<?php
} else {

		if ($user_type < 3) {?>
		 
		<p align="center" style="color:#FF0000">
		Sorry <?php echo $_SESSION['user_logged']?>, only GodAdmins have the permission to delete.<br/>
		Please, go back to the administration area. <a href="admin.php">Administration</a> </p> 
		<?php }
		else {
	
			// generate SQL
			$tsql = "DELETE FROM  ".$_GET['type']."
			WHERE
					".$_GET['type']."_id = ".$_GET['id']."
					";
			
			// echo SQL for debug purpose
			if ($debugmode <> 0) echo "SQL: ".$tsql."</br>";
			$stmt = sqlsrv_query($conn, $tsql);
			if ($stmt === false) {
				echo ""."</br>";?>
				<p  style="color:#FF0000">
				DELETING NOT POSSIBLE!</br></br>
				Please, go back to the administration area. <a href="admin.php">Administration</a> </p> 
			<?php }	
			else {
			?>
						
			<p align="center" style="color:#FF0000">
			Your <?php echo $_GET['type']?> has been deleted. <a
			href="admin.php">Administration</a>
			</p>
			<?php
			}
}}
}
?>
