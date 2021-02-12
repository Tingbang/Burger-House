<?php
ob_start();
session_start();
include 'header.php';
include 'Classes/review.php';

//Creates a new object of the Review Class
$review_obj = new Review();
//Calls the set_review function
//which will retrieve all reviews from the database
$review_obj->set_reviews($conn);
?>

<div class="container-fluid">
    <div class="review text-center">
        <h2 ckass="text-center">Reviews!</h2>
        <?php
        //Loops through all of the reviews stored inside the database
        for($x = 0; $x < $review_obj->get_rows(); $x++){
            ?>
            <!--Display Review Content-->
            <h5 class="text-center"><?php echo($review_obj->get_content($x));?></h5>
            <h5 class="text-center"><?php echo($review_obj->get_rating($x));?>/5 <i class="fas fa-star" style="color:#8A2BE2;"></i></h5>
            <p class="text-center">User: <?php echo($review_obj->get_user($x));?></p>
            <h5 class="text-center"><?php echo($review_obj->get_date($x));?></h5>
            <br>
            <hr>
            <?php
            
        }   //End of for loop
        ?>
    </div> <!--End of review class-->
</div><!--End of container00>


<?php include 'footer.php';
ob_end_flush();
?>