<?php
ob_start();
require_once (__DIR__ . '/../templates/BasePage.php');
require_once "helpers/session.php";

class SharedPlaylistsPage extends BasePage {

    private $sql;


    function render() {
        self::renderHeader();
        $this->content();//self::renderContent();
        self::renderFooter();
    }

    function content() {
       include "sharedplaylistspagecontent.html";
    }
//function wich return shows the shared playlist of a user
    function returnSharedPlaylists() {

        $tempUser = "'" . $_SESSION["user"] . "'";
        $connection = mysqli_connect("localhost","root","","playversity");
        $sql = "SELECT a.id,a.name,count(d.idsong) nr FROM playlist a,userplaylist b,user c,songplaylist d 
        WHERE a.shared = 1 
        AND a.id = b.idplaylist
        AND b.iduser = c.id
        AND d.idplaylist = a.id
        AND c.username <> $tempUser
        GROUP BY a.id";
        $result = $connection->query($sql) or die($connection->error);

        //Only displays playlists with songs -- ignores all blank playlists
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            $tempId = $row["id"];
            echo "<td><a href='index.php?page=song&playlistid=$tempId&shared'>" . $row["name"] . "</td>";
            echo "<td>" . $row["nr"] . "</td>";

            }

    }

}
