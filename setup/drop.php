<?php

/**
 * Open a connection via PDO to create a
 * new database and table with structure.
 *
 */

require "config.php";

try {
    $connection = new PDO("mysql:host=$host", $username, $password, $options);
	$connection->exec("DROP DATABASE GMS");
	echo "<script> alertify.success('Baza de date si tabele sterse cu succes.'); </script>";
} catch(PDOException $error) {
    echo $error->getMessage();
	echo "<script> alertify.error('Database could not be dropped. See the above error message'); </script>";
}
?>