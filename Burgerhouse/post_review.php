<?php
ob_start();
session_start();

//Checks if the user is an admin then
//they are redirected to the home page.
if(!isset($_SESSION['username'])){
  header ('Location: index.php');
}

//Include the navigation
include 'header.php'; 
//Start the session

//Include the review class
include 'Classes/review.php';
//Create an object of the Review Class->which will call the constructor which will
//instantiate the posted variables to local private variables.
$review_obj = new Review();

//The user must have an account and also must be logged in to post a review
//IF they arent logged in and try access this page they will be redirected
//to the review page where they can read the reviews.
if(!isset($_SESSION['username'])){
    $review_obj->redirect();
}

//This function checks if the form has been submitted/
//If it has been sent by post then its going to check if
//rating entered by the user is within the range of 0 and 5,
//anything under or over an error will be thrown
//else the review will be submitted into the database/
$review_obj->submit_review($conn);
?>

<!--Container-->
<div class="container">
    <!--Start Form-->
    <form id ="form" action="" method ="POST"> <!--Form action is set to post-->
        <h1 class="display-4 text-center">Post Review</h1> <!--Header-->
         <!--Rating input box-->
         <input class = "form-control" placeholder="Rating: " name="rating" type="number"><br>
         <!--Review content text area -->
         <textarea class = "form-control" placeholder="Content: " name="content" rows= "20" cols="50"></textarea>
         <!--Submit Button-->
         <input type="submit" name ="submit" id = "submit"  class="btn btn-primary" value="Submit"></input>
    </form><!--End of form-->
</div><!--End of container -->

<?php
include 'eof.php';
?>
</body><!--End of body-->
</html><!--End of html (starts in 'header.php')-->

<?php ob_end_flush();?>