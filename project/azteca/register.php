<?php

  //Page for subscribing users to artzteca studios

  // Include the configuration file:
  require ('../includes/config-inc.php'); 

  // Set the page title and include the HTML header:
  $page_title = 'Welcome to AztecA Studios Corp Web Site!';
  include (HEADER);

  // Need the database connection:
  include(PDO);
  try{
    $q= 'SELECT page FROM pages_table where id=3';
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

  // Check for form submission:
  if($_SERVER['REQUEST_METHOD']=='POST'){

  	
  	//Retrieve the field values from our registration form.
   $fname=!empty($_POST['fname'])?trim($_POST['fname']):null;
   $lname=!empty($_POST['lname'])?trim($_POST['lname']):null;
   $dob=!empty($_POST['dob'])?trim($_POST['dob']):null;
   $email=!empty($_POST['email'])?trim($_POST['email']):null;
   $password=!empty($_POST['password1'])?trim($_POST['password1']):null;
   $password=sha1($password);

    //Prepare our INSERT statement.
   $sql = 'INSERT INTO azteca_users (first_name, last_name,email,pass,dob,user_level) VALUES (:fname,:lname,:email,:password1,:dob,10)';
   $stmt=$dbh->prepare($sql);

      //Execute the statement and insert the new account.
   $result=$stmt->execute(array(
    ":fname"=>$fname,
    ":lname"=>$lname,
    ":email"=>$email,
    ":password1"=>$password,
    "dob"=>$dob));
   

   if($result){
     echo '<h2>submitted successfully</h2>';
     exit();
      }
    }

    $pdo=null;
    include (FOOTER);
 ?>
