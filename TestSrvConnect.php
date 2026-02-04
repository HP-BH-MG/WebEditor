<?php
// include "config.php";
$sqlexpress = '1';
$host = gethostbyaddr($_SERVER['SERVER_ADDR']);
$ip = gethostbyname($host);
if ($sqlexpress == "1") {$serverName = $host."\SQLEXPRESS22";}
	else {$serverName = $host;}

 $user = 'procoat';
$pw = 'tla';
$db = 'prado';

echo "Server Name: ", $serverName. " IP: ".$ip." Database: ".$db. "<br />";


//$serverName = "EINSTEIN\SQLEXPRESS22"; //serverName\instanceName
//$connectionInfo = array( "Database"=>"Braslux22", "UID"=>"procoat", "PWD"=>"tla");
$connectionInfo = array( "Database"=>$db, "UID"=>$user, "PWD"=>$pw);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}

// SQL Query

$tsql = "select * from users";

$stmt = sqlsrv_query($conn, $tsql);

if ($stmt == false) {
	echo 'Error';
}
while($obj = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
echo $obj['user_name'].", ".$obj['user_pwd']. "</br>";}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
