<!DOCTYPE html>
<!--Darren Lally -->
<!--Graded Unit 2-->
<!--use jquery to check if pages are clicked to set actives-->
<?php
//Start the session
session_start();

//Checks if the user is logged in.
if (isset($_POST["submit"])){
  include_once("Classes/user.php");  
  $mailing_list = new User();
  $mailing_list->email();

} //Checks if the user submits the button to substribe to the mailing list
?>

<!--------------------------------- NAVIGATION--------------------------------->
<header>
  <?php
    include("header.php");
  ?>
</header> <!--The body tag is already open inside header.php, therefor no reason to redeclare it.

<!--------------------------------- END OF NAVIGATION-------------------------->

<!----------------------------------------Banner Image -------------------------------------------------->
  <div id ="intro" class ="view">
    <div class="container full-bg-img d-flex align-items-center justify-content-center"> <!-- Using flex box to centre the title-->
      <div class="row d-flex justify-content-center">
        <div class="col-md-12 text-center">
            <h2 class="display-3 font-bold text-white">J & I's Burger House!</h2>
            <hr class="hr-white">
            
            <!--Description-->
            <h4 class="text-white my-4">Subscribe to our mailing list and get 20% off your first order!</h4>
            <h4 class="text-white my-4">You will be sent a confirmation email along with your discount code!</h4>
            <form action"" method="post">
            <div class="form-group row justify-content-center">
                <label for="email" class="text-white my-4 col-sm-4 col-form-label">Email: </label>
                <div class="col-sm-9">
                <input type="email" id ="email" name="email" class="form-control" placeholder="Email">
                </div>
            </div>
              <input type="submit" name ="submit" id = "submit"  class="btn btn-primary" value="Submit"></input>
            </form>
            
        </div>  <!--End of Column -->
      </div>  <!-- End of row-->
    </div><!--end of container-->
  </div><!--End of intro-->
<!------------------------------------End of banner image------------------------------------>  


<!------------------------------------Main Content----------------------------------------->
  <main id="about"class="main">
    <div class="container">
      <section id ="description" class ="text-center">
        <h2 class="mb-4">About us!</h2>
          <div class="row d-flex justify-content-center"> <!-- Using bootstrap flexbox to create a row and justify everything to the centre of the page-->
            <div id="about" class="col-md-12"> <!-- Set the column to medium size and to take up 8 colums-->
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo conidatat non proident,
                    sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident,
                    sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident,
                    sunt in culpa quiidatat non proident, sunt in culpa quisequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.idatat non proident,
                    sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident, sunt in culpa quiidaidatat non proident,
                    sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident, sunt in culpa quiidatat non proident,
                    sunt in culpa quiidatat non proident, sunt in culpa quitat non proident, sunt in culpa qui
              </p>
            </div> <!--End of Column -->
          </div> <!--End of Row -->
      </section><!--End of description-->
      
      <!--Bootstrap Card Class-->
      <section id="cards">
        <div class="row">
            <div class="col-sm-4"> <!--Takes up 4 columns within the row (12 columns in total)-->
              <div class="card ">
                  <div class="card-block ">
                      <h3 class="card-title">Place an order!</h3>
                      <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                      <a href="order.php" class="btn btn-primary d-flex">Place an order</a>
                  </div> <!--Close Card-Block -->
              </div><!--First card -->
            </div><!--End of Column-->
            
            <!--Creates a column with a width of 4-->
            <div class="col-sm-4">
              <div class="card">
                <div class="card-block">
                    <h3 class="card-title">Read our reviews!</h3>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <a href="review_page.php" class="btn btn-primary d-flex">Read our Reviews</a>
                </div><!--/.End of Block-->
              </div><!--/.End of card-->
            </div><!--/.End of column-small-4 -->
                
              <!--Creates a column with a width of 4-->  
            <div class="col-sm-4">
              <div class="card">
                <div class="card-block">
                  <h3 class="card-title">Any Questions?</h3>
                  <p class="card-text">Lorem ipsum dolor sit amett, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco sdhibf oifdhsodihsdfohdfih jnbdfh laboris nisi ut aliquip ex ea commodo consequat.</p>
                  <a href="contact.php" class="btn btn-primary d-flex">Contact Us</a>
                </div>
              </div>
            </div>
                
        </div><!--/.End of Row-->
        </section><!--End of Card Section-->
            
  </main> <!--End of main Section-->
      <!--Footer-->
  <footer id="footer1" class="page-footer mt-3 font-small color-dark pt-1">
      <!--Footer Links-->
    <div  class="container text-center text-md-left">
      <div id="row" class="row">
        <!--First column-->
                  <div class="col-md-4 col-lg-4 col-xl-3 mb-4">
                      <h6 class="text-uppercase font-weight-bold"><strong>J & I's Burger House</strong></h6>
                      <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                      <p>Insert text here: Lorem ipsum dolor sit ipsum dknskn ipsum qpjpsn </p>
                  </div>
                  <!--/.First column-->
      
                  <!--Second column-->
                  <div class="col-md-4 col-lg-2 col-xl-2 mx-auto mb-4">
                      <h6 class="text-uppercase font-weight-bold"><strong>Useful links</strong></h6>
                      <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                      <p><a href="">Your Account</a></p>
                      <p><a href="order.php!">Menu</a></p>
                      <p><a href="contact.php">Contact Us</a></p>
                      <p><a href="login.php">Login</a></p>
                  </div>
                  <!--/.Second column-->
      
                  <!--Third column-->
                  <div class="col-md-4 col-lg-3 col-xl-3">
                      <h6 class="text-uppercase font-weight-bold"><strong>Contact</strong></h6>
                      <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
                      <p><i class="fa fa-home mr-3"></i> Glasgow, G75 8NB, UK</p>
                      <p><i class="fa fa-envelope mr-3"></i> info@example.com</p>
                      <p><i class="fa fa-phone mr-3"></i> +44036767178</p>
  
                  </div>
                  <!--/.Third column-->
  
              </div><!--/End of row-->

          </div>
          <!--Footer Links-->
      
          <!-- Copyright-->
          <div class="footer-copyright py-3 text-center">
              <div class="container-fluid">
                  © 2017 Copyright: <strong> J & I'S Burger House</strong></a>
              </div>
          </div>
          <!--/.Copyright -->
      
  </footer>
 <!--/.Footer-->
            
<!--Importing Bootstrap-->
<!--Jquery -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<!--bootstrap JS-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>


