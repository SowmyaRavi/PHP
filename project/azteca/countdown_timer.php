
<!-- PHP code for countdown timer it compares current date with event date and outputs accordingly-->

<?php 
     date_default_timezone_set('America/Los_Angeles');
      $event = strtotime("2016-04-05 17:30:00"); 
      $current=time();
      $diffference =$event-$current;
      $days=floor($diffference / (60*60*24));
      if ($days==0) {
        echo "This event is today,see you there!";
      }else if ($days<=-1){
        echo "Sorry this event is over, please subscribe to know upcoming events!";
      }else echo "$days days left for the event!";

      ?>
