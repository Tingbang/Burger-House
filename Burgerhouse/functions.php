<?php

function detail_check(){
    include("connect.php");
    if (isset($_POST['submit'])){
        //Takes in details that are posted from the form
        $username= $_POST['username'];
        $password = $_POST['password1'];
        $conf_pass=$_POST['password2'];
        $email = $_POST['email'];
        $dob=$_POST['dob'];
        
        $error = "<div id= 'error' class='alert alert-danger'>";      
         //If the username is blank then display error
         if($username == "" || strlen($username) == 0){
          $error .= "Username is a required field!<br>";
         }
         //If the username is < 8 characters long then display error
         elseif(strlen($username) < 8 ){
          $error .= "Usernames must be 8 characters or more!<br>";
         }
         
         //If the email is blank then display error
         elseif($email == "" || strlen($email) == 0){
          
          $error .= "Email is a required field!<br>";
         }
         //If the password is blank then display error
         elseif($password == "" || strlen($password) == 0){
          
          $error .= "Password is a required field!<br>";
          
         }
         //Checks if passwords is alphanumeric
         elseif(!ctype_alnum($password) || (!ctype_alnum($conf_pass))){
          
          $error .= "Passwords must contain both letters and characters<br>";
         }
         
         //If the passwords are < 8 characters long display error
         elseif(strlen($password) && strlen($conf_pass) <8){
             $error .= "Passwords must have atleast 8 characters";
         }
         //If the passwords don't match then display error
         elseif($password != $conf_pass){
             $error .= "The Passwords you have entered don't match!";
         }
         //If DOB is empty display error
         elseif (empty($dob)){
          
          $error .= "DOB is a required field.<br>";
          
         }else{
          //If there are no errors then 
          //Set the error string to blank
             $error = "";
             //Create an object of the User() class
             $register= new User();
             //Call the register function inside the User Class()
             $register->register($conn, $username, $password, $conf_pass, $email, $dob);
         }
        $error .= "</div>";
}
//Display Errors if any are made
echo $error;
    
}
?> <!--Close PHP-->