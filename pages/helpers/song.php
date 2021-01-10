<?php
ob_start();
/**
 * Connecting to the DB using a generic login
 */
include (__DIR__ . '/../../setup/db_connect.php');

/**
 * Sanitises and stores the playlistid in a variable
 */
$tempPlaylist = 0;
if(isset($_GET['playlistid']))
$tempPlaylist = (int)htmlentities($_GET['playlistid'],ENT_HTML5,'UTF-8',TRUE);

/**
 * Checks the orderby value and sanitises the value passed through the URI
*/
$orderby = 'NULL';
if(isset($_GET['orderby']))
$orderby = "'".htmlentities($_GET['orderby'],ENT_HTML5,'UTF-8',TRUE)."'";

/**
 * Setting the start page to divide result sets containing multiple lines into multiple pages
 */
$results_per_page = 7; //<== value to be changed
if (isset($_GET["pageno"]) && is_numeric($_GET["pageno"])) { $page  = $_GET["pageno"]; } else { $page=1; };
$start_from = ($page-1) * $results_per_page;

/**
 * Find the total nr of records and works out the total nr of pages
 */
$sqlCountAll = "SELECT COUNT(id) AS total FROM song";
$sqlCount = "SELECT COUNT(*) AS total FROM songplaylist WHERE idplaylist = $tempPlaylist";
if(isset($_GET['allsongs']))
$resultCount = $connection->query($sqlCountAll);
else
$resultCount = $connection->query($sqlCount);
$rowCount = $resultCount->fetch_assoc();
$totalCount = $rowCount["total"];
$total_pages = ceil($rowCount["total"] / $results_per_page);


/**
 * Checks if the URI includes "index.php" and whether it contains a playlist id
 * Then calls the usp_returnSongs procedure and returns the artist, song name and song length based on the playlist id and orderby value
 */
if ( strpos($_SERVER['REQUEST_URI'], 'index.php') !== false && isset($_GET['playlistid'])) {
$sql = "CALL usp_returnSongs($tempPlaylist,$orderby,$start_from,$results_per_page);";
$sql2 = "CALL usp_orderBy ($tempPlaylist,$orderby);";
}

/**
 * Checks if the URI includes "index.php" and allsongs
 * Then calls the usp_returnAllSongs procedure and returns the artist, song name and song length
 */
else if (strpos($_SERVER['REQUEST_URI'], 'index.php') !== false && isset($_GET['allsongs']))
$sql = "CALL usp_returnAllSongs($start_from,$results_per_page,$orderby);";

/**
 * Exits song.php if the URI doesn't contain the expected variables
 */
else exit();

/**
 * Runs the SQL query
 */
if(isset($_GET['orderby']) && isset($_GET['playlistid'])) $connection->query($sql2);
$result = $connection->query($sql);

if($result->num_rows == 0)
{
	echo "Page not found! Please try again!";
	exit();
}
else    {
	/**
	 * Return song details from the DB
	 */
	while($row = $result->fetch_assoc()) {
		
		echo "<tr>";		
		echo "<td>" . $row["artist"] . "</td>";
		echo "<td>" . $row["name"] . "</td>";
		echo "<td>" . $row["length"] . "</td>";

		/**
		 * Adds song delete functionality if the URI contains a playlist id
		 */
		if(isset($_GET["playlistid"]) && !isset($_GET["shared"])) {
				echo "<form method='post'>";
				echo '<td><button class="btn btn-sm btn-danger" type="submit" name="deleteItem"';
				echo 'value="' . (int)$row['id'];
				echo '">Delete</button></td>';
				echo '</form>';
				}

		/**
		 * Adds song add functionality if the URI contains an allsongs tag
		 */		
		if(isset($_GET["allsongs"])) {

			/**
			 * Returns all playlist for the current user
			 */
			echo "<form method='post'>";
			
			echo '<td><select id="myDropDown" name="playlists">';
			echo '<option value="" selected disabled>Select Playlist</option>';
			
			$tempUser = "'" . $_SESSION["user"] . "'";
			$sqlTemp = "SELECT a.name,a.id FROM playlist a,userplaylist b,user c WHERE a.id = b.idplaylist AND b.iduser = c.id AND c.username = $tempUser";
			$connection = mysqli_connect("localhost","root","","playversity");
			$resultCount = $connection->query($sqlTemp);
			
			while($rowTemp = $resultCount->fetch_assoc())
				echo '<option value="' . $rowTemp['id'] . '">' . $rowTemp['name'] . '</option>';
			echo '</select>';
			echo '</td><td>';


			echo '<button class="btn btn-sm btn-danger" type="submit" name="addItem1" ';
			// song id
			echo 'value="'. (int)$row['id'] . '"';
			//Add button
			echo '>Add</button></td>';
			echo '</form>';

			}
			
		echo "</tr>";
		
	}
	echo '</form>';
	echo "</table>";
}

