<?php

require_once (__DIR__ . '/../templates/BasePage_setup.php');

class SetupPage extends BasePage_setup {
    
    public function render() {
        $this->renderHeader();
        $this->renderContent();
        self::renderFooter();
    }

    function renderHeader() {
        include "homeheader.html";
    }

    function renderContent() {
        include "setupcontent.html";

        // use the data only once
        unset($_SESSION["error"]);
    }
}

?>