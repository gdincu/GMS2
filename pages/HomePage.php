<?php

require_once (__DIR__ . '/../templates/BasePage.php');

//require_once(__DIR__ . '/../setup/db_connect.php');

class HomePage extends BasePage {

    private $firstname;
    private $lastname;
    private $username;
    private $password;
    
    public function render() {
        $this->renderHeader();
        require_once (__DIR__ . '/helpers/save_user_into_db.php');
        $this->renderContent();
        self::renderFooter();
    }

    function renderHeader() {
        include "homeheader.html";
    }

    function renderContent() {
        include "homecontent.html";

        // use the data only once
        unset($_SESSION["error"]);
    }
}