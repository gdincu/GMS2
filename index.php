<?php
    require_once "setup/db_connect.php";
    require_once "pages/helpers/access.php";
    
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    $requestedPage = ucwords($page) . 'Page';
    $pageLocation = 'pages/'. $page . 'Page.php';

    if (file_exists($pageLocation)) {
        require_once $pageLocation;
        $currentPage = new $requestedPage;
        $currentPage->renderHead();
        $currentPage->startBody();
        $currentPage->render();
        $currentPage->endBody();
        } 
        else 
        {
        require_once (__DIR__."/pages/ErrorPage.php");
        $currentPage = new ErrorPage();
        $currentPage->render();
        }
?>