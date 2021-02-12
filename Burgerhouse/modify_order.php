<?php
ob_start();
session_start();
include 'header.php';

include 'Classes/admin.php';

//Checks if an admin is logged in
//if they arent they are redirected back to index.php
if(!isset($_SESSION['admin'])){
  header ('Location: index.php');
}

//Creates an object of the admin class and runs the modify_order function
$orders_obj = new Admin();
$orders_obj->modify_order($conn);

?>
 <header id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Admin Panel <small>Modify Orders</small></h1>
          </div>
        </div>
      </div>
 </header>

  <section id="breadcrumb">
    <div class="container-fluid">
      <ol class="breadcrumb">
        <li class="active">Modify Order</li>
      </ol>
    </div>
  </section>

    <section id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

              <a href="admin_panel.php" class="list-group-item"> Dashboard
              </a>
              <a href="modify_order.php" class="list-group-item active main-color-bg">Modify Orders</a>
              <a href="delete_review.php" class="list-group-item">Delete Reviews</a>
              <a href="modify_stock.php" class="list-group-item">Modify Stock</a>


          </div>
          <!--Displays all orders to the admin-->
          <div class="col-md-9">
              
              <h3>Modify Orders</h3>
              
              <div class="scrollable">
                  <?php
                  for($x = 0; $x < $orders_obj->get_ids_count(); $x++){
                    ?>
                    
                    
                    <p class="text-center"><?php echo($orders_obj->get_order($x));?></p>
                    <p class="text-center"><?php echo($orders_obj->get_address($x));?></p>
                    <p class="text-center">Order No: <?php echo($orders_obj->get_ids($x));?></p>
                    <p class="text-center">Customer: <?php echo($orders_obj->get_cust_name($x));?></p>
                    <h3><a href="edit_order.php?id=<?php echo($orders_obj->get_ids($x));?>">Edit</a></h3>
                    
                    <br>
                    <hr>
            
                  <?php
                  }
                  ?>
                  
              </div>
                    

          </div><!--End of 9 columns long-->

      </div> <!--End of row-->
  </div><!--End of containter-fluid -->
</section><!--End of section
<?php include 'eof.php';

ob_end_flush();?>
