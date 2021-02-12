<?php
require("header.php");                  //Requires the headerfile - contains navigation + references to bootstrap
include_once("Classes/user.php");       //References the User class - which is used inside "functions.php"
include_once("connect.php");            //Includes connection to the database
include ("functions.php");              //Inludes reference to my functions in order to call any
  

/*Local Function(detail_check()) that will check all of the inputs are formatted correctly
if not an error will be thrown. Also this function will only run when the submit button has been
clicked
*/
detail_check();
?>

    <div id ="signup" class ="view">
    <!--This container holds everything inside it and makes the background image
    span the full width of the page. Also when the width of the screen downscales
    to mobile and tablet sizes. The image and form is responsive and will fit accordingly
    -->
    <div class="container full-bg-img d-flex justify-content-center"> <!-- Using d-flex to fit into the appropriate column sizes-->
      
          <!--signup_cont is refers to the style sheet to set the margin
          and the color of the font to white -->
         <div id ="signup_cont">
        
            <!--Start Form-->
            <form id ="form" action="" method ="POST"> <!-- When the form is submitted, it is being sent by POST-->
              <div id = "error"></div><!--Any errors made will be displayed inside this div-->
              <h1 class="display-3 text-center">Register</h1> <!--Display-3 makes the font larger and stand out-->
              
              
              <!--form-group row justify-content-center creates a small area for the input + label
              to live inside, and it centre aligns it to the page-->
              
              <!--Username Input-->
              <div class="form-group row justify-content-center"> <!-- -->
                <label for="username" class="col-sm-4 col-form-label">Username: </label>
                <div class="col-sm-9">
                  <input type="text" name="username" class="form-control mt-4" id="username" placeholder="Username">
                </div>
                </div>
              
              <!--Email Input-->              
              <div class="form-group row justify-content-center">
                <label for="email" class="col-sm-4 col-form-label">Email: </label>
                <div class="col-sm-9">
                <input type="email" id ="email" name="email" class="form-control" placeholder="Email">
                </div>
              </div>
              
              <!--Date of Birth Input-->  
              <div class="form-group row justify-content-center">
                <label for="dob" class="col-sm-5 col-form-label">Date of Birth: </label>
                <div class="col-sm-9">
                <input type="date" id ="dob" name="dob" class="form-control" placeholder="DOB:" >
                </div>
              </div>
              
              <!--Password Input-->  
              <div class="form-group row justify-content-center">
                <label for="password1" class="col-sm-4 col-form-label">Password: </label>
                <div class="col-sm-9">
                  <input type="password" name="password1" id="password1" class="form-control" placeholder="Password" >
                </div>
                </div>
                
                <!--Confirm Password Input-->                  
                <div class="form-group row justify-content-center">
                <label for="password2" class="col-sm-4 col-form-label">Password 2: </label>
                <div class="col-sm-9">
                  <input type="password" name="password2" id="password2" class="form-control" placeholder="Password" >
                </div><!--end of column-->
                </div> <!--End of form-group -->
                
                <!--Submit Button--> 
              <div class="form-group row justify-content-center">
		          <input type="submit" name ="submit" id = "submit"  class="btn btn-primary" value="Submit"></input>
	          </div><!--End of form-group-->
	          
	        </form> <!--End of form -->    
	     </div> <!--End of signup_cont-->
            
    </div><!--End of container-->
    </div><!--End of Sign up-->

        
      
<?php include("footer.php"); ?> <!--Includes the footer and closes the body tag + HTMl -->
