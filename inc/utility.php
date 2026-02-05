<?php 

    require_once 'inc/config.php';
    function get_server_name(): string {
        $host = gethostbyaddr($_SERVER['SERVER_ADDR']);
        $ip = gethostbyname($host);
        if (SQLEXPRESS == "1") {$serverName = $host."\SQLEXPRESS22";}
	    else {$serverName = $host;}
        echo "Server Name: ", $serverName."<br />";
        return $serverName;
    }
function connect_server (): void {  
    $serverName = get_server_name();
    $connectionInfo = array( "Database"=>DB_NAME, "UID"=>DB_USER, "PWD"=>DB_PASS);
    $conn = sqlsrv_connect( $serverName, $connectionInfo);
     
    if( $conn ) {
        echo "Connection established.<br />";
    }else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
    }
}

    function  output ($value = 'Ausgabe'):void {
    echo '<pre>';
    print_r(value: $value);
     echo '<pre>';
    }

    function autenticate_user3(string $email, string $password): bool {
        $valid_users = [
            [
                'email' => ADMIN_EMAIL,
                'password' => ADMIN_PASSWORD
            ]
        ];

        foreach ($valid_users as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                return true;
            }
        }

        return false;
    }

    function autenticate2_user(string $email, string $password): bool {
        return $email === ADMIN_EMAIL && password_verify($password, ADMIN_PASSWORD);
    }

    function autenticate_user(string $username, string $password): bool {
        if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
            return true;
        }
        else
        { return false; }
    }
    function redirect_to(string $url): void {
        header("Location: $url");
        die();
    }
    function ensure_user_is_autenticated(): void {
        if (!is_user_autenticated()) {
            redirect_to('login.php'); }
    } 

    function is_user_autenticated(): bool {
        echo "Session User: ".isset($_SESSION['username'])."<br>";
        return isset($_SESSION['username']) && isset($_SESSION['password']);
    }