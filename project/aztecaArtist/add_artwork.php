<?php
  // This page is to add new artwork by an artist.
  // This has access to all users above level of artist

   // Include the configuration file:
  require ('../includes/config-inc.php');

  // Set the page title and include the HTML header:
  $page_title = 'add new artwork';
  include (HEADER);

  // Need the database connection:
  include(PDO);

  //Need function definitions
  require_once(FUN_DEFS);

  // If no user_id session variable exists or user level lesser than artist, redirect the user:
  redirect_ifNotLoggedIn();
  if($_SESSION['user_level']<=10){
  redirect_user();
  }

  // Check for form submission:
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

     
    $id = $_SESSION['id'];

      // Trim all the incoming data:
    $art_title=!empty($_POST['art_title'])?trim($_POST['art_title']):null;
    $artist_name=!empty($_POST['artist_name'])?trim($_POST['artist_name']):null;
    $art_desc=!empty($_POST['art_desc'])?trim($_POST['art_desc']):null;
    
   
    

     if ($art_title && $artist_name && $art_desc ) { // If everything's OK...

          // add the artwork in the database...
          // Make the query:
     $q = 'INSERT INTO azteca_artwork (art_title, artist_name,art_desc,created_on,artist_id) VALUES (:art_title,:artist_name,:art_desc,NOW(),:artist_id)';

          /// Prepare the statement:
     $query=$dbh->prepare($q);

  			//Execute the statement and insert the new art work.
     $query->execute(array(
      ":art_title"=>$art_title,
      ":artist_name"=>$artist_name,
      ":art_desc"=>$art_desc,
      ":artist_id"=>$id));


  			if($query->rowCount() == 1) { // If it ran OK.

                 // Print a message:                    
          echo '<h3 class="text-success">Your artwork has been succesfully submitted at Azteca Studios Corp!</h3>                          
          <p>You can edit your artwork details as many times you wish. Once you finished editing and wish 
          to publish your artwork you can submit your art to notify publishers that this is ready to get published.
          Authorized person can review your art, edit, set price, publish and sell.</p><p><br /></p>
          <p><a href="../aztecaArtist/manage_artist_artwork.php?id=' . $_SESSION['id'] . '">Click here to View and manage artwork you created</a></p>';

                  // Include the footer and quit the script:
          include (FOOTER); 
          exit();

              } else { // If it did not run OK.
                      // Public message:
                echo '<h1>System Error</h1>
                <p class="error">You could not add new artwork due to a system error. We apologize for any inconvenience.</p>'; 

              } // End of if ($r) IF.

          } else { // If one of the data tests failed.

            echo '<p class="error">Please try again.</p>';	
          } 
          } // End of the main Submit conditional.
  ?>
  <h1>Add an Art work</h1>
  <?php
  include '../includes/art_details_form.inc.html';


  include (FOOTER); 
?>