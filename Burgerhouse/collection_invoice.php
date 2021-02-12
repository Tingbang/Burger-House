<?php
session_start();

//If there is nothing in the users basket they can't access page, however
//if they do have items in their basket then their session is cleared as
//the order has already been placed
if(!isset($_SESSION['shopping_cart'])){
    header("Location: index.php");
}else{
    unset($_SESSION['shopping_cart']);    
}
include 'header.php';
?>

<div class="container h-100">
    
    <div class="row h-100 justify-content-center">
        
        <div class="col-lg-12">
            <h1 class="text-center">Order Success!</h1>
            
            <h1 class="text-center">Thank you for ordering at J & I's Burgerhouse!</h1>
            <br>
            <h1 class="text-center">Your order has been placed successfully</h1>
            <br>
            <h1 class="text-center">Your Estimated collection time is:
                <?php $newTime = date("H:i", strtotime(" +1 hour + 30 minutes"));
                echo $newTime; ?></h1>

        </div>    
        
    </div>
</div>