<?php
require_once "config.php";
require_once "conn.inc.php";
require_once "functions.php";
// session_start();
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
<html>
<head>
<title>ProCoat - Thin Layer Analyzing System</title>
</head>

<body>
<h1>Thank's for using ProCoat!</h1>
<?php
if (!isset($_SESSION['user_logged'])) {
    echo "You are not logged in. <a href='index.php'>Click here</a> to return to the login page.";
    exit();
}
$userid = $_SESSION['userid'];
$user_name = $_SESSION['user_logged'];
$login_time = $_SESSION['login_time'];
$logout_time = date("Y-m-d H:i:s");
$user_host = get_host_name();
$user_ip = get_server_ip($user_host);

echo "User: ".$user_name. " Login: ".$login_time. " Logout:  ". $logout_time. " UserIP:  ".$user_ip. " Hostname:  ".$user_host ;

$logout = "INSERT INTO userlog (userlog_user_id, userlog_login,userlog_logout, userlog_user_IP, userlog_user_host) 
		VALUES ('$userid', '$login_time','$logout_time', '$user_ip', '$user_host')";
$stmt = sqlsrv_query($conn, $logout) or die("Error inserting logout parameters.");

// Schritt 1: Alle Session-Variablen löschen
$_SESSION = array();

// Schritt 2: Session-Cookie löschen (wichtig für Sicherheit!)
if (isset($_COOKIE[session_name()])) {
    setcookie(
        session_name(),      // Session-Cookie-Name (meist PHPSESSID)
        '',                  // Leerer Wert
        time() - 3600,       // Verfallsdatum in der Vergangenheit
        '/'                  // Pfad
    );
}

// Schritt 3: Session zerstören
session_unset();
session_destroy();

?>

<p>You may now <a href="unlogged_user.php">click here</a>
to return to the login page.</p>


</body>
</html>
