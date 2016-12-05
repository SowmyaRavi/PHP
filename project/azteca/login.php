<?php

//Page for login

  // Include the configuration file:
  require ('../includes/config-inc.php'); 

  // Set the page title and include the HTML header:
  $page_title = 'Welcome to AztecA Studios Corp Web Site!';
  include (HEADER);

  // Need the database connection:
  include(PDO);
  try{
    $q= 'SELECT page FROM pages_table where id=4';
    $query=$dbh->prepare($q);
    $query->execute();

    while ($row = $query->fetch(PDO::FETCH_ASSOC))
    {
      $body = $row['page'];
      
    }
    echo $body;
  }catch (PDOException $ex) {
    echo " Database can't be connected";
    echo  $ex->getMessage();
  }
  
  // Check for form submission:
  if($_SERVER['REQUEST_METHOD']=='POST'){
  //Retrieve the field values from our login formt
    if(isset($_POST['email'])){
    $email = $_POST['email'];
  }
  if (isset($_POST['pass'])) {
    $pass= $_POST['pass'];
  }
  $pass=sha1($pass);

  //Prepare our SELECT statement.
  $q = 'SELECT id, first_name, user_level,email  FROM azteca_users WHERE email=:email AND pass=:pass';
  $query=$dbh->prepare($q);
  $query->execute(array(':email' => $email, ':pass' => $pass));
  if($query->rowCount() == 0){
    echo '<p class="error">Either the email address or password entered do not match those on file</p>';

  }else{
   $row = $query->fetch(PDO::FETCH_ASSOC);

    // Set the session data:
    session_regenerate_id();
    $_SESSION['id']=$row['id'];
    $_SESSION['first_name']=$row['first_name'];
    $_SESSION['user_level'] = $row['user_level'];

    $_SESSION['last_timestamp'] = time(); //set new timestamp
    setcookie('last_loggedin', date("F j, Y")." -- ".date("g:i a"),time()+60*60*24,"/");

    session_write_close();
    
    // Redirect the user to home
      redirect_user();
    }

  }
  $pdo=null;
  include (FOOTER);
?>
