<?php
require_once (__DIR__ . '/../templates/BasePage.php');
require_once (__DIR__ . '/../setup/db_connect.php');
require_once "helpers/session.php";

class ResetPassPage extends BasePage {
  
    function render() {
        self::renderHeader();
        $this->renderContent();   
        self::renderFooter();
    }

    function renderContent() {
       include "resetpasspagecontent.html";
       include "helpers/reset.php";
    }

}
?>