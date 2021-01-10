<?php
require_once (__DIR__ . '/../templates/BasePage.php');

class ErrorPage extends BasePage {
    function render() {
        self::renderHead();
        self::startBody();

        self::renderHeader();
        echo '<div>Page not found</div>';
        self::renderFooter();
        
        self::endBody();
    }
}