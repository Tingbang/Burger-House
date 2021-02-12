<?php
//Database Connection
//Database details
$servername="localhost";
$username_db="******";
$password_db="******";
$db="burgershop";

//Error handling
//Try to connect to the database
//If the connection fails then catch the exception
try{
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username_db,$password_db);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                
    }//In the event of the try failing, an exception is thrown to catch the error
    catch(PDOException $e) 
    {
       echo "Connection Failed" .$e->getMessage();
    }
    
?>