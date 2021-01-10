<?php
require_once (__DIR__ . '/../templates/BasePage.php');
require_once (__DIR__ . '/../setup/db_connect.php');
require_once "helpers/session.php";

//functioin for deleting an account using the delete function from a different file

class DeleteAccountPage extends BasePage {
  
    function render() {
        self::renderHeader();
        $this->renderContent();   
        self::renderFooter();
    }

    function renderContent() {
       include "deleteaccountpagecontent.html";
       include "helpers/delete.php";
    }

}
?>