<?php
ob_start();
session_start();
//If the user isn't an administrator then they are re-directed to the home page
if(!isset($_SESSION['admin'])){ header ('Location: index.php');}
//Includes
include 'header.php';           //Include header file
include 'Classes/admin.php';    //Include admin class
include 'Classes/review.php';   //Include review class

//Creates an object of the review class
//Gets the reviews from the database
$delete_obj = new Review();
$delete_obj->set_reviews($conn);

if(isset($_POST['submit'])){

    $delete_obj->delete_review($conn);
}
?>
 <header id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Admin Panel <small>Delete Reviews</small></h1>
          </div>
        </div>
      </div>
 </header>

  <section id="breadcrumb">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="active">Delete Review</li>
      </ol>
    </div>
  </section>

  <section id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
              <a href="admin_panel.php" class="list-group-item"> Dashboard</a>
              <a href="modify_order.php" class="list-group-item  main-color-bg">Modify Orders</a>
              <a href="delete_review.php" class="active list-group-item">Delete Reviews</a>
              <a href="modify_stock.php" class="list-group-item">Modify Stock</a>
          </div>
          
          <!--Displays all reviews stored inside the database-->
          <div class="col-md-9">
              <h3>Delete Reviews</h3>
              <div class="text-center review">
                <?php
                for($x = 0; $x < $delete_obj->get_rows(); $x++){
                    ?>
                    <form action="delete_review.php?id=<?php echo($delete_obj->get_id($x));?>" method="POST">
                    <!--<h3><a href="review_page.php?id=<?php //echo($review_obj->get_id($x));?>">click me</a></h3>-->
                    
                    <h5><?php echo($delete_obj->get_content($x));?></h5>
                    <h5><?php echo($delete_obj->get_rating($x));?>/5 <i class="fas fa-star" style="color:#8A2BE2;"></i></h5>
                    <p>User: <?php echo($delete_obj->get_user($x));?></p>
                    <h5><?php echo($delete_obj->get_date($x));?></h5><span>
                    <input id ="delete" class ="btn btn-info"type ="submit" name ="submit" value="Delete"></input></span>
                    <br>
                    <hr>
                    </form>
                    <?php
                    } //End of for
                    ?>
              </div>
          </div><!--End of 9 columns long-->
        </div> <!--End of row-->
      </div><!--End of containter-fluid -->
   </section><!--End of section
   
<?php include 'eof.php';
ob_end_flush();?>