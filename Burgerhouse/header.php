<!DOCTYPE html>

<!--Darren Lally -->
<!--Graded Unit 2-->
<!--This document will be applied to all pages on the website as it is just a header-->
<!--use jquery to check if pages are clicked to set actives-->
<html>
  <head>
    <title>J & I's Burger House</title>
    <meta charset="utf-8">
    <meta name ="viewport" content ="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    
    <!--Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    
    <!--Bootstrap Toggle-->
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    
    <script src="https://use.fontawesome.com/a476f630fd.js"></script>
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css" integrity="sha384-5SOiIsAziJl6AWe0HWRKTXlfcSHKmYV4RBF18PPJ173Kzn7jzMyFuTtk8JA7QQG1" crossorigin="anonymous">
    <!--Personal Stylesheet -->
    <link rel="stylesheet" type="text/css" href="introcss.css"/>
  </head>
  
    <body data-spy="scroll" data-target="#myNav" data-offset="100">
  <!----------------------------- NAVIGATION--------------------------->
       <!--Bootraps nav class that fixes it to the top, exapnds the full width of the screen and changes the color to dark-->
       <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark" id="myNav" role="navigation"> <!--Nav start-->
       <!--Start Container-fluid - Makes sure everything spans the full witdh-->
       <div class="container-fluid">
          <!--Navbar Logo--->
            <a href ="index.php"class="navbar-brand" href="#" id="cowimg">
              <img src="img/cow-frontal-head.png" style="display: inline-block;"/>
            </a>
          <!--End of Navbar Logo-->
          
          <!--Title-->      
            <div class ="navbar-header">
              <a href ="#" class ="navbar-brand">J & I 's Burger House</a>
            </div> 
          <!--End of Header--->

              <!-- Creates the toggle button when the width is decreased, and links it to menu items under the div id="collapseElements" -->
            <button type="button" class="navbar-toggler" data-toggle="collapse" aria-expanded="false" arai-controls="collapseElements" data-target="#collapseElements">
                    &#9776;
            </button>   <!--Close Button-->
                  
                  <!------------- Main Nav Menu ------------->
                  <div class ="collapse navbar-collapse" id="collapseElements">
                     <ul class="navbar navbar-nav mr-auto">
                         <li class ="scroll nav-item">
                            <a class="nav-link" href="index.php">Home <span="sr-only"></span></a>
                          </li>
                         <li class="scroll nav-item">
                            <a class="nav-link" href="index.php#about">About</a>
                          </li>
                         <li class="nav-item">
                            <a class="nav-link" href="order.php">Menu</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="review_page.php">Reviews</a>
                         </li>
                         <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contact Us</a>
                         </li>
                    </ul><!--Ends main nav items--->
                    
                    <?php
                    //If an admin is logged in then change the navlinks to a bootstrap dropdown link and a logout button
                    if ($_SESSION['admin']){
                      echo '<ul class="navbar navbar-nav ml-auto"> <!--Sign Up and Log in links which are pulled to the right via "ml-auto"--->
                         <li class ="nav-item">
                            <div class="dropdown show">
                              <a class="btn btn-secondary dropdown-toggle" href="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 Admin Panel
                              </a>
                            
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="admin_panel.php">Dashboard</a>
                                <a class="dropdown-item" href="modify_order.php">Modify Order</a>
                                <a class="dropdown-item" href="delete_review.php">Delete Reviews</a>
                                <a class="dropdown-item" href="modify_stock.php">Modify Stock</a>
                              </div>
                            </div>
                          </li>
                         <li class="nav-item">
                            <a class="nav-link" href="logout.php">Log Out</a>
                          </li>
            
                          </div>  <!--Ends collapse div--->
                        </div>
                        </nav>';
                    } //End of admin check
                    
                    //If a user is logged in changed the navlinks to the a boostrap dropdown box and log out button
                    elseif ($_SESSION['username']){
                      //Sets the dropdown link to the username of the current user who is logged in
                      $name = $_SESSION['username'];
                      
                      echo '<ul class="navbar navbar-nav ml-auto"> <!--Sign Up and Log in links which are pulled to the right via "ml-auto"--->
                         <li class ="nav-item">
                            <div class="dropdown show">
                              <a class="btn btn-secondary dropdown-toggle" href="" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 ' .$name .'
                              </a>
                            
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="post_review.php">Post Review</a>
                                <a class="dropdown-item" href="previous_orders.php">View Previous Orders</a>
                                <a class="dropdown-item" href="personal_details.php">Personal Details</a>
                              </div>
                            </div>
                          </li>
                         <li class="nav-item">
                            <a class="nav-link" href="logout.php">Log Out</a>
                          </li>
            
                          </div>  <!--Ends collapse div--->
                        </div>
                        </nav>';
                    }
                    //If no one is logged on display the login/signup links
                    else if(!isset($_SESSION['username']) || ($_SESSION['admin']))
                    {

                      echo '<ul class="navbar navbar-nav ml-auto"> <!--Sign Up and Log in links which are pulled to the right via "ml-auto"--->
                         <li class ="nav-item">
                            <a class="nav-link" href="signup.php">Sign up</a>
                          </li>
                         <li class="nav-item">
                            <a class="nav-link" href="login.php">Log in</a>
                          </li>
            
                    </div>  <!--Ends collapse div--->
                  </div>
                  </nav>';
                  
                    } //End of else
                    
                    ?> <!-- Close PHP -->
    <!-- End of Navigation -->
    
    
  
    

