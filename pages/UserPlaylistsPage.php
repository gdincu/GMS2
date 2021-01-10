<?php
ob_start();
require_once (__DIR__ . '/../templates/BasePage.php');
require_once "helpers/session.php";

class UserPlaylistsPage extends BasePage {

    private $sql;

    function render() {
        self::renderHeader();
        $this->content();
        self::renderFooter();
    }

    function content() {
       include "userplaylistspagecontent.html";
    }

    function returnPlaylistBasedOnUser() {

        $tempUser = "'" . $_SESSION["user"] . "'";
        $connection = mysqli_connect("localhost","root","","playversity");
        $sql = "CALL usp_returnPlaylistBasedOnUser($tempUser)";
        $result = $connection->query($sql) or die($connection->error);

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            $tempId = $row["id"];
            echo "<td><a href='index.php?page=song&playlistid=$tempId'>" . $row["name"] . "</td>";

            //Shared button
            echo '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">';
            echo '<td><input type="checkbox" hidden name="checkedValue" checked value="'. (int)$row['id'] . '">';
            echo ($row["shared"] == "0") ?
            '<button type="submit" class="btn btn-sm btn-info" name="shareItem">Share</button>'
            :
            '<button type="submit" class="btn btn-sm btn-info" name="shareItem">Stop Sharing</button>';
            echo '</td></form>';

            //Delete button
            echo '<form method="post" action="">';
            echo '<td><button type="submit" class="btn btn-sm btn-danger" name="deleteItem" value="'. (int)$row['id'] . '">Delete</button></td></form>';
            echo "</tr>";
            }

            //Adding a new playlist form
            echo '<form method="post" action="">';
            echo '<tr>
            <td>
            <div class="form-group">
            <div class="form-row">

            <div class="col">
            <input class="form-control form-control-sm" type="text" placeholder="Name of your new playlist..." name="nameP1"></input>
            </div>

            <div class="col">
            <button type="submit" class="btn btn-sm btn-success" name="addItem">Create Playlist</button>
            </div>

            <div class="col">
            </div>

            <div class="col">
            <a href="/playversity/proiect/index.php?page=song&allsongs"><button type="button" class="btn btn-sm btn-success" name="goToALlSongs">Go to the Song Library</button></a>
            </div>

            </div>
            </div>
            </td>
            </tr>
            </form>';

            //Delete button
        	if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
            {
            header("Refresh:0");
            $toDel = (int)$_POST['deleteItem'];
            $userDel = "'" . $_SESSION["user"] . "'";
            $sqlTemp = "CALL usp_delPlaylistFromUser($toDel,$userDel);";
            $con2 = mysqli_connect("localhost","root","","playversity");
            mysqli_query($con2,$sqlTemp);
            }

            //Share functionality
            if(isset($_POST['shareItem']))
            {
            header("Refresh:0");
            $toDel = $_POST['checkedValue']; //playlistid
            $sqlTemp = "CALL usp_changeShareStatus($toDel);";
            $con2 = mysqli_connect("localhost","root","","playversity");
            mysqli_query($con2,$sqlTemp);
            }

            //Creating a new playlist
            if(isset($_POST['addItem']))
            {
            header("Refresh:0");
            $newPlaylist = "'" . $_POST['nameP1'] . "'";
            $userAdd = "'" . $_SESSION["user"] . "'";
            $sqlTemp = "CALL usp_createPlaylist($newPlaylist,$userAdd)";
            $con2 = mysqli_connect("localhost","root","","playversity");
            mysqli_query($con2,$sqlTemp);
            echo 'New playlist created';
            }

    }

}