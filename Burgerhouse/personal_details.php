<?php
ob_start();
session_start();
include 'header.php';
include 'Classes/checkout_class.php';

//Checks that if a user isn't logged in then
//they are redirected back to login.php
if(!isset($_SESSION['id'])){
    header("Location: login.php");
}

//Creates an object of the Checkout() Class
$handler_obj =  new Checkout();

//If the form is submited
//It will run through each input and make sure each is valid
//If every input is valid then it will run a function of the Checkout Class called auto_fill()
//This function will run an SQL command to retrieve information from the user_details table
//If the user exists already within the database then update_user_details($conn) function will be ran
//Which will update the already existing details inside
//If the details don't already exist inside the database then add_user_details($conn) is ran
//which will insert the users data into the database.
//Error Handling: These seperate functions and checks prevent the same details being inserted if they already exist,
//it runs an update instead to modify the existing record.
if(isset($_POST['submit'])){ 
     //If the form is submitted post these variables
     //and check they are formtated correctly and are valid
     $full_name = $_POST['name'];
     $email = $_POST['email'];
     $address1 = $_POST['address1'];
     $address2 = $_POST['address2'];
     $city = $_POST['city'];
     $postcode = $_POST['postcode'];
     $phonenumber = $_POST['number'];
     
     $error = "<div id= 'error' class='alert alert-danger'>";
     
     if($full_name == "" || strlen($full_name) == 0){
      $error .= "Full name is a required field!<br>";
     }
     elseif($email == "" || strlen($email) == 0){
      
      $error .= "Email is a required field!<br>";
      
     }
     elseif($address1 == "" || strlen($address1) == 0){
      
      $error .= "Address1 is a required field!<br>";
      
     }
     elseif($address2 == "" || strlen($address2) == 0){
      
      $error .= "Address2  is a required field!<br>";
      
     }
     elseif($city == "" || strlen($city) == 0){
      
      $error .= "City is a required field!<br>";
      
     }
      elseif($postcode == "" || strlen($postcode) == 0){
      
      $error .= "PostCode is a required field!<br>";
      
     }
      elseif($phonenumber == "" || strlen($phonenumber) == 0){
      
      $error .= "Phone number name is a required field!";
      
     }
     elseif(strlen($phonenumber) < 11){
         $error .= "Invalid Phone Number - Uk numbers are atleast 11 digits long";
         
     }
     else{
         $handler_obj->add_user_details($conn);
     }
     $error .= "</div>";
     
}
  
echo $error;

?>

<form action ="" method="post" id="form">

    <div class="row justify-content-cente"> <!--Start Row-->
        <div class="col-md-8">
            <div class="row">
                
                <!--Personal Details-->
                <div class="col-md-6">
                    <h3>Your Details</h3>
                    <hr>
                    
                    <div class="form-group">
                        <label for="Name">Full Name</label>
                        <input type="text" name ="name" id="name" class="form-control" value="<?php echo $handler_obj->get_autofill_name(); ?>">
                    </div><!--Form-group-->
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name ="email" id="email" class="form-control" value="<?php echo $handler_obj->get_autofill_email(); ?>">
                    </div><!--Form-group-->
                
                <!--Address-->
   
                    <h3>Home Address</h3>
                    <hr>
                    <div class="form-group">
                        <label for="address1">Address Line 1</label>
                        <input type="text" name ="address1" id="address1"  class="form-control" value="<?php echo $handler_obj->get_autofill_address1(); ?>">
                    </div>
                    
                     <div class="form-group">
                        <label for="address2">Address Line 2</label>
                        <input type="text" name ="address2" id="address2" class="form-control" value="<?php echo $handler_obj->get_autofill_address2(); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="city">City/Town</label>
                        <input type="text" name ="city" id="city" class="form-control" value="<?php echo $handler_obj->get_autofill_city(); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="postcode">Postcode</label>
                        <input type="text" name ="postcode" id="postcode" class="form-control" value ="<?php echo $handler_obj->get_autofill_postcode(); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="number">Phone Number: </label>
                        <input type="text" name ="number" id="Number" class="form-control" value="<?php echo $handler_obj->get_autofill_phonenumber(); ?>">
                    </div>
                    <input type="submit" name ="submit" id = "submit"  class="btn btn-primary" value="Submit"></input>

            </div><!--new row-->
        </div><!--8 Columns long-->
    </div>
</form>

<?php
include 'eof.php';
ob_end_flush();
?>