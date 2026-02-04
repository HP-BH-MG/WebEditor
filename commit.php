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
// COMMIT ADD AND EDITS
$error = '';
$usertype = $_SESSION['usertype'];
$username = $_SESSION['user_logged'];
switch( $_GET['action'] ){
case "edit":
switch( $_GET['type'] ){
case "user":
$user_name = trim($_POST['user_name']);
if( empty($user_name)){$error .= "Please+enter+a+user+name%21%0D%0A";}
$user_pwd = trim($_POST['user_pwd']);
if( empty($user_pwd) and $_SESSION['GodAdmin'] == false){$error .= "Please+enter+a+password%21%0D%0A";}
else if( empty($user_pwd) and $_SESSION['GodAdmin'] == true)
		{$error .= "You+are+not+allowed+to+edit+this+user+!%21%0D%0A";}
$user_type = trim($_POST['user_type']);
if ( empty($error) ){
$tsql = "UPDATE users
SET
user_name = '".$_POST['user_name']."',
user_pwd = '".$_POST['user_pwd']."',
user_type = '".$_POST['user_type']."'
WHERE user_id = '".$_GET['id']."'
";
} else {
header(
"location:user.php?action=edit&error=".$error."&id=".$_GET['id'] );
}
break;

case "item":
$item_name = $_POST['item_name'];
if( empty($item_name)){$error .= "Please+enter+a+item+name%21%0D%0A";}

if (empty($_POST['item_description'])){
$error .= "Please+select+a+item+description%21%0D%0A";}

$item_number_of_checkpoints = trim($_POST['item_number_of_checkpoints']);
if ( !is_numeric ( $item_number_of_checkpoints )){
$error .= "Please+enter+a+numeric+number+of+checkpoints+%21%0D%0A";
} else {
if ( $item_number_of_checkpoints < 1 || $item_number_of_checkpoints > $maxnumber_of_checkpoints ){
$error .= "Please+enter+a+number+of+checkpoints+between+1+and+$maxnumber_of_checkpoints%21%0D%0A";
}
}
$item_low_ipl = trim($_POST['item_low_ipl']);
if ( !is_numeric ( $item_low_ipl )){
$error .= "Please+enter+a+numeric+number+for+the+Low+IPL+Warning%21%0D%0A";
} else {
if ( $item_low_ipl < 0 || $item_low_ipl >= $max_ipl ){
$error .= "Please+enter+a+number+for+the+Low+IPL+Warning+between+0+and+$max_ipl%21%0D%0A";
}
}
$item_high_ipl = trim($_POST['item_high_ipl']);
if ( !is_numeric ( $item_high_ipl )){
$error .= "Please+enter+a+numeric+number+for+the+High+IPL+Warning%21%0D%0A";
} else {
if ( $item_high_ipl < 0 || $item_high_ipl >= $max_ipl ){
$error .= "Please+enter+a+number+for+the+High+IPL+Warning+between+0+and+$max_ipl%21%0D%0A";
}
} 
$item_low_verniz = trim($_POST['item_low_verniz']);
if ( !is_numeric ( $item_low_verniz )){
$error .= "Please+enter+a+numeric+number+for+the+low+verniz%21%0D%0A";
} else {
if ( $item_low_verniz < 0 || $item_low_verniz >= $max_verniz ){
$error .= "Please+enter+a+number+for+the+verniz+between+0+and+$max_verniz%21%0D%0A";
}
}
$item_high_verniz = trim($_POST['item_high_verniz']);
if ( !is_numeric ( $item_high_verniz )){
$error .= "Please+enter+a+numeric+number+for+the+High+Verniz+Warning%21%0D%0A";
} else {
if ( $item_high_verniz < 0 || $item_high_verniz >= $max_verniz ){
$error .= "Please+enter+a+number+for+the+High+Verniz+Warning+between+0+and+$max_verniz%21%0D%0A";
}
} 
$item_minlambda = trim($_POST['item_minlambda']);
if ( !is_numeric ( $item_minlambda )){
$error .= "Please+enter+a+numeric+number+of+Lambda+min+%21%0D%0A";
} else {
if ( $item_minlambda < $minlambda || $item_minlambda > $maxlambda ){
$error .= "Please+enter+a+number+of+Lambda+min+between+$minlambda+and+$maxlambda%21%0D%0A";
}
}
$item_maxlambda = trim($_POST['item_maxlambda']);
if ( !is_numeric ( $item_maxlambda )){
$error .= "Please+enter+a+numeric+number+of+Lambda+max+%21%0D%0A";
} else {
if ( $item_maxlambda < $minlambda || $item_maxlambda > $maxlambda ){
$error .= "Please+enter+a+number+of+Lambda+max+between+$minlambda+and+$maxlambda%21%0D%0A";
}
}
if ( $item_maxlambda <= $item_minlambda ){
$error .= "Lambda+max+is+smaller+or+equal+to+Lambda+min%21%0D%0A";
}
if ( empty($error) ){
$tsql = "UPDATE
item
SET
item_name = '".$_POST['item_name']."',
item_description = '".$_POST['item_description']."',
item_number_of_checkpoints = '".$_POST['item_number_of_checkpoints']."',
item_low_ipl = '".$_POST['item_low_ipl']."',
item_high_ipl = '".$_POST['item_high_ipl']."',
item_low_verniz = '".$_POST['item_low_verniz']."',
item_high_verniz = '".$_POST['item_high_verniz']."',
item_minlambda = '".$_POST['item_minlambda']."',
item_maxlambda = '".$_POST['item_maxlambda']."'
WHERE
item_id = '".$_GET['id']."'
";

} else {
header(
"location:item.php?action=edit&error=".$error."&id=".$_GET['id'] );
}
break;

case "verniz":
$verniz_name = trim($_POST['verniz_name']);
if( empty($verniz_name)){$error .= "Please+enter+a+lacquer+name%21%0D%0A";}

$verniz_description = trim($_POST['verniz_description']);
if (empty($verniz_description)){$error .= "Please+enter+a+lacquer+description%21%0D%0A";}

if (empty ( $_POST['verniz_supplier'] )){
$error .= "Please+enter+a+lacquer+supplier%21%0D%0A"; }

$verniz_ri_verniz = trim($_POST['verniz_ri_verniz']);
if ( !is_numeric ( $verniz_ri_verniz )){
$error .= "Please+enter+a+numeric+number+for+the+lacquer+RI%21%0D%0A";
} else {
if ( $verniz_ri_verniz < 1 || $verniz_ri_verniz >= $max_verniz_ri ){
$error .= "Please+enter+a+number+for+the+lacquer+RI+between+1+and+$max_veniz_ri%21%0D%0A";
}
}
$verniz_ri_ipl = trim($_POST['verniz_ri_ipl']);
if ( !is_numeric ( $verniz_ri_ipl )){
$error .= "Please+enter+a+numeric+number+for+the+IPL+RI%21%0D%0A";
} else {
if ( $verniz_ri_ipl < 1 || $verniz_ri_ipl >= $max_ipl_ri ){
$error .= "Please+enter+a+number+for+the+IPL+RI+between+1+and+$max_ipl_ri%21%0D%0A";
}
}

if ( empty($error) ){
$tsql = "UPDATE verniz
SET
verniz_name = '".$_POST['verniz_name']."',
verniz_description = '".$_POST['verniz_description']."',
verniz_supplier = '".$_POST['verniz_supplier']."',
verniz_RI_verniz = '".$_POST['verniz_ri_verniz']."',
verniz_RI_IPL = '".$_POST['verniz_ri_ipl']."'
WHERE
verniz_id = '".$_GET['id']."'
";

} else {
header(
"location:verniz.php?action=edit&error=".$error."&id=".$_GET['id'] );
}
break;

// -----------------------------------End of Edit Verniz-------------------------------------------


//-------------------------------- Parameters -------------------------------------------------
case "parameters":
$parameters_integrationtime = $_POST['parameters_integrationtime'];
if( !is_numeric($parameters_integrationtime)){$error .= "Please+enter+a+numeric+number+for+the+integrationtime%21%0D%0A";}
else {
if ( $parameters_integrationtime < $minintegrationtime || $parameters_integrationtime > $maxintegrationtime ){
$error .= "Please+enter+a+number+of+integrationtime+between+$minintegrationtime+and+$maxintegrationtime%21%0D%0A";
}
}
$parameters_average = $_POST['parameters_average'];
if (!is_numeric($parameters_average)){
$error .= "Please+enter+a+numeric+number+of+averages%21%0D%0A";
} else {
if ( $parameters_average < 1 || $parameters_average > $maxnumber_of_average ){
$error .= "Please+enter+a+number+of+averages+between+1+and+$maxnumber_of_average%21%0D%0A";
}
}
$parameters_maxpeaksnumber = trim($_POST['parameters_maxpeaksnumber']);
if ( !is_numeric ( $parameters_maxpeaksnumber )){
$error .= "Please+enter+a+numeric+number+for+the+number+of+layers%21%0D%0A";
} else {
if ( $parameters_maxpeaksnumber < 1 || $parameters_maxpeaksnumber >= $maxpeaks ){
$error .= "Please+enter+a+number+of+layers+between+1+and+$maxpeaks%21%0D%0A";
}
} 
$parameters_minthickness = trim($_POST['parameters_minthickness']);
if ( !is_numeric ( $parameters_minthickness )){
$error .= "Please+enter+a+numeric+number+for+the+Start+of+FFT+Graph%21%0D%0A";
} else {
if ( $parameters_minthickness < $min_fft || $parameters_minthickness >= $max_fft ){
$error .= "Please+enter+a+number+for+the+Start+of+FFT+Graph+between+$min_fft+and+$max_fft%21%0D%0A";
}
}
$parameters_maxthickness = trim($_POST['parameters_maxthickness']);
if ( !is_numeric ( $parameters_maxthickness )){
$error .= "Please+enter+a+numeric+number+for+the+End+of+FFT+Graph%21%0D%0A";
} else {
if ( $parameters_maxthickness <= $min_fft || $parameters_maxthickness >= $max_fft ){
$error .= "Please+enter+a+number+for+the+End+of+FFT+Graph+between+$min_fft+and+$max_fft%21%0D%0A";
}
}
if ( $parameters_maxthickness <=  $parameters_minthickness ){
$error .= "Please+enter+a+number+for+the+End+of+FFT+Graph+higher+than+for+the+Start+of+FFT+Graph%21%0D%0A";
}
$parameters_maxnoise = trim($_POST['parameters_maxnoise']);
if ( !is_numeric ( $parameters_maxnoise )){
$error .= "Please+enter+a+numeric+number+for+the+Signal+/+Noise+ratio%21%0D%0A";
} else {
if ( $parameters_maxnoise < $minnoise || $parameters_maxnoise >= $maxnoise ){
$error .= "Please+enter+a+number+for+the+Signal+/+Noise+ratio+between+$minnoise+and+$maxnoise%21%0D%0A";
}
} 

if ( empty($error) ){
$tsql = "UPDATE
parameters
SET
parameters_userid = '".$_SESSION['userid']."',
parameters_integrationtime = '".$_POST['parameters_integrationtime']."',
parameters_average = '".$_POST['parameters_average']."',
parameters_maxpeaksnumber = '".$_POST['parameters_maxpeaksnumber']."',
parameters_minthickness = '".$_POST['parameters_minthickness']."',
parameters_maxthickness = '".$_POST['parameters_maxthickness']."',
parameters_maxnoise = '".$_POST['parameters_maxnoise']."'
WHERE
parameters_id = '".$_GET['id']."'
";

} else {
header(
"location:parameters.php?action=edit&error=".$error."&id=".$_GET['id'] );
}
break;
}
break;

// -------------------------------------- End Edit ----------------------------------------------
case "add":
switch( $_GET['type'] ){
case "user":
$user_name = trim($_POST['user_name']);
if( empty($user_name)){$error .= "Please+enter+a+user+name%21%0D%0A";}

//$user_type = trim($_POST['user_type']);
$user_pwd = trim($_POST['user_pwd']);
if( empty($user_pwd)){$error .= "Please+enter+a+password%21%0D%0A";}

$tsql = "INSERT INTO
users
( user_name,
  user_pwd,
  user_is_online,
  user_type )
VALUES
( '".$_POST['user_name']."' ,
   '".$_POST['user_pwd']."' ,
   '0',
   '".$_POST['user_type']."' 
)
";
break;

case "item":
$item_name = $_POST['item_name'];
if( empty($item_name)){$error .= "Please+enter+a+item+name%21%0D%0A";}

if (empty($_POST['item_description'])){
$error .= "Please+select+a+item+description%21%0D%0A";}

$item_number_of_checkpoints = trim($_POST['item_number_of_checkpoints']);
if ( !is_numeric ( $item_number_of_checkpoints )){
$error .= "Please+enter+a+numeric+number+of+checkpoints+%21%0D%0A";
} else {
if ( $item_number_of_checkpoints < 1 || $item_number_of_checkpoints > $maxnumber_of_checkpoints ){
$error .= "Please+enter+a+number+of+checkpoints+between+1+and+$maxnumber_of_checkpoints%21%0D%0A";
}
}
$item_low_ipl = trim($_POST['item_low_ipl']);
if ( !is_numeric ( $item_low_ipl )){
$error .= "Please+enter+a+numeric+number+for+the+Low+IPL+Warning%21%0D%0A";
} else {
if ( $item_low_ipl < 0 || $item_low_ipl >= $max_ipl ){
$error .= "Please+enter+a+number+for+the+Low+IPL+Warning+between+0+and+$max_ipl%21%0D%0A";
}
}
$item_high_ipl = trim($_POST['item_high_ipl']);
if ( !is_numeric ( $item_high_ipl )){
$error .= "Please+enter+a+numeric+number+for+the+High+IPL+Warning%21%0D%0A";
} else {
if ( $item_high_ipl < 0 || $item_high_ipl >= $max_ipl ){
$error .= "Please+enter+a+number+for+the+High+IPL+Warning+between+0+and+$max_ipl%21%0D%0A";
}
} 
$item_low_verniz = trim($_POST['item_low_verniz']);
if ( !is_numeric ( $item_low_verniz )){
$error .= "Please+enter+a+numeric+number+for+the+low+verniz%21%0D%0A";
} else {
if ( $item_low_verniz < 0 || $item_low_verniz >= $max_verniz ){
$error .= "Please+enter+a+number+for+the+verniz+between+0+and+$max_verniz%21%0D%0A";
}
}
$item_high_verniz = trim($_POST['item_high_verniz']);
if ( !is_numeric ( $item_high_verniz )){
$error .= "Please+enter+a+numeric+number+for+the+High+Verniz+Warning%21%0D%0A";
} else {
if ( $item_high_verniz < 0 || $item_high_verniz >= $max_verniz ){
$error .= "Please+enter+a+number+for+the+High+Verniz+Warning+between+0+and+$max_verniz%21%0D%0A";
}
} 
$item_minlambda = trim($_POST['item_minlambda']);
if ( !is_numeric ( $item_minlambda )){
$error .= "Please+enter+a+numeric+number+of+Lambda+min+%21%0D%0A";
} else {
if ( $item_minlambda < $minlambda || $item_minlambda > $maxlambda ){
$error .= "Please+enter+a+number+of+Lambda+min+between+$minlambda+and+$maxlambda%21%0D%0A";
}
}
$item_maxlambda = trim($_POST['item_maxlambda']);
if ( !is_numeric ( $item_maxlambda )){
$error .= "Please+enter+a+numeric+number+of+Lambda+max+%21%0D%0A";
} else {
if ( $item_maxlambda < $minlambda || $item_maxlambda > $maxlambda ){
$error .= "Please+enter+a+number+of+Lambda+max+between+$minlambda+and+$maxlambda%21%0D%0A";
}
}
if ( $item_maxlambda <= $item_minlambda ){
$error .= "Lambda+max+is+smaller+or+equal+to+Lambda+min%21%0D%0A";
}
 
if ( empty($error) ){
$tsql = "INSERT INTO
item
( item_name ,
item_description ,
item_number_of_checkpoints,
item_low_ipl,
item_high_ipl ,
item_low_verniz,
item_high_verniz,
item_minlambda,
item_maxlambda )
VALUES
( '".$_POST['item_name']."' ,
'".$_POST['item_description']."' ,
'".$_POST['item_number_of_checkpoints']."' ,
'".$_POST['item_low_ipl']."' ,
'".$_POST['item_high_ipl']."' ,
'".$_POST['item_low_verniz']."' ,
'".$_POST['item_high_verniz']."',
'".$_POST['item_minlambda']."',
'".$_POST['item_maxlambda']."')
";
} else {
header(
"location:item.php?action=edit&error=".$error."&id=".$_GET['id'] );}
break;

case "verniz":
$verniz_name = trim($_POST['verniz_name']);
if( empty($verniz_name)){$error .= "Please+enter+a+lacquer+name%21%0D%0A";}

$verniz_description = trim($_POST['verniz_description']);
if (empty($verniz_description)){$error .= "Please+enter+a+lacquer+description%21%0D%0A";}

$verniz_supplier = trim( $_POST['verniz_supplier'] );
if (empty ( $verniz_supplier)){$error .= "Please+enter+a+lacquer+supplier%21%0D%0A"; }

$verniz_ri_verniz = trim($_POST['verniz_ri_verniz']);
if ( !is_numeric ( $verniz_ri_verniz )){
$error .= "Please+enter+a+numeric+number+for+the+lacquer+RI%21%0D%0A";
} else {
if ( $verniz_ri_verniz < 1 || $verniz_ri_verniz >= $max_verniz_ri ){
$error .= "Please+enter+a+number+for+the+lacquer+RI+between+1+and+$max_veniz_ri%21%0D%0A";
}
}
$verniz_ri_ipl = trim($_POST['verniz_ri_ipl']);
if ( !is_numeric ( $verniz_ri_ipl )){
$error .= "Please+enter+a+numeric+number+for+the+IPL+RI%21%0D%0A";
} else {
if ( $verniz_ri_ipl < 1 || $verniz_ri_ipl >= $max_ipl_ri ){
$error .= "Please+enter+a+number+for+the+IPL+RI+between+1+and+$max_ipl_ri%21%0D%0A";
}
}
if ( empty($error) ){
$tsql = "INSERT INTO
		verniz
				(verniz_name,  
				verniz_description,
				verniz_supplier,
				verniz_ri_verniz,
				verniz_ri_ipl) 
		VALUES
				('$verniz_name',
 				'$verniz_description',
 				'$verniz_supplier',
				'$verniz_ri_verniz',
				'$verniz_ri_ipl')
		";
} else {
header(
"location:verniz.php?action=edit&error=".$error."&id=".$_GET['id'] );}
}
break;
}

if ( isset($tsql) && !empty($tsql)){
echo "<!�".$tsql."�>";
$stmt = sqlsrv_query( $conn,  $tsql ) or die("Invalid query!");
if ($debugmode <> '0') {debugDisplay();}
?>
<p align="center" style="color:#FF0000">
Done. <a href="admin.php">Administration</a> </br></p>
<p align="center" style="color:#000000">
<a href="logout.php">Logout...</a> 
</p>
<?php
}
}
?>