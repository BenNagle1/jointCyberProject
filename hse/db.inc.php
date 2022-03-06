<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'HSE');
 

$db = mysqli_connect('localhost', 'root', '', 'hse');
 
if($db === false){
    die("Unable to connect" . mysqli_connect_error());
}
?>