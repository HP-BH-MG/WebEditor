<?php
include "config.php";
function get_server_name($sqlexpress){
    $host = gethostbyaddr($_SERVER['SERVER_ADDR']);
    if ($sqlexpress == "1") {$serverName = $host."\SQLEXPRESS22";}
	else {$serverName = $host;}
    return $serverName;}

function get_host_name(){
    $host = gethostbyaddr($_SERVER['SERVER_ADDR']);
    echo "Local Host: ", $host."<br />";
    $host_remote = gethostbyaddr($_SERVER['REMOTE_ADDR']);
    echo "Remote Host: ", $host_remote."<br />";
    if ($host !== $host_remote) { 
        $host = $host_remote;
    }
    return $host;
}

function get_server_ip($host){
        $ip_server = gethostbyname($host);
        $ip_remote = $_SERVER['REMOTE_ADDR'];
        if ($ip_remote == "::1") {$ip_remote = $ip_server;}
        else { $ip_server = $ip_remote; }
    return $ip_server;}

$host = get_host_name();
$serverName = get_server_name($sqlexpress);
$ip_server = get_server_ip($host);


 echo "SQL Host: ", $host."<br />";
 echo "SQL Server Name: ", $serverName."<br />";
 echo "SQL Server IP: ", $ip_server."<br />";
 
 
?>