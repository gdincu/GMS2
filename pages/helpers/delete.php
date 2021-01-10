<?php 
/**
 * If not logged in - re-directs to index.php
 */
if(!isset($_SESSION["user"]))
header("Location: index.php");

include (__DIR__ . '/../../setup/db_connect.php');

if (isset($_POST['btnSubmit'])) {

$userFinal = "'" . $_SESSION["user"] . "'";
$sql = "DELETE FROM user WHERE username = $userFinal";
$connection->query($sql);

//Re-directs to the sign-up page
session_destroy();
header("Location: index.php");
exit;
}
?>