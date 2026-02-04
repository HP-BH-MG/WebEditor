<?php
require_once "config.php";
require_once "conn.inc.php";
require_once "functions.php";
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
$_SERVER
<?php
print_r($_SERVER);
?>
</PRE>
<?php
}

if ($debugmode <> '0') {debugDisplay();}
if (isset($_POST['submit']))
	{
	$tsql = "SELECT user_id, user_name, user_pwd, user_type FROM users WHERE user_name = '" .$_POST['username'] . "' AND user_pwd = '" . $_POST['password']. "' ";
	$params = array();
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$stmt = sqlsrv_query( $conn, $tsql , $params, $options );
	$row_count = sqlsrv_num_rows( $stmt );

		if (($row_count == false) && ($debugmode <> '0')) echo "Row Count = ".$row_count."</br>";

	if ($row_count == 1)
		{
		if ($debugmode <> '0') echo "immer noch do!"."</br>";
		$_SESSION['user_logged'] = $_POST['username'];
		$_SESSION['user_password'] = $_POST['password'];
		$row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
		$userid = $row['user_id'];
		$_SESSION['userid'] = $userid;
		$_SESSION['usertype'] = $row['user_type'];
		$user_host = get_host_name();
		$user_ip = get_server_ip($user_host);
		$_SESSION['user_ip'] = $user_ip;
		$_SESSION['user_host'] = $user_host;
		$login_time = date("Y-m-d H:i:s");
		$_SESSION['login_time'] = $login_time;
		if ($debugmode <> '0') 	echo "UserIP: ".$user_ip. " </br>";
		$redirect = 'logged_user.php';
		$_POST['redirect'] = $redirect;
		echo "Redirecting to: ".$_POST['redirect']."</br>";
		
		/*$login = "INSERT INTO userlog (userlog_user_id, userlog_login, userlog_user_IP,userlog_user_host) 
					VALUES ('$userid', '$login_time', '$user_ip', '$user_host')";
		$stmt = sqlsrv_query($conn,$login) or die();
		echo "UserID: ".$userid." LoginTime: ".$login_time, "</br>"; */
		//redirect_to($redirect);
		header ("Location:  $redirect");
		header ("Refresh: 5; URL=" . $_POST['redirect'] . "");
		echo "You are being redirected to your original page request!<br>";
		echo "(If your browser doesn't support this, <a href=\"" .$_POST['redirect']. "\">click here</a>)"; 
		}
	else
		{
		?>
		<html>
		<head>
		<title>ProCoat - Thin Layer Analyzing System</title>
		</head>
		<body>
		Invalid Username and/or Password<br>
		Please, enter a valid Username and Password.<br>
		<form action="user_login.php" method="post">
			<input type="hidden" name="redirect" value="<?php echo $_POST['redirect'];?>">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br><br>
			<input type="submit" name="submit" value="Login">
		</form>
		<?php
		}
	}	
else
	{
	if ($_SERVER['HTTP_REFERER'] == "" || $_SERVER['HTTP_REFERER'] == "http://localhost/procoat/unlogged_user.php")
		{ $redirect = "unlogged_user.php";
		header ("Location:  $redirect");
		if ($debugmode <> '0') {debugDisplay();}
		}
	else
		{ $redirect = "unlogged_user.php"; 
		?>   
		<html>
		<head>
		<title>ProCoat - Thin Layer Analyzing System</title>
		</head>
		<body>
		<p>Login below with your username and password...</p>
		<form action="user_login.php" method="post">
			<input type="hidden" name="redirect" value="<? echo $redirect; ?>">
			Username: <input type="text" name="username"><br>
			Password: <input type="password" name="password"><br><br>
			<input type="submit" name="submit" value="Login">
		</form>
		</body>
		</html>
		<?php
		}
	}
?>

