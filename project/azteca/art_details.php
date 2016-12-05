<?php
	// This page is for detailed view of a artwork.

    // Include the configuration file:
    require ('../includes/config-inc.php');

	// Set the page title and include the HTML header:
	$page_title = 'Art Details';
	include (HEADER);

	require_once (FUN_DEFS);

	//Need the database connection
	require (PDO);

	// Check for a valid artwork ID, through GET or POST:
	if ( (isset($_GET['a_id'])) && (is_numeric($_GET['a_id'])) ) {  
		$a_id = $_GET['a_id'];

	} else { // No valid ID, kill the script.
		echo '<p class="error">This page has been accessed in error.</p>';
		include (FOOTER); 
		exit();
	}

	get_artwork_details($dbh, $a_id);
	$pdo=null;
	include (FOOTER);
?>	 