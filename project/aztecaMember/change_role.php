<?php 
// This page is for changing user level of a member.
//This page can be accessed by manage_user.php
// This page can be accessed only by  admin.

 // Include the configuration file:
require ('../includes/config-inc.php');


    // Set the page title and include the HTML header:
$page_title = 'Change role';
include (HEADER);

    //Need the database connection
require (PDO);

    // Need the functions:
require_once (FUN_DEFS);

// If no user_id session variable exists, redirect the user:
redirect_ifNotLoggedIn();
//$id=$_SESSION['id'];

// Check for a valid user ID, through GET :
if ( (isset($_GET['id'])) && (is_numeric($_GET['id'])) ) { 
    $id = $_GET['id'];
} elseif ( (isset($_POST['id'])) && (is_numeric($_POST['id'])) ) { // Form submission.
    $id = $_POST['id'];
}else { // No valid ID, kill the script.
    echo '<p class="error">This page has been accessed in error.</p>';
    include (FOOTER); 
    exit();
}

require (PDO);

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
     // Assume invalid value for user_level:
        $ul = FALSE;
        
	// Check for valid submitted user level:
	if (empty($_POST['role'])) {
		echo '<p class="error">You forgot to choose role!</p>';
	} else {
        $ul=$_POST['role'];

        $q = "UPDATE azteca_users SET user_level=:ul WHERE id=:id LIMIT 1";

         $query=$dbh->prepare($q);
    
    //Execute the statement and insert the new account.
     $result=$query->execute(array(
              ":ul"=>$ul,
              ":id"=>$id));
    
    if($result){
        echo '<p class="text-success">The role has been changed to '.  role_toString($ul).' </p>';
         include (FOOTER); 
        exit();
    }else { // If it did not run OK.
                            // Public message:
        echo '<h1>System Error</h1>';
    }

		
	}
   

} /// End of submit conditional.

// Retrieve the user's current role:
$q = "SELECT user_level,first_name FROM azteca_users WHERE id=$id";		
$query=$dbh->prepare($q);
     $query->execute();
   
   if($query->rowCount() == 1 && $_SESSION['user_level']==100){

         $row = $query->fetch(PDO::FETCH_ASSOC);
         $role = $row['user_level'];
         echo '</br><p><b>First Name: '.$row['first_name'].'</b></p>';
    echo '<p><b>Current Role: '.role_toString($role).'</b></p>';
        // Create the form:
    echo '<form action="change_role.php" method="post">
            <p><b><label for ="role">
                New Role:
                    <input type = "radio" name ="role" value =10';
                        if ($role == 10){echo ' checked="checked"';} echo '>Member';  
                echo '<input type = "radio" name ="role" value =30';
                        if ($role == 30){echo ' checked="checked"';}echo '>Artist'; 
                echo '<input type ="radio" name = "role" value=50';
                        if ($role == 50){echo ' checked="checked"';}echo '>Producer';
                
    echo  '</label></b>    </p>
            <p><input type="submit" name="submit" value="Submit" /></p>
               <input type="hidden" name="id" value="' . $id . '" />
         </form>';
         } else { // Not a valid user ID.
	echo '<p class="error">This page has been accessed in error.</p>';
}
 /* free result */

$pdo=null;
		
include (FOOTER);

?>
