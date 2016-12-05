<?php
// This is the page gives details about events organized by artzteca studios.

// Include the configuration file:
require ('../includes/config-inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Welcome to AztecA Studios Corp Web Site!';
include (HEADER);

// Need the database connection:
include(PDO);
try{
	$q= 'SELECT page FROM pages_table where id=5';
	$query=$dbh->prepare($q);
	$query->execute();

	while ($row = $query->fetch(PDO::FETCH_ASSOC))
	{
		$body = $row['page'];

	}
}catch (PDOException $ex) {
	echo  $ex->getMessage();
}
echo $body;

include 'countdown_timer.php';

$pdo=null;

include (FOOTER);
?>