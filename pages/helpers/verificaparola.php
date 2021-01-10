<?php
/**
 * Used to validate the new passwords provided via the form
 */
$parola=$parola2=$parola3=$fail="";

if (isset($_POST['parola']))
    $parola = $_POST['parola'];
if (isset($_POST['parola2']))
    $parola2 = $_POST['parola2'];
if (isset($_POST['parola3']))
    $parola3 = $_POST['parola3'];

$fail .= validate_parola($parola,$parola2,$parola3);
?>

<?php
/**
 * Function to validate the password
 */
function validate_parola($parola,$parola2,$parola3) {

if(strcmp(hash("sha256", htmlentities($parola,ENT_HTML5,'UTF-8',TRUE)) , $_SESSION["password"]) != 0 )
echo "<script> alertify.error('Current password is incorrect<br />'); </script>";

if ( !preg_match("/[a-z]/", $parola2) || !preg_match("/[A-Z]/", $parola2) || !preg_match("/[0-9]/", $parola2))     
return "New password requires one of each: a-z, A-Z and 0-9";  

if ($parola2 == "" || $parola3 == "" )
return "Both passwords must be completed<br />";

if (strcmp($parola3,$parola2) != 0 )
return "New passwords do not match<br />";

if (strcmp($parola,$parola2) == 0 )
return "New passwords are similar with the current one<br />";

if(strlen($parola2) < 8 || strlen($parola3) < 8)
return "Passwords must be at least 8 characters.<br/>";   

return "";
}

?> 