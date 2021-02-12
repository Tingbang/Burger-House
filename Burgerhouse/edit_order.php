<?php
ob_start();
session_start();
include 'header.php';

include 'Classes/admin.php';
//Checks if an admin is logged in
//if they arent they are redirected back to index.php
if(!isset($_SESSION['admin'])){
  header ('Location: index.php');
}

//Creates an object of the Admin Class
$admin_obj = new Admin();
//Calls the edit_order function
$admin_obj->edit_order($conn);

//If the form is submitted run the
//Update order function
if(isset($_POST['submit'])){
    
    $admin_obj->update_order($conn);
}

?>

<!--Container-->
<div class="container">
    <!--Start Form-->
    <form id ="form" action="edit_order.php?id=<?php $admin_obj->get_mod_id();?>" method ="POST"> <!--Form action is set to post-->
        <h1 class="display-4 text-center">Edit Order</h1> <!--Header-->
         <!--Rating input box-->
         <span>Order Details:</span><textarea class = "form-control" name="details" type="text"><?php echo $admin_obj->get_mod_details(); ?></textarea><br>
         <!--Review content text area -->
         <span>Order Address:</span><textarea class = "form-control" name="address" type="text"><?php echo $admin_obj->get_mod_address(); ?></textarea>
         <input type ="hidden" name ="id" value ="<?php echo $admin_obj->get_mod_id();?>">
         <!--Submit Button-->
         <input type="submit" name ="submit" id = "submit"  class="btn btn-primary" value="Submit"></input>
    </form><!--End of form-->
</div><!--End of container -->

<?php
include 'eof.php';
?>
</body><!--End of body-->
</html><!--End of html (starts in 'header.php')-->

<?php ob_end_flush(); ?>