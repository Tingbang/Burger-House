<?php
ob_start();

session_start();
include 'header.php';
include 'Classes/user.php';

//User Object
$contact_obj = new User();

//When the form is submitted then
//The mail function is ran
if(isset($_POST)){
    $contact_obj->email();
    
}

?>

<!--Container-->
<div class="container">
    <!--Start Form-->
    <form id ="form" action="" method ="POST"> <!--Form action is set to post-->
        <h1 class="display-4 text-center">Contact Us!</h1> <!--Header-->
         <!--Rating input box-->
         <input class = "form-control" placeholder="Name: " name="name" type="text"><br>
         <!--Review content text area -->
         <textarea class = "form-control" placeholder="Message: " name="message" rows= "20" cols="50"></textarea>
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