<?php
ob_start();
session_start();
include 'header.php';

include 'Classes/products.php';

//If the user isnt logged in as an admin
//They are then redirected to the index page
if(!isset($_SESSION['admin'])){
  header ('Location: index.php');
}
//Creates an object of the product Class
$stock_obj = new Products($conn);

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
        <li class="active">Modify Stock</li>
      </ol>
    </div>
  </section>

    <section id="main">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

              <a href="admin_panel.php" class="list-group-item"> Dashboard
              </a>
              <a href="modify_order.php" class="list-group-item  main-color-bg">Modify Orders</a>
              <a href="delete_review.php" class="list-group-item">Delete Reviews</a>
              <a href="modify_stock.php" class="list-group-item active">Modify Stock</a>


          </div>
          <!-- Displays all products to the screen along with their quantites-->
          <div class="col-md-9">
            <div class="scrollable text-center">
                <h3>Modify Orders</h3>
                  <?php
                  for($x = 0; $x < $stock_obj->get_rows(); $x++){
                    ?>
                    <div class="form-group">
                    <p class="text-center"><?php echo($stock_obj->get_Name($x));?></p>
                    <p class="text-center">Quantity Left:<?php echo($stock_obj->get_qty($x));?></p>
                    <div class="form-group row justify-content-center"> <!-- -->
                      <div class="col-sm-3">
                      </div>
                    </div>
                    <a class ="btn btn-primary"href="modify_stock_handler.php?id=<?php echo $stock_obj->get_id($x);?>">Modify</a>
                    <br>
                    <hr>
                    </div>
            
                  <?php
                  }
                  ?>
                </form> 
              </div> <!--End of div with class .scrollable-->
          </div><!--End of 9 columns long-->
      </div> <!--End of row-->
  </div><!--End of containter-fluid -->
</section><!--End of section
    
<?php include 'eof.php';
ob_end_flush();?>
