<?php
  // This script retrieves records of artwork
  // This can be viewed by admin,producer and author
  // Each role will have different permissions and limited access as defined

    // Include the configuration file:
    require ('../includes/config-inc.php');

    //Set the pagetitle and include header
    $page_title = 'Manage My Artwork';
    include (HEADER);

    //Need the database connection
    require (PDO);

    //Need function definitions
    require_once (FUN_DEFS);

   //redirect user if not logged in
    redirect_ifNotLoggedIn();
    // Number of records to show per page:
    $display = 5;
    $id = $_SESSION['id'];

    if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
      $pages = $_GET['p'];
    } else { // Need to determine.
      // Count the number of records:
      $q = "SELECT COUNT(id) FROM azteca_artwork";
            $pages = get_page_no($dbh, $q, $display);
    } // End of p IF.

    // Determine where in the database to start returning results..
    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
      $start = $_GET['s'];
    } else {
      $start = 0;
    }

    // Determine the sort...
    // Default is by artwork created by date.
    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'art_status';

    // Determine the order...
    // Default is by artwork created date ascending.
    $order_by = (isset($_GET['sort'])) ? art_sort_function($sort) : 'art_status ASC';
    $q = "SELECT a_id,art_title,artist_id,art_status,image,DATE_FORMAT(created_on,'%M %d, %Y') AS artwork_created_date FROM azteca_artwork where artist_id=$id";    
      $query=$dbh->prepare($q);
      $query->execute();
       
      if($query->rowCount() == 0){
       echo "No records found.";
     }else{
     
     // Table header:
        echo '</br><table class="table table-bordered">
            <thead>
                <tr bgcolor = "#E0CCE0">
                      <th><b>#</b></th>
                      <th><b><a href="artwork_lis.php?sort=art_title">Title</a></b></th>
                      <th><b>Image</b></th>
                      <th><b><a href="artwork_list.php?sort=artwork_created_date">Date Created</a></b></th> 
                      <th><b><a href="artwork_list.php?sort=art_status">Status</a></b></th> 
                      <th>Edit</th>
                      <th>Remove</th>
                      <th>Complete Drafting</th>
                </tr>    
            </thead>';
                
       
        // Fetch and print all the records....
        $bg = '#FFFAFA'; 
        $si_no = 0;
        while ($row = $query->fetch(PDO::FETCH_ASSOC))  {
                $bg = ($bg=='#FFFAFA' ? '#FFFFFF' : '#FFFAFA');
                 $imgpath=$row['image'];
                echo '
                <tbody>
                    <tr bgcolor="' . $bg . '">
                        <td>' . ++$si_no . '</td>
                        <td align="left"><a href="../azteca/art_details.php?a_id=' . $row['a_id'] . '">' .$row['art_title'] . '</a></td>';
                        echo '<td><img src='.$imgpath.' style="width:100px; height:100px;" alt="Image not available" /></td>';
                        echo '
                        <td>' . $row['artwork_created_date'] . '</td>

                        <td>' . status_toString($row['art_status']) . '<div class="progress">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow=' . ($row['art_status']*4) .  
                            'aria-valuemin="0" aria-valuemax="100" style="width:' . $row['art_status']*4 .'%">' . $row['art_status']*4 .'% Complete </div></div></td>
                         
                        <td align="center"><a href="update_artwork.php?a_id=' . $row['a_id'] . '"><span class="glyphicon glyphicon-edit"></span></a></td>
                        <td align="center"><a href="delete_artwork.php?a_id=' . $row['a_id'] . '"><span class="glyphicon glyphicon-trash"></span></a></td>';
                        if($row['art_status']<10){
                            echo '<td align="center"><a href="update_publih_status.php?a_id=' . $row['a_id'] . '"><span class="glyphicon glyphicon-check"></span></a></td>';               
                        } else{

                          echo "<td align=center> Requested to publish</td>";
                        }   
                    echo '</tr>
                </tbody>';
        } // End of WHILE loop.
        
      echo '</table>';
      
      link_section($pages, $start, $display,$sort, basename($_SERVER['PHP_SELF']));

    }
      
    include (FOOTER);
?>