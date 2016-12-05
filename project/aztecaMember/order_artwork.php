<?php
  // This script retrieves records of artwork
  // This can be viewed by public, but to order artwork they have to subscribe.

  // Include the configuration file:
  require ('../includes/config-inc.php');

  // Set the page title and include the HTML header:
  $page_title = 'Artwork';
  include (HEADER);

  //Get Database connection
  require (PDO);
  require_once (FUN_DEFS);

  // Number of records to show per page:
  $display = 10;


  if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
      $pages = $_GET['p'];
    } else { // Need to determine.
      // Count the number of records:
      $q = "SELECT COUNT(id) FROM azteca_artwork";
      $pages = get_page_no($dbh, $q, $display);
    } // End of p IF.

    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
      $start = $_GET['s'];
    } else {
      $start = 0;
    }


  // Determine the sort...
  // Default is by artwork created by date.
  $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'art_status';

  // Determine the order...
  // Default artwork created date ascending.
  $order_by = (isset($_GET['sort'])) ? art_sort_function($sort) : 'art_status ASC';
  $q = "SELECT a_id,art_title,artist_name,art_price,art_status,image,copies_sold,DATE_FORMAT(created_on,'%M %d, %Y') AS artwork_created_date FROM azteca_artwork where art_status=25";    
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
    <th><b><a href="order_artwork.php?sort=art_title"> Title</a></b></th>
    <th><b><a href="order_artwork.php?sort=artist_name"> Artist</a></b></th>
    <th><b><a href="order_artwork.php?sort=art_price"> Price <span class="glyphicon glyphicon-usd"></span></a></b></th> 
    <th><b><a href="order_artwork.php?">Copies Sold</a></b></th>
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
      <td align="left"><a href="../azteca/art_details.php?b_id=' . $row['a_id'] . '">' .$row['art_title'] . '</a></td>
      <td align="left">' . $row['artist_name'] . '</td>
      <td align="left">$' . $row['art_price'] . '</td>
      <td align="left">$' . $row['copies_sold'] . '</td>
      </tr>
      </tbody>';
    } // End of WHILE loop.
      
      echo '</table>';

      //for drawing plot on number of books sold  
 $start_date = "2016-01-01";
 $month_count = 0;
 $data_qty = array();
while($month_count<12) {
  
  $end_date =  date('Y-m-d', strtotime($start_date. ' + 30 days'));
  $q = "SELECT art_qty FROM azteca_orders WHERE order_date BETWEEN '$start_date' AND '$end_date'";

  $query=$dbh->prepare($q);
     $query->execute();
  $month_qy = 0;
  while ( $row = $query->fetch(PDO::FETCH_ASSOC)){
    $month_qy += $row['art_qty'];
  }
  $data_qty[] = $month_qy;
  $month_count++;
  $start_date = $end_date;
}
  
  
$data = json_encode($data_qty);
$dataset_X = "{name: 'Artworks Sold Per month', data:". $data."}";
        

      link_section($pages, $start, $display,$sort, basename($_SERVER['PHP_SELF']));

    }

    $pdo=null;

    
  include (FOOTER);
?>  