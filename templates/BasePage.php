<?php

class BasePage {
    // called from index
    function renderHead() {
        include "head.html";
    }

    // called from index
    function startBody() {
        echo '<body id="page-top">';
    }

    // base implementation for header
    protected function renderHeader() {
        include "templateheader.php";
    }

    // base implementation for content
    protected function renderContent() {
        echo '<div>This page is empty</div>';
    }

    // base implementation for footer
    protected function renderFooter() {
        include "templatefooter.php";
    }

    // called from index
    function endBody() {
        echo '</body></html>';
    }

    // function to be replaced in each page
    function render() {
        self::renderHeader();
        self::renderContent();
        self::renderFooter();
    }
}