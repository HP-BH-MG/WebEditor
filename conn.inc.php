<?php
include "config.php";
$host = gethostbyaddr($_SERVER['SERVER_ADDR']);
$ip = gethostbyname($host);
if ($sqlexpress == "1") {$serverName = $host."\SQLEXPRESS22";}
	else {$serverName = $host;}

 echo "SQL Server Name: ", $serverName."<br />";

 /*
$user = 'procoat';
$pw = 'tla';
$db = 'Braslux22';
Edit below to your database login info in config.php
*/

//$serverName = "EINSTEIN\SQLEXPRESS22"; //serverName\instanceName
//$connectionInfo = array( "Database"=>"Braslux22", "UID"=>"procoat", "PWD"=>"tla");
$connectionInfo = array( "Database"=>$db, "UID"=>$user, "PWD"=>$pw);
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
     echo "Database: ", $db, "<br />";
     echo "Connection established.<br />";
}else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
?>
