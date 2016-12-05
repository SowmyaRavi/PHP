<?php

function get_prod_name($dbh){ 

    // Define the query:
    $q = "SELECT first_name,id FROM azteca_users WHERE user_level>=50";      
    $query=$dbh->prepare($q);
    $query->execute();

    // Fetch and print category list for current artwork.
    $b_producer_array = array();
    while ($row = $query->fetch(PDO::FETCH_ASSOC)){
        
       $b_producer_array[] = $row['first_name'];
    }
    //close the database connection
    $pdo=null;
    return $b_producer_array;
}

function status_toString($status){
    switch($status){
        case '5':
            return 'Incomplete! Editing in progress!';
            break;
        case '10':
            return 'Complete! Request/Wish to publish!';
            break;
        case '15':
            return 'Publish in progress! Accepted and wait to get published!';
            break;
        case '20':
            return 'Published!';
            break;
        case '25':
            return 'Published! Ready to buy!';
            break;    
        default:
            return 'status unknown';
            break;
    }
}


function get_art_detail($dbh,$key,$a_id){
    // Define the query:
    $q = "SELECT "."$key"." FROM azteca_artwork WHERE a_id = :a_id ";
try{	
    $query=$dbh->prepare($q);
    $query->execute(array(':a_id'=>$a_id));
    while($row = $query->fetch(PDO::FETCH_ASSOC)){
        $value = $row["$key"];
    return $value;
    }

}  
catch (PDOException $e) {
    print $e->getMessage();
  }
}
    

function get_artwork_details($dbh,$a_id){ 

    // Define the query:
    $q = "SELECT art_title, artist_name, art_desc, art_status,"
            . "DATE_FORMAT(created_on, '%M %d, %Y') AS a_created_date,"
            ."art_price"
            . " FROM azteca_artwork where a_id =:a_id ";		
   
    $query=$dbh->prepare($q);
    $query->execute(array(':a_id' => $a_id));
    $row = $query->fetch(PDO::FETCH_ASSOC);

    // Fetch and print all the colums for current artwork.
    if ($row) {    
        echo '<h3>Details:</h3><pre>';
            $keys = ['Title :','Artist :','Description :','Artwork Status :',
                'Created on :','Price:']; 
            $i = 0;
            // Fetch and print all the records:
            foreach ($row as $key=>$value) {           
                if($key == 'art_status'){                
                    echo '<p align="left"><b>' . $keys[$i]. '</b>   '. status_toString($value) . '</p>';
                }  
                else{
                    echo '<p align="left"><b>' . $keys[$i]. '</b>    ' .$value . '</p>';
                }
                $i++;  
            }
            echo '</pre>';
    }else{ // End of if.{
        echo 'System error!We Appologize!';
        include (FOOTER);
        exit();
    }
    /* free result */
   $pdo=null;

}



function art_sort_function($sort){
    // Determine the sorting order:
    switch ($sort) {
            case 'user_level':
                    $order_by = 'user_level DESC';
                    break;
            case 'full_name':
                    $order_by = 'full_name ASC';
                    break;
            case 'dob':
                    $order_by = 'registration_date ASC';
                    break;
            
            case 'art_title':
                    $order_by = 'b_title ASC';
                    break;
            
            case 'artist_name':
                    $order_by = 'author_name ASC';
                    break;
            case 'image':
                    $order_by = 'image ASC';
                    break;
            case 'art_status':
                    $order_by = 'b_status ASC';
                    break;
            case 'created_on':
                    $order_by = 'b_created_date ASC';
                    break;
            case 'art_price':
                    $order_by = 'b_price ASC';
                    break;
           
        }
    return $order_by;
}

function get_page_no($dbh,$q,$display){
    
    // Count the number of records:
	$query=$dbh->prepare($q); 
    $query->execute();
	$row_count = $query->rowCount();
	// Calculate the number of pages...
	if ($row_count> $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
    return $pages;    
}

function link_section($pages,$start,$display, $sort,$base_url){
    // Make the links to other pages, if necessary.
    if ($pages > 1) {

            echo '<br/><p>';
            $current_page = ($start/$display) + 1;

            // If it's not the first page, make a Previous button:
            if ($current_page != 1) {
                    echo '<a href=' . $base_url . '?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '>Previous</a> ';
            }

            // Make all the numbered pages:
            for ($i = 1; $i <= $pages; $i++) {
                    if ($i != $current_page) {
                            echo '<a href=' . $base_url . '?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '> '. $i .' </a>';
                    } else {
                            echo $i . ' ';
                    }
            } // End of FOR loop.

            // If it's not the last page, make a Next button:
            if ($current_page != $pages) {
                    echo '<a href=' . $base_url . '?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '>Next</a>';
            }

            echo '</p>'; // Close the paragraph.

    } // End of links section.
    
}



function role_toString($role){
    switch($role){
        case '10':
            return 'Member';
            break;
        case '30':
            return 'Artist';
            break;
        case '50':
            return 'Producer';
            break;
        case '100':
            return 'Admin';
            break;
        default:
            return 'status pending';
            break;
    }
}


    
    



