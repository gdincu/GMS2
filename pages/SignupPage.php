<?php
require_once (__DIR__ . '/../templates/BasePage.php');
// require_once (__DIR__ . '/../setup/db_connect.php');
require_once "helpers/session.php";

class SignupPage extends BasePage {
  
  private $firstname;
    private $lastname;
    private $username;
    private $password;
  
    function render() {
        self::renderHeader();
		include "helpers/save_user_into_db.php";
        $this->renderContent();   
        self::renderFooter();
    }

    function renderContent() {
       include "signupcontent.html";
    }

}
?>