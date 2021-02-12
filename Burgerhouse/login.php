<?php
ob_start();
session_start(); //Starts the session incase the user is already logged in
include("header.php");  //includes the header


//Checks if the user has submitted the form
if(isset($_POST['submit'])){
  include_once("Classes/user.php");   //Inlcudes the class file
  $conf_user = $_POST['conf_user'];  //Posts the input fromt he user a variable
  $conf_pass=$_POST['conf_pass'];    //Sets the variable
  
  //Creates an object of the User Class
  $obj = new User;
  //Calls function loginUser inside the class to log the user in
  $obj->loginUser($conn,$conf_user, $conf_pass);
}
?>
        <!--Container-->
        <div class="container">
          <!--Create a row and justifies the content inside it to the middle of the page-->
          <div class="row justify-content-center">
          <!--Start of form-->
            <form id ="form" action="" method ="POST">
              
              <h3>Login</h3>
              <div id = "error"></div>
              
              <!--Username Field-->
              <div class="form-group row justify-content-center">
                <label for="username" class="col-sm-4 col-form-label">Username: </label>
                <div class="col-sm-9">
                  <input type="username" name="conf_user" class="form-control mt-4" id="username" placeholder="Username">
                </div>
              </div>
              
              <!--Password Field-->
              <div class="form-group row justify-content-center">
                <label for="password1" class="col-sm-4 col-form-label">Password: </label>
                <div class="col-sm-9">
                  <input type="password" name="conf_pass" id="conf_password" class="form-control" placeholder="Password" >
                </div>
              </div>
        
              <!-- Submit button !-->  
              <div class="form-group row justify-content-center">
		            <input type="submit" name ="submit" id = "submit"  class="btn btn-primary"></input>
	            </div>
	            
	            
	            </div> <!--row-->
            </form> <!--End of form -->
           </div><!-- End of Container-->
      
           <?php
           //include footer
           include("footer.php");
           ob_end_flush();
           ?>
           