/**
 * Show the all other pages as a dropdown list
 */
echo 'Page: <select name="pagenumbers" onchange="location = this.value;">';
for ($c = 1; $c<=$total_pages; $c++) {

	if(!isset($_GET["pageno"]))
		echo "<option value='" . $_SERVER["REQUEST_URI"] . "&pageno=".$c."'>".$c."</option> ";
	else {
		//Un-setting the pageno tag from the URI used to generate option tags
		$string = removeParam($_SERVER["REQUEST_URI"],'pageno');
		//Setting the default value for the option tag based on the URI
		if((int)$c == (int)($_GET["pageno"]))
		echo "<option selected value='" . $string . "&pageno=".$c."'>".$c."</option> ";
		else
		echo "<option value='" . $string . "&pageno=".$c."'>".$c."</option> ";
		}
	}

	echo '</select>';


	function removeParam($url, $param) {
		$url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*$/', '', $url);
		$url = preg_replace('/(&|\?)'.preg_quote($param).'=[^&]*&/', '$1', $url);
		return $url;
	}

	//Deleting items
	if(isset($_POST['deleteItem']) and is_numeric($_POST['deleteItem']))
	{
	// header("Refresh:0");
	$toDel = (int)$_POST['deleteItem'];
	$sqlTemp = "CALL usp_delSongFromPlaylist($tempPlaylist,$toDel);";
	$con2 = mysqli_connect("localhost","root","","playversity");
	mysqli_query($con2,$sqlTemp);

	$tempPgNo = 1;
	if(isset($_GET["pageno"]))
	$tempPgNo = (int)($_GET["pageno"]);

	$results_per_current_page = $totalCount - ($results_per_page * ($tempPgNo - 1)) - 1;

	if(($results_per_current_page == 0 && $tempPgNo == 1)) 
	header("Location: index.php?page=userplaylists");

	else if($results_per_current_page == 0 && ($tempPgNo > 1))
	header("Location: index.php?page=song&playlistid=" . $tempPlaylist . '&pageno=' . ($tempPgNo-1));

	else
	header("Refresh:0"); //Refreshes the same page
	}

	//Adding items
	if(isset($_POST['addItem1']))
	{
	$plToAdd = (int)$_POST['playlists']; //playlist id to be added
	$sgToAdd = (int)$_POST['addItem1']; //song id to be added
	$sqlTemp = "CALL usp_insSongPlaylist($sgToAdd, $plToAdd);";
	$con3 = mysqli_connect("localhost","root","","playversity");
	mysqli_query($con3,$sqlTemp);
	}

	echo  isset($_GET['playlistid']) ? 
	'<br><br><div class="col">
	<a href="/playversity/proiect/index.php?page=song&allsongs"><button type="button" class="btn btn-sm btn-success" name="goToALlSongs">Go to the Song Library</button></a>
	</div>'
	: "";

?>
