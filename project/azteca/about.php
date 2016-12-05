<?php

//This page gives details about website designer

// Include the configuration file:
require ('../includes/config-inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Welcome to AztecA Studios Corp Web Site!';
include (HEADER);

// Need the database connection:
include(PDO);
    try{
		$q= 'SELECT page FROM pages_table where id=2';
		$query=$dbh->prepare($q);
		$query->execute();

		while ($row = $query->fetch(PDO::FETCH_ASSOC))
		{
			$body = $row['page'];

		}
			echo $body;
	}catch (PDOException $ex) {
		echo "Database not online, Please look into it";
		echo  $ex->getMessage();
	}
		
$pdo=null;

include (FOOTER);
?>
