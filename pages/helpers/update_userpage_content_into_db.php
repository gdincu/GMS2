<?php

/**
 * Validation of sign up form fields.
 * Save the user into the db. 
 */
function updateUserPageContent() {
    require_once("validate_userpage_form_fields.php");
  
    $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";

    $errorArray = array();
    $error = false;
    $errorMessage = "";

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

    $_SESSION["saveUserStatus"] = implode("\n", $errorArray);
    if ($error) {
        $_SESSION["saveUserError"] = true;
        return false;
    }

    $success = true;

    $currentUser = getLoggedInUser();

    try {
        global $dbservername, $dbname, $dbusername, $dbpassword;
        $conn = new PDO("mysql:host=$dbservername;dbname=$dbname", $dbusername, $dbpassword);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // prepare statement
        $sql = 'UPDATE user SET firstname=:1, lastname=:2  WHERE username=:3';
        $stmt = $conn->prepare($sql);

        // bind parameters
        $stmt->bindParam(":1", $firstname, PDO::PARAM_STR);
        $stmt->bindParam(":2", $lastname, PDO::PARAM_STR);
        $stmt->bindParam(":3", $currentUser, PDO::PARAM_STR);

        // execute
        $stmt->execute();
    }
    catch(PDOException $e) {
        $_SESSION["saveUserStatus"] = "Error: " . $e->getMessage();
        $_SESSION["saveUserError"] = true;
        $success = false;
    }

    $conn = null;

    if ($success) {
        $_SESSION["saveUserError"] = false;
        $_SESSION["saveUserStatus"] = 'User ' . $currentUser . ' updated into database.';
    } else {
        die();
    }

    return $success;
}

if(isset($_POST["saveChanges"])) {
    updateUserPageContent();
}
?>