<?php

function getError($param) {
    $result = "valueok";
    $errorArray = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
    if ($errorArray != null && isset($errorArray[$param])) {
        $result = $errorArray[$param] == "" ? "valueok" : "valuenok";
    }
    echo $result; 
}

/**
 * If the data enetered in the SignUp form fields are not valid, an Error Message is displayed.
 * The error message will be displayed below every form field.
 */
function getErrorMessage($param) {
    $result = "";
    $errorArray = isset($_SESSION["error"]) ? $_SESSION["error"] : null;
    if ($errorArray != null && isset($errorArray[$param])) {
        $result = $errorArray[$param];
    }
    echo $result;
}


function getPost($param) {
	if (isset($_POST[$param])) {
		echo $_POST[$param];
	}
}

function getChecked($param, $value) {
    $checked = isset($_POST[$param]) && $_POST[$param] == $value;
    echo $checked ? 'checked' : '';
}

/**
 * Validation of sign up form fields.
 * Save the user into the db. 
 */
function saveUser() {
    require_once("validate_signup_form_fields.php");
  
    $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $password = isset($_POST["password"])
        ? hash("sha256", htmlentities($_POST["password"],ENT_HTML5,'UTF-8',TRUE))
        : "";

    $errorArray = array();
    $error = false;
    $errorMessage = "";

    $errorMessage = validate_username($username);
    if ($errorMessage != "") {
        $errorArray['username'] = $errorMessage;
        $error = true;
    }

    $errorMessage = validate_firstname($firstname);
    if ($errorMessage != "") {
        $errorArray['firstname'] = $errorMessage;
        $error = true;
    }
    $errorMessage = validate_lastname($lastname);
    if ($errorMessage != "") {
        $errorArray['lastname'] = $errorMessage;
        $error = true;
    }
    $errorMessage = validate_password($_POST["password"]);
    if ($errorMessage != "") {
        $errorArray['password'] = $errorMessage;
        $error = true;
    }

    $_SESSION["error"] = $errorArray;
    if ($error) {
        //echo 'Not saved to database. Please check for errors.</br>';
        return false;
    }

    // Create connection
    require (__DIR__ . '/../../setup/db_connect.php');

    $success = true;

    try {
        $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // prepare statement
        $sql = 'INSERT INTO user(username, firstname, lastname, password) VALUES(:1, :2, :3, :4)';
        $stmt = $conn->prepare($sql);

        // bind parameters
        $stmt->bindParam(":1", $username, PDO::PARAM_STR);
        $stmt->bindParam(":2", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":3", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":4", $password, PDO::PARAM_STR);

        // execute
        $stmt->execute();
    }
    catch(PDOException $e) {
        //echo "Error: " . $e->getMessage();
        $_SESSION["error"]['username'] = "User already exists.";
        $success = false;
    }

    // Close connection -- $conn = null;
    $conn = null;

    return $success;
}

/**
 * Saving user details
 */
if(isset($_POST["savedata"])) {
    $success = saveUser();
    
    if($success) {
        //echo 'User saved to database.<br>';
        //sleep(3);
        $userFinal = "'".htmlentities($_POST["username"],ENT_HTML5,'UTF-8',TRUE)."'";
        $passwordFinal =  "'".hash("sha256", htmlentities($_POST["password"],ENT_HTML5,'UTF-8',TRUE))."'";
        $sql = "SELECT id, username,password FROM user WHERE username=$userFinal";
        $connection = mysqli_connect("localhost","root","","playversity");
        $result = $connection->query($sql);
        
        if($row = $result->fetch_assoc()) {
            $_SESSION["user"] = $row["username"];
            $_SESSION["password"] = $row["password"];
            $_SESSION["userid"] = $row["id"];

            header("Location: index.php?page=user");
        }
    } else {
        //die;
        //header("Location: index.php");
    }

    
}
?>