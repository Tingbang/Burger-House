<?php
ob_start();
session_start();
include 'header.php';
include 'Classes/admin.php';
include 'connect.php';

//If an admin isnt logged in
//anyone trying to access this page is going to be redirected to the index page
if(!isset($_SESSION['admin'])){
  header ('Location: index.php');
}

//Creates an object of the Admin Class
$modify_stock = new Admin();
//Gets the stock of the item
$modify_stock->get_stock($conn);

//If the form is submitted
//run this function that modifies
//the new stock
if(isset($_POST['submit'])){
    $modify_stock->modify_stock($conn);
}

?>

<!--Container-->

<div class="container">
    <!--Start Form-->
    <form id ="form" action="modify_stock_handler.php?id=<?php $modify_stock->get_stock_id();?>" method ="POST"> <!--Form action is set to post-->
        <h1 class="display-4 text-center">Edit Product</h1> <!--Header-->
         <!--Rating input box-->
         <span>Product</span><textarea class = "form-control" name="details" type="text"><?php echo $modify_stock->get_stock_name(); ?></textarea><br>
         <!--Review content text area -->
         <span>Quantity:</span><textarea class = "form-control" name="quantity" type="text"><?php echo $modify_stock->get_stock_qty(); ?></textarea>
         <input type ="hidden" name ="id" value ="<?php echo $modify_stock->get_stock_id();?>">
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


