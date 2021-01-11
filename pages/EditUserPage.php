<?php
require_once (__DIR__ . '/../templates/BasePage.php');
require_once (__DIR__ . '/../setup/db_connect.php');
require_once "helpers/session.php";
require_once "helpers/update_userpage_content_into_db.php";
require_once "helpers/uploadUserProfilePhoto.php";

class EditUserPage extends BasePage {
    private $userFirstName = '';
    private $userLastName = '';
    private $userImage = '';
	private $userUserName = '';
	private $userId = '';

    function render() {
        $this->fetchDbContent();
        self::renderHeader();
        $this->renderContent();
        self::renderFooter();
    }

    function renderContent() {
       include "edituserpagecontent.html";
    }

    //Returns user details from the DB
    function fetchDbContent() {
        if (isLoggedIn()) {
            $userId = (int)$_GET["id"];

            $sql = "SELECT * FROM user WHERE id='$userId'";
            global $connection;
            $result = $connection->query($sql);
    
            //Mesaje pentru client la logare
            if($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $this->userFirstName = $row['firstname'];
                $this->userLastName = $row['lastname'];
				$this->userUserName = $row['username'];
				$this->userId = $row['id'];
                $imageContent = $row["image"];
                if (!empty($imageContent)) {
                    $this->userImage = 'data:image/jpeg;base64,'. base64_encode($imageContent); 
                }
            } else {
                $this->userImage = "No Content";
            }
        }
    }
//function wich shows the last status from a user session
    function getLastSaveStatus() {
        $status = isset($_SESSION["saveUserStatus"]) ? $_SESSION["saveUserStatus"] : '';
        $_SESSION["saveUserStatus"] = '';
        return $status;
    }

    function hasError() {
        return isset($_SESSION["saveUserError"]) ? $_SESSION["saveUserError"] : false;
    }
}