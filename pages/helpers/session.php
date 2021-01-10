<?php

/**
 * Checks if the user is already logged in
 */
function isLoggedIn() {
    return isset($_SESSION["user"]);
}

/**
 * Returns the logged in user
 */
function getLoggedInUser() {
    $user = null;
    if (isLoggedIn()) {
        $user = $_SESSION["user"];
    }
    return $user;
}

/**
 * Returns the id of the logged in user
 */
function getLoggedInUserId() {
    $userId = 0;
    if (isLoggedIn()) {
        $userId = $_SESSION["userid"];
    }
    return $userId;
}

/**
 * Stores user details to the login session
 */
function storeUserToSession($userFinal,$passwordFinal, $userId) {
    //Session management.
    $_SESSION["user"] = $userFinal;
    $_SESSION["password"] = $passwordFinal;
    $_SESSION["userid"] = $userId;
}

session_start();
?>