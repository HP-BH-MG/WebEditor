<?php
// Constants for config.php
$debugmode = '0'; // 0 = off, 1 = on
$sqlexpress = '0'; // 0 = MSSQL, 1 = SQLEXPRESS
$maxnumber_of_checkpoints = '6';
$min_ipl = '0';
$max_ipl = '10';
$min_verniz = '4';
$max_verniz = '20';
$minintegrationtime = '3';
$maxintegrationtime = '200';
$maxnumber_of_average = '100';
$minlambda = '350';
$maxlambda = '1000';
$maxpeaks = '5';
$min_fft = '0';
$max_fft = '100';
$minnoise = '5';
$maxnoise = '80';
$max_verniz_ri = 4;
$max_ipl_ri = 4;

$user = 'procoat';   // Name for database user procoat
$pw = 'tla';        // Password for databse user i.e tla
$db = 'arteb'; // Database name i.e procoat. Change this to the name of your database

// NEU (Zeile 2):
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}  // ✅

?>