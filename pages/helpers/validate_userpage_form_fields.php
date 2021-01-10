<?php

//validate - field first name
function validate_firstname($firstname) {   
    if ($firstname == "") {
        return "First names must be at least 2 characters.<br/>";
    }
    return ""; 
} 

//validate - field last name
function validate_lastname($lastname) {   
    if ($lastname == "")  {    
        return "Last names must be at least 2 characters.<br/>";
    }
    return ""; 
}
?>