<?php
require_once (__DIR__ . '/../templates/BasePage.php');

class PlaylistEditPage extends BasePage {
    function render() {
        self::renderHeader();
        $this->continut();//self::renderContent();
        self::renderFooter();
    }

    function continut() {
        include "pages/helpers/song.php";
    }
}