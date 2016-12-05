<?php 
// This page is for editing a artwork record.

  //includes configaration files
  require ('../includes/config-inc.php');

  //set page title and include header
  $page_title = 'Edit a Artwork';
  include (HEADER);

  //Need the database connection
  require (PDO);

  //require function definitions
  require_once (FUN_DEFS);

  //rredirect user if not logged in
  redirect_ifNotLoggedIn();
  $b_pub_id = $_SESSION['id'];
  $b_pub_name=$_SESSION['first_name'];

  // Check for a valid artwork ID, through GET or POST:
  if ( (isset($_GET['a_id'])) && (is_numeric($_GET['a_id'])) ) { // From view_users.php
  	$a_id = $_GET['a_id'];
  } elseif ( (isset($_POST['a_id'])) && (is_numeric($_POST['a_id'])) ) { // Form submission.
  	$a_id = $_POST['a_id'];
  } else { // No valid ID, kill the script.
  	echo '<p class="error">This page has been accessed in error.</p>';
  	include (FOOTER); 
  	exit();
  }
   
   // Assume invalid values:
  $art_title = $art_desc = $artist_name=$art_price= FALSE;
  // Check if the form has been submitted:
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      
  	 // Trim all the incoming data:
      $art_title=!empty($_POST['art_title'])?trim($_POST['art_title']):null;
      $artist_name=!empty($_POST['artist_name'])?trim($_POST['artist_name']):null;
      $art_desc=!empty($_POST['art_desc'])?trim($_POST['art_desc']):null;
      $art_price=!empty($_POST['art_price'])?trim($_POST['art_price']):null;
      
  	
      if ($art_title && $art_desc && $art_price ) { // If everything's OK.

           // Make the query:
             $q = "UPDATE azteca_artwork SET art_title=:art_title,producer_name=:p_id, art_desc=:art_desc,art_price=:art_price WHERE a_id=:a_id LIMIT 1";
               /// Prepare the statement:
              $query=$dbh->prepare($q);

              //Execute the statement and insert the new art work.
              $query->execute(array(
                
                ":art_title"=>$art_title,
                ":art_desc"=>$art_desc,
                ":art_price"=>$art_price,
                ":p_id"=> $b_pub_name,
                ":a_id"=>$a_id));

              if ($query->rowCount() == 1) { // If it ran OK.
                  // Print a message:
  		              echo '<h3 class="text-success">The  details has been edited successfully!</h3>';	
  			
              } else { // If it did not run OK.
                  echo '<p class="error">The details could not be edited due to a system error. We apologize for any inconvenience.</p>'; // Public message
              }		
  		
      } else { // If one of the data tests failed.

              echo '<p class="error">Please try again.</p>';
              //show the form
              echo '<h3>Edit Details: </h3>';
              include '../includes/art_details_form.inc.html';	
      }
  }else{// Retrieve the artwork details:
      
    $q = "SELECT art_title,artist_name,art_desc,art_price ,art_status FROM azteca_artwork WHERE a_id = $a_id";		
    $query=$dbh->prepare($q);
    $query->execute();

    if ($query->rowCount()==1) { // Valid artwork ID, show the form.
  	
  	$row = $query->fetch(PDO::FETCH_ASSOC);
  	$art_title = $row['art_title'];
    $art_desc = $row['art_desc'];
    $artist_name= $row['artist_name'];
    $art_price = $row['art_price'];       
    //show the form
  	echo '<h3>Edit Details: </h3>';
          include '../includes/art_details_form.inc.html';
      }  
  }        
  get_artwork_details($dbh, $a_id);
  $pdo=null;
  include (FOOTER);
?>
