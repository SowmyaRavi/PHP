<?php
	//This Page is welcome page for admin
	require ('../includes/config-inc.php'); 

	include (HEADER);
	?>
	<div class="jumbotron">
	    
	    <?php 
	    
	    redirect_ifNotLoggedIn();
	    echo '<h2><b>Welcome  Administrator';
	    if (isset($_SESSION['first_name'])) {
	        echo ", {$_SESSION['first_name']}";
	    }
	    echo '!</b></h2>';
	    ?>        
	</div>
	<?php
	echo '<p class="text-info"> You are the super User. You can get all user details registered to 
	the site. You have the privillege to edit their roles and unsubscribing them. 
	You can view all artwork and edit privilleges. You can add publish artwork</br>
	You can also view all orders of artwork</p>';


    include(FOOTER);
?>    
