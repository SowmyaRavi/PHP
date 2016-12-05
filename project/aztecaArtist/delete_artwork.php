<?php
	// This page is for deleting a record of artwork

	// Include the configuration file:
	require ('../includes/config-inc.php');

	//Set the pagetitle and include header
	$page_title = 'Delete Artwork';
	include (HEADER);

	//redirect user if not logged in
	redirect_ifNotLoggedIn();

	// Check for a valid artwork ID, through GET or POST:
	if ( (isset($_GET['a_id'])) && (is_numeric($_GET['a_id'])) ) {  
		$a_id = $_GET['a_id'];
	} elseif ( (isset($_POST['a_id'])) && (is_numeric($_POST['a_id'])) ) { // Form submission.
		$a_id = $_POST['a_id'];
	} else { // No valid ID, kill the script.
		echo '<p class="error">This page has been accessed in error.</p>';
		include (FOOTER); 
		exit();
	}

    //Need the database connection
	require (PDO);

	// Check if the form has been submitted:
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		if ($_POST['sure'] == 'Yes') { // Delete the record.

			// Make the query:
			$q = "DELETE FROM azteca_artwork WHERE a_id=:a_id LIMIT 1";		
			$query=$dbh->prepare($q);
			$query->execute(array(':a_id' => $a_id));

			if($query->rowCount() == 1) { // If it ran OK.

				// Print a message:
				echo '<h3 class="text-success">Removed!</h3>';	

			} else { // If the query did not run OK.
				echo "<p class='error'>Can't remove due to a system error.</p>"; // Public message.
				
			}
			
		} else { // No confirmation of deletion.
			echo '<p class="text-success">NOT deleted!</p>';	
		}

	} else { // Show the form.

	  // Retrieve the artwork's title:
		$q = "SELECT art_title FROM azteca_artwork WHERE a_id = :a_id";
		$query=$dbh->prepare($q);
		$query->execute(array(':a_id' => $a_id));
		if($query->rowCount() == 1) { // Valid artwork ID, show the form.

			// Get the artwork's information:
			$row = $query->fetch(PDO::FETCH_ASSOC);
			
			echo '<h2 class="text-info">Delete a artwork?</h2>';
			
			$title=$row['art_title'];
	       // Display the record being deleted:
			echo '<h3 class="text-primary">Title:'. $title .'</h3> This will remove complete record of this artwork.</br>
			Are you sure you want to remove this?';
			
			// Create the form:
			echo '<form action="delete_artwork.php" method="post">
			<input type="radio" name="sure" value="Yes" /> Yes 
			<input type="radio" name="sure" value="No" checked="checked" /> No
			<input type="submit" name="submit" value="Submit" />
			<input type="hidden" name="a_id" value="' . $a_id . '" />
			</form>';
			
		} else { // Not a valid artwork ID.
			echo '<p class="error">This page has been accessed in error.</p>';
		}

	} // End of the main submission conditional.

	$pdo=null;

	include (FOOTER);
?>
