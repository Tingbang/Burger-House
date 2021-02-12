<?php
session_start();

if(!isset($_SESSION['admin'])){
  header ('Location: index.php');
}
include 'header.php';

include 'Classes/review.php';
include 'Classes/checkout_class.php';
include 'Classes/user.php';

//Creates an object of the Review Class
$review_obj = new Review();

//Calls the setreviews function to get all the reviews inside the database
$review_obj->set_reviews($conn);

//Creates an object of the Checkout Class
$orders_obj = new Checkout();
//Calls the amount_of_orders function to get all the orders made inside the database
$orders_obj->amount_of_orders($conn);

//Creates 2 object of the User Class
$user_obj = new User();
$admin_obj = new User();

//Call to count admin function 
//And count accounts function
$admin_obj->count_admin($conn);
$user_obj->count_accounts($conn);

//This page displays an overview of statistics of the website of
//how many reviews, accounts, orders and employee accounts have been made
?>
 <header id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Admin Panel <small>Manage Your Site</small></h1>
          </div>
        </div>
      </div>
 </header>

    <section id="breadcrumb">
      <div class="container-fluid">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

              <a href="admin_panel.php" class="list-group-item active main-color-bg"> Dashboard
              </a>
              <a href="modify_order.php" class="list-group-item">Modify Orders</a>
              <a href="delete_review.php" class="list-group-item">Delete Reviews</a>
              <a href="modify_stock.php" class="list-group-item">Modify Stock</a>


          </div>
          <div class="col-md-9">
              <h3>Overview</h3>
              <!--Displays the total amount of reviews made to the restaraunt-->
              <div id="adminpanels">
                  <h2 class="text-center z-depth-1">Total Reviews:<?php echo $review_obj->get_rows(); ?></h2>    
              </div>
              <!--Displays the total amount of orders made to the restaraunt-->
              <div id="adminpanels">
                  <h2 class="text-center z-depth-1">Orders Made:<?php echo $orders_obj->get_amount(); ?></h2>  
              </div>
              <!--Displays the total amount of accounts made to the restaraunt-->
              <div id="adminpanels">
                  <h2 class="text-center z-depth-1">Accounts:<?php echo $user_obj->get_count(); ?></h2>    
              </div>
              
              <div id="adminpanels">
                  <h2 class="text-center z-depth-1">Employee Accounts:<?php echo $admin_obj->get_count(); ?></h2>    
              </div>
            </div><!--End of 9 columns long-->

              </div> <!--End of row-->
              

          </div><!--End of containter-fluid -->
    </section><!--End of section
    
    
<?php include 'eof.php'?>
