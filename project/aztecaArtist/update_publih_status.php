<?php
// This script retrieves records of artworks are yet to be published
// This can be viewed and edited by admin,publishers
// Also allows the results to be sorted in different ways.

require ('../includes/config-inc.php');
include (HEADER);
require (PDO);
require_once (FUN_DEFS);

$page_title = 'Change the art status';

// Number of records to show per page:
$display = 5;

// If no user_id session variable exists, redirect the user:
redirect_ifNotLoggedIn();

$id = $_SESSION['id'];

if(isset($_GET['a_id'])&&is_numeric($_GET['a_id'])){
     $a_id = $_GET['a_id'];
     $q = "SELECT art_title FROM azteca_books WHERE a_id = $a_id";
     get_artwork_details($dbh, $a_id);

     
        // Display the record being completed:
        echo '<h4 class="text-info">Submission of this artwork, notifies publishers that the it\'s completed and is reay to publish!
                    However you are allowed to update the basic details  always!<h4>
        <h5 class="text-primary">Are you sure you want to complete submission?</h5>';
        
        // Create the form:
        echo '<form action="update_publih_status.php" method="post">
    <input type="radio" name="sure" value="Yes" /> Yes 
    <input type="radio" name="sure" value="No" checked="checked" /> No
     
        
    <input type="submit" name="submit" value="Submit" />
    <input type="hidden" name="a_id" value="' . $a_id . '" />
    </form>';
    }
elseif (isset($_POST['a_id']) && is_numeric($_POST['a_id']) ) { // Form submission.
    $a_id = $_POST['a_id'];
}
 
// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['sure'] == 'Yes') { // update status of the book.
                $art_status = 10;
        // Make the query:
        $q = "UPDATE azteca_artwork SET art_status=:art_status WHERE a_id=:a_id LIMIT 1";
             /// Prepare the statement:
            $query=$dbh->prepare($q);

            //Execute the statement and insert the new art work.
            $query->execute(array(
              ":art_status"=>$art_status,
              ":a_id"=>$a_id));
 
    
            if($query->rowCount() == 1) { // If it ran OK.

            // Print a message:
            echo '<h4 class="text-success">The artwork is now finished with editing and is ready to publish. This artwork will be published soon for public to buy<h4>'; 

        } else { // If the query did not run OK.
            echo "<p class='error'>Can't complete the  action due to a system error.</p>"; // Public message.
            
        }
    
    } else { // No confirmation.
        echo '<h4 class="text-success">Cancelled submission!</h4>'; 
    }

} 



include (FOOTER);