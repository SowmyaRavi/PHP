<?php

/* This script:
 * - define constants and settings
 * - dictates how errors are handled
 * - defines useful functions
 */

// ********************************** //
// ************ SETTINGS ************ //

// Location of the MySQL connection script:
define ('PDO', '../../SiteConnect/database-config.php');

// Adjust the time zone for PHP 5.1 and greater:
date_default_timezone_set ('US/Pacific');

// ********************************** //
// ************ SETTINGS ************ //

// ************ USEFUL FUNCTIONS/ INCLUDES FILES************ //
// ************************************************** //

//Location of header file
define ('HEADER', '../includes/header.html');

//Location of footer file
define('FOOTER', '../includes/footer.html');

//Location of common useful function definition script file
define ('FUN_DEFS', '../includes/common_functions.inc.php');

/* This function determines an absolute URL and redirects the user there.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */
function redirect_user ($page = '../azteca/index.php') {

	// Start defining the URL...
	// URL is http:// plus the host name plus the current directory:
	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname(htmlspecialchars($_SERVER["PHP_SELF"]));
	
	// Remove any trailing slashes:
	$url = rtrim($url, '/\\');
	
	// Add the page:
	$url .= '/' . $page;
	
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script.

} // End of redirect_user() function.

// If no session variable exists, redirect the user:
function redirect_ifNotLoggedIn(){
	if (!isset($_SESSION['user_id'])&& !isset($_SESSION['user_level'])) {
		//ob_end_clean(); // Delete the buffer.
	 	redirect_user();   
	
	}  
}
?>