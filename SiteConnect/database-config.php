<?php
   // define database related variables
   $database = 'simpledb';
   $host = '127.0.0.1';
   $user = 'root';
   $pass = '';

   // try to conncet to database
   try{
      $dbh = new PDO("mysql:dbname={$database};host={$host}", $user, $pass);
       //set PDO error mode to exception which allows to handle exception
       $dbh->setAtribute(PDO::ATTR_ERRMODE, PDO::ERROR_MODEEXCEPTION)
    }

   catch(PDOException e){
      echo 'connection failed';
   }

   
?>
