<?php
// This script retrieves all the records from the users table.
// This can be viewed and edited by only admin
// Each role will have different permissions and limited access as defined
// Also allows the results to be sorted in different ways.
//Amdin has permission to change role of other members.

    // Include the configuration file:
    require ('../includes/config-inc.php');


    // Set the page title and include the HTML header:
    $page_title = 'Manage Current Users';
    include (HEADER);

    //Need the database connection
    require (PDO);

    // Need the functions:
    require_once (FUN_DEFS);

    redirect_ifNotLoggedIn();
    // Number of records to show per page:
    $display = 10;

    $role = $_SESSION['user_level'];
    $id = $_SESSION['id'];


    if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
        $pages = $_GET['p'];
    } else { // Need to determine.
        // Count the number of records:
        $q = "SELECT COUNT(id) FROM azteca_users";
        $pages = get_page_no($dbh, $q, $display);
    } // End of p IF.


    // Determine how many pages there are...
    if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
    	$pages = $_GET['p'];
    } else { // Need to determine.
     	// Count the number of records:
    	$q = "SELECT COUNT(id) FROM azteca_users";
        $pages = get_page_no($dbh, $q, $display);
    } // End of p IF.

    // Determine where in the database to start returning results...
    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
    	$start = $_GET['s'];
    } else {
    	$start = 0;
    }

    // Determine the sort...
    // Default is by user_level
    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'user_level';

    // Determine the order...
    // Default is by user level created descending.
    $order_by = (isset($_GET['sort'])) ? art_sort_function($sort) : 'user_level DESC';

    if($role == 100){
        
        echo '<h2>Registered Users</h2>';

        // Table header:
        echo '</br><table class="table table-bordered">
        <thead>
        <tr bgcolor = "#E0CCE0">
        <th><b>#</b></th>
        <th><b><a href="manage_users.php?sort=user_level">Role</a></b></th>
        <th><b><a href="manage_users.php?sort=full_name">Name</a></b></th>   
        <th><b><a href="manage_users.php?sort=dob">Date of Birth</a></b></th>            
        <th align="center">Change Role</th>
        </tr>    
        </thead>';
        // Fetch and print all the records....
        $bg = '#ffffff'; 
        $si_no = 0;
        // Define the query:
        $q = "SELECT user_level,CONCAT(first_name,' ',last_name) AS full_name,DATE_FORMAT(dob, '%M %d, %Y') AS dr,id FROM azteca_users ORDER BY $order_by LIMIT $start, $display";		
        $query=$dbh->prepare($q);
        $query->execute();
        
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            
            $bg = ($bg=='#ffffff' ? '#eeeeee' : '#ffffff'); 
            echo '
            <tbody>
            <tr bgcolor="' . $bg . '">
            <td>' . ++$si_no . '</td>
            <td align="left">' . role_toString($row['user_level']) . '</td>
            <td align="left"><a href="../aztecaMember/user_account.php?id=' . $row['id'] . ' "><span class="glyphicon glyphicon-user"></span> ' . ucwords($row['full_name']) . '</a></td>
            <td align="left">' . $row['dr'] . '</td>';
            if($role!=$row['user_level']){
                echo '<td align="center"><a href="../aztecaMember/change_role.php?id=' . $row['id'] . ' "><span class="glyphicon glyphicon-edit"></span></a></td>';
            }else{
                echo '<td align="center"></td>';
            } 
            
            echo '</tr>
            </tbody>';
            echo '<tr bgcolor="' . $bg . '">';  
            
        } // End of WHILE loop.
    }else{	//not a valid user
        
        echo '<p class="error">UnAuthorised Access.</p>';    
    }

    echo '</table>';

    //close the db connection
    $pdo=null;

    // Make the links to other pages, if necessary.
    link_section($pages, $start, $display,$sort, basename($_SERVER['PHP_SELF']));

    include (FOOTER);

?>