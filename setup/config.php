<?php 

global $dbservername, $dbusername, $dbpassword, $dbname, $options;

$host = "localhost";
$username = "root";
$password = "";
$dbname = "gms";
$dsn        = "mysql:host=$dbservername;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
			  

?>

