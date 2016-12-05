<?php
    // This script retrieves records of artworks are published yet to be displayed on bestseller page
    // This can be viewed and edited by admin,publishers
    // Also allows the results to be sorted in different ways.

    //Includes configaration files
    require ('../includes/config-inc.php');

    //Set page title and include html header
    $page_title = 'Change the art status';
    include (HEADER);

    //Neeed the database connection
    require (PDO);

    //require function definitions
    require_once (FUN_DEFS);

    // Number of records to show per page:
    $display = 5;

    // If no user_id session variable exists, redirect the user:
    redirect_ifNotLoggedIn();

    $id = $_SESSION['id'];
    if(isset($_GET['a_id'])&&is_numeric($_GET['a_id'])){
         $a_id = $_GET['a_id'];
         get_artwork_details($dbh, $a_id); // Run the query.
            // Display the record being completed:
            echo '<h4 class="text-info">On Submission, this artwork will be displayed on bestseller page and will be available for members to buy.
                        
            <h5 class="text-primary">Are you sure you want to display it on bestseller page?</h5>';
            
            // Create the form:
            echo '<form action="mark_as_bestseller.php" method="post">
        <input type="radio" name="sure" value="Yes" /> Display As BestSeller 
        <input type="radio" name="sure" value="No" checked="checked" /> Unsubscribe
        <input type="submit" name="submit" value="Submit" />
        <input type="hidden" name="a_id" value="' . $a_id . '" />
        </form>';
    }elseif (isset($_POST['a_id']) && is_numeric($_POST['a_id']) ) { // Form submission.
        $a_id = $_POST['a_id'];
    } 
    // Check if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['sure'] == 'Yes') { // update status of the artwork.
                    $art_status = 25;
                    
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
                echo '<h4 class="text-success">The artwork is now published. It will be seen by public and
                                Members can order from now onwards!
                                You can update the basic details of the artwork!<h4>'; 

            } else { // If the query did not run OK.
                echo "<p class='error'>It's already displayed in bestseller page</p>"; // Public message.
                
            }
        
         
         }elseif($_POST['sure'] == 'No'){ // update status of the artwork.
                    $art_status = 20;
                    
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
                echo '<h4 class="text-success">The artwork is now remains as published. But will be seen by public and
                                Members can order from now onwards!
                                You can update the basic details of the artwork!<h4>'; 

            } 
        
        } else{
            echo "Sysytem error";
        }

    } 

    $pdo=null;

    include (FOOTER);

?>