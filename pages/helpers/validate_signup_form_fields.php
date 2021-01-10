<?php

//validate username
function validate_username($username) {   
    if ($username == "")      
        return "No username was entered. Please enter a username.<br />";   
    else if (strlen($username) < 5)     
        return "Usernames must be at least 5 characters.<br/>";   
    else if (preg_match("/[^a-zA-Z0-9_-]/", $username))     
        return "Only letters, numbers, -(dash) and _(underscore) are allowed in usernames.";   
    return ""; 
    }

//validate - field first name
function validate_firstname($firstname) {   
    if ($firstname == "") {
        return "No first name was entered. Please enter a first name.<br />";
    } elseif (strlen($firstname) < 2) {
        return "First names must be at least 2 characters.<br/>";
    }
    return ""; 
} 


//validate - field last name
function validate_lastname($lastname) {   
    if ($lastname == "")  {    
        return "No last name was entered. Please enter a last name.<br />";
    } elseif (strlen($lastname) < 2 ) {
        return "Last names must be at least 2 characters.<br/>";
    }
    return ""; 
}


//validate password
function validate_password($password) {
        if ($password == "")      
            return "No password was entered. Please eneter a password.<br />";   
        else if (strlen($password) < 8)     
            return "Passwords must be at least 8 characters.<br/>";   
        else if ( !preg_match("/[a-z]/", $password) || !preg_match("/[A-Z]/", $password) || !preg_match("/[0-9]/", $password))     
            return "Passwords require 1 each of a-z, A-Z and 0-9";  
        return ""; 
    }
?>