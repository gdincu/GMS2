<?php
ob_start();
require_once (__DIR__ . '/../templates/BasePage.php');
require_once "helpers/session.php";

class UsersListPage extends BasePage {

    private $sql;

    function render() {
        self::renderHeader();
        $this->content();
        self::renderFooter();
    }

    function content() {
       include "userslistpagecontent.html";
    }

    function returnUserList() {

        $tempUser = "'" . $_SESSION["user"] . "'";
        $connection = mysqli_connect("localhost","root","","gms");
        $sql = "SELECT * FROM user WHERE username <> $tempUser";
        $result = $connection->query($sql) or die($connection->error);

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
			$tempId = $row["id"];
            echo '<td>'.$row["username"].'</td>'; 

            //Delete button
            echo '<form method="post" action="">';
            echo '<td><button type="submit" class="btn btn-sm btn-danger" name="deleteItem" value="'. (int)$row['id'] . '">Delete</button></td></form>';
            echo "</tr>";
            }

            //Delete button
        	if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
            {
            header("Refresh:0");
            $toDel = (int)$_POST['deleteItem'];
            $userDel = "'" . $_SESSION["user"] . "'";
            $sqlTemp = "DELETE FROM user WHERE id =".$toDel.";";
            $con2 = mysqli_connect("localhost","root","","gms");
            mysqli_query($con2,$sqlTemp);
            }

    }

}