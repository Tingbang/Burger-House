<?php
ob_start();
//Include links to class and header file
include 'Classes/order.php';
include 'header.php';
//Error handling
//If the user attempt to access this page without being logged in
//they are rediret to login to their account
if(!isset($_SESSION['username'])){
  header ('Location: login.php');
}

//Creates an object of the Order class
$previous_orders = new Order();
//Calls the view_previous_orders function which will retrieve
//All of the current users previous orders
$previous_orders->view_previous_orders($conn);

?>
<div class="container-fluid">
    <div class="prev">
        <?php
        //For loop returns any previous orders that have been made
        //get_prev_rows() counts the number of records returned by the SQL Statement
        //
        for($x = 0; $x < $previous_orders->get_prev_rows(); $x++)
        {
            ?>
            <!--<h3><a href="review_page.php?id=<?php //echo($review_obj->get_id($x));?>">click me</a></h3>-->
            <h5 class="text-center">Order:<br><?php echo($previous_orders->get_prev_details($x));?><br></h5>
            <h5 class="text-center"><br>Date/Time Placed:<br> <?php echo($previous_orders->get_prev_date($x));?></h5>
            <br>
            <hr>
            <?php
        } //End of for loop

        ?>
    </div> <!-- End of prev-->
</div> <!--End of containter-->
<!--Include footer.php-->
<?php include 'footer.php';

ob_end_flush();?>