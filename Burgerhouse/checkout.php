<?php
ob_start();
//Start the session
session_start();

//Error Handling, if the user attempts to go to the checkout page with nothing in their basket
//They are re-directed to the order page to add items to their basket
if(empty($_SESSION['shopping_cart'])){
    header('Location: order.php');
}

//Includes
include('header.php');
include ('Classes/cart.php');
include ('Classes/order.php');
include ('Classes/products.php');
include 'Classes/checkout_class.php';


//Creates an object of the Cart Class
$cart = new Cart();
//Creates an object of the Checkout Class
$handler_obj =  new Checkout();
//Call to auto_fill function
//which will auto fill the users details
//if they are logged in and have their details saved.
$handler_obj->auto_fill($conn);

//If the pay by cash button is pressed then
if(isset($_POST['submit'])){ 
     //Post all of the form details into variables
     //and then check they are all formatted correctly
     //and arent empty.
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
         //If all form data is correct then run the finalise_order function inside of the
         //Checkout class, which will do all of the checks and submit the order details inside the database.
         $handler_obj->finalise_order($conn);
     }
     $error .= "</div>";
}
//If there is an error display it
echo $error;
?>


<!--Check out form -->
<form action ="" method="post" id="form">

    <div class="row"> <!--Start Row-->
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

                </div><!--End of Personal details (6 columns long)-->
                
                <!--Address-->
                <div class="col-md-6">
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
                </div> <!--End of address (6 columns long)-->

            </div><!--new row-->
        </div><!--8 Columns long-->
        
         <!--Order Summary -->
        <div class="col-md-4">
        <!--The .well class adds a rounded border around an element with a gray background color and some padding -->
            <div class="well">
                <h4 class="text-center">Your Order</h4>
                <hr>
                <p><?php $cart->orderSummary() ;?></p>
                <p id="delivery"><?php $error .= gettype ($cart->print_total());?></p>
                <p><?php $error .= $cart->get_name(0);?></p>
                <p>*Orders for delivery will be charged an extra £1.50 upon check out</p>
            </div><!--End of well-->
        </div><!-- 4 columns long-->
        
        
        <!--Payment-->
        <div class="col-md-4">
            <h3>Payments</h3>
            <hr>
            
            <a href="check-out-process.php" class="btn btn-info button">PayPal</a>

            <input type="submit" name ="submit" id = "submit"  class="btn btn-primary" value="Pay Cash"></input>
            
            <label>
                <input type="checkbox" name="check" id="check" checked/>
                <input type="hidden" name="hidden_check" id="hidden_check" value="Collection"/>
            </label>
            <br>
        
            <h3>Pay by Card</h3>
            <div class="form-group">
                <label for="card_num">Card Number</label>
                <input type="text" name ="card_num" id="cardnum"  class="form-control">
            </div>
            <div class="form-group">
                <label for="sec_num">Security Number</label>
                <input type="text" name ="sec_num" class="form-control">
            </div>
            <div class="form-group">
                <label for="card_name">Card Holder Name</label>
                <input type="text" name ="card_name" id="card_name" class="form-control">
            </div>
            <input type="submit" name ="debit" id = "debit"  class="btn btn-primary" value="Pay Debit"></input>

        </div>
    </div><!--End of Row-->
</form>

<?php

include 'eof.php';

?>

<!--This jQuery checks what delivery_type has been selected by the user
if it is set by collection or delivery then that is what is going to be posted and
then submitted into the database-->
<script>
$(document).ready(function(){
    var $form = $('#form');
    /*global $*/

    $('#check').bootstrapToggle({
       on: 'Collection',
       off: 'Delivery',
       onstyle: 'success',
       offstyle: 'warning'
    });
    
    $('#check').change(function(){
       if($(this).prop('checked')){
           $('#hidden_check').val('Collection');
       }
       else{
           $('#hidden_check').val('Delivery');
       }
    });
});


</script>

<?php ob_end_flush();?>