<?php 

global $dbservername, $dbusername, $dbpassword, $dbname;

$dbservername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "gms";
$dsn        = "mysql:host=$dbservername;dbname=$dbname";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

//DB connection
// require_once('config.php');
global $connection;
$connection = mysqli_connect($dbservername,$dbusername,$dbpassword,$dbname);

//Verificarea conexiunii
if(!$connection)
    die ("Connection failed!");

?>