<?php
//Connecting to the DB using a generic login
require_once (__DIR__ . '/../../setup/db_connect.php');
require_once "session.php";

if (isset($_POST["access"])) {	
	
	if(isLoggedIn()) {
		session_destroy();
		header("Location: index.php");
		exit;
	}

	//Mesaje pentru client la logare
	//Avoiding SQL injections by using "'" and sanitising variables
	$userFinal = "'".htmlentities($_POST["username"],ENT_HTML5,'UTF-8',TRUE)."'";
    $passwordFinal =  "'".hash("sha256", htmlentities($_POST["password"],ENT_HTML5,'UTF-8',TRUE))."'";
	
	$sql = "SELECT id, username,password FROM user WHERE username=$userFinal";
	$result = $connection->query($sql);
	
	//Mesaje pentru client la logare
	if($result->num_rows == 0) {
		header("Location: index.php?page=home&error=InvalidUserorPassword");
		exit;
	}
	
	if($result->num_rows == 1) {
		while($row = $result->fetch_assoc()) {
			$usercheck = $row["username"];
            $passcheck = $row["password"];
            $id = $row["id"];
			
			//Mesaje pentru client la logare
			if("'".$usercheck."'" === $userFinal && "'".$passcheck."'" != $passwordFinal) {
				header("Location: index.php?page=home&error=InvalidPassword");
				exit;
			}
			
            storeUserToSession($usercheck, $passcheck, $id);
            header("Location: index.php?page=user");
        }
    }
}

?>