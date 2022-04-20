<?php
define('DB_SERVER', 'db');
define('DB_USERNAME', 'user');
define('DB_PASSWORD', 'PASSWORD_test');
define('DB_NAME', 'myDb');
 
$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if ($link->connect_error) {
    die("連接失敗: " . $link->connect_error);
}
?>
