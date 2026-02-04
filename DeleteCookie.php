<?php
echo "Check if the cookie exists";
print_r($_COOKIE);
if (isset($_COOKIE['PHPSESSID'])) {
   // Unset the cookie value in PHP
   unset($_COOKIE['PHPSESSID']);
   // Set the cookie with an expiration time in the past
   setcookie('user', '', time() - 3600, '/');
   echo "Cookie 'PHPSESSID' has been deleted.";
} else {
   echo "Cookie 'PHPSESSID' does not exist.";
}
?>