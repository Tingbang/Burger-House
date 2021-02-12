<?php
session_start();                    //Starts the session

include 'header2.php';              //Including the header file
include 'Classes/products.php';     //Including the Product Class
include 'Classes/cart.php';         //Including the Cart Class

//Instantiate $prod_obj to an object of the Product Class
//When this code is ran its going to run the constructor
//Which contains the SQL statement to retrieve 
$prod_obj = new Products($conn); 

//Instantiate $cart_obj to an object of the Cart Class
//'$cart_obj->addCart()' listens until the add to cart button is pressed
// and it will launch that function and add the new item to the cart (session)

//'$cart_obj->removeItemt()' listens until the add to cart button is pressed
// and it will launch that function and remove the item from the cart (session)
$cart_obj = new Cart(); 
$cart_obj->addCart();   
$cart_obj->removeItem();

//Makes a call to the Cart Class, to display the Cart to the user
echo $cart_obj->displayCart();
?> 

<!-- Start container -->
<div class="container" id = "tabs">
   <!--If a product is out of stock then display the item that is out of stock.-->
   <?php echo $prod_obj->check_stock();?>
    
    <!--Bootstrap 4's Class .row allows me to create a space that takes 12 columns in width-->
    <div class="row">  
    
        <!-------------Menu Tab----------------------->
        
        <!-- Any Element given under the '#burger' id, will be stored under the burger tag-->
        <!-- the same thing will happen with the other tabs in the menu-->
        <ul class="tabs tabs-fixed-width z-depth-1">
            <li class="tab"><a href="#burger">Burgers</a></li>
            <li class="tab"><a class="active" href="#sandwhich">Sandwhiches </a></li>
            <li class="tab"><a href="#sides">Sides</a></li>
            <li class="tab"><a href="#dessert">Desserts</a></li>
            <li class="tab"><a href="#drinks">Drinks</a></li>
          </ul> 
        <!------------- End of Tabs ----------------->

        <!------------- Menu----------------------->
        <!--Each one of these product sections will have a class of bootstrap4's col s12
            So that when the products are being displayed they are taking up the full
            12 columns that a row has-->
            
            <div id="burger" class="col s12">
                <?php
                //Loops through each burger product and displays is under the burger tab
                //using the getters inside my Product Class
                for($x = 0; $x <= 6; $x++){
                    ?>
                <form method ="POST" class="" action = "order.php?action=add&id=<?php echo $prod_obj->get_ID($x);?>">
                <div id="cardMenu" class="col-md-4 col-sm-4"> <!--Takes up 4 columns within the row (12 columns in total)-->
                    <h4><?php echo $prod_obj->get_Name($x); ?></h4> <!--Displays the name of the product -->
                    <h6><?php echo $prod_obj->get_Description($x); ?></h6><!--Displays the description of the product -->
                    <h5 class="card-title">Price: £<?php echo $prod_obj->get_Price($x); ?></h5> <!--Displays the price of the product -->
                    <input id="prod_name" type ="hidden" name ="prod_name" class ="btn btn-info" value="<?php echo $prod_obj->get_Name($x) ?>"/>
                    <input type ="hidden" name ="prod_price" class ="btn btn-info" value="<?php echo $prod_obj->get_Price($x); ?>"/>
                    <input type ="text" name="quantity" class="form-control" value="1"/>
                    <input id="add_to_cart" type ="submit" name ="add_to_cart" class="btn btn-info" value="Add">
                </div><!--End of Product -->
                </form> <!--End of form-->

                <?php
                }//End of For loop
                ?>
            </div><!--End of burger-->
        
        
        
            <div id="sides" class="col s12">
                <?php
                //Loops through each side product and displays is under the sides tab
                //using the getters inside my Product Class
                for($x = 7; $x <= 12; $x++){
                    ?>
                
                <form method ="POST" class="" action = "order.php?action=add&id=<?php echo $prod_obj->get_ID($x);?>">
                    <div id="cardMenu" class="col-md-4 col-sm-4"> <!--Takes up 4 columns within the row (12 columns in total)-->
                        <h4><?php echo $prod_obj->get_Name($x); ?></h4> <!--Displays the name of the product -->
                        <h6><?php echo $prod_obj->get_Description($x); ?></h6><!--Displays the description of the product -->
                        <h5 class="card-title">Price: £<?php echo $prod_obj->get_Price($x); ?></h5> <!--Displays the price of the product -->
                        <input type ="hidden" name ="prod_name" class ="btn btn-info" value="<?php echo $prod_obj->get_Name($x) ?>"/>
                        <input type ="hidden" name ="prod_price" class ="btn btn-info" value="<?php echo $prod_obj->get_Price($x); ?>"/>
                        <input type ="text" name="quantity" class="form-control" value="1"/>
                        <input type ="submit" name ="add_to_cart" class="btn btn-info" value="Add">
                    </div><!--End of Product -->
                </form> <!--End of form-->
                <?php
                }//End of For loop
                ?>
            </div><!--End of Sidesr-->

            <div id="sandwhich" class="col s12">
                <?php
                //Loops through each sandwhich product and displays is under the Sandwhich tab
                //using the getters inside my Product Class to display the products
                for($x = 13; $x <= 18; $x++){
                    ?>
                
                <form method ="POST" class="" action = "order.php?action=add&id=<?php echo $prod_obj->get_ID($x);?>">
                    <div id="cardMenu" class="col-md-4 col-sm-4"> <!--Takes up 4 columns within the row (12 columns in total)-->
                        <h4><?php echo $prod_obj->get_Name($x); ?></h4> <!--Displays the name of the product -->
                        <h6><?php echo $prod_obj->get_Description($x); ?></h6><!--Displays the description of the product -->
                        <h5 class="card-title">Price: £<?php echo $prod_obj->get_Price($x); ?></h5> <!--Displays the price of the product -->
                        <input type ="hidden" name ="prod_name" class ="btn btn-info" value="<?php echo $prod_obj->get_Name($x) ?>"/>
                        <input type ="hidden" name ="prod_price" class ="btn btn-info" value="<?php echo $prod_obj->get_Price($x); ?>"/>
                        <input type ="text" name="quantity" class="form-control" value="1"/>
                        <input type ="submit" name ="add_to_cart" class="btn btn-info" value="Add">
                    </div><!--End of Product -->
                </form> <!--End of form-->
                <?php
                }   //End of For loop
                
                ?>
            </div><!--End of sandwhich-->  


            <div id="dessert" class="col s12">
                <?php
                //Loops through each Dessert product and displays is under the burger tab
                //using the getters inside my Product Class
                for($x = 19; $x <= 24; $x++){
                    ?>
                
                <form method ="POST" class="" action = "order.php?action=add&id=<?php echo $prod_obj->get_ID($x);?>">
                    <div id="cardMenu" class="col-md-4 col-sm-4"> <!--Takes up 4 columns within the row (12 columns in total)-->
                        <h4><?php echo $prod_obj->get_Name($x); ?></h4> <!--Displays the name of the product -->
                        <h6><?php echo $prod_obj->get_Description($x); ?></h6><!--Displays the description of the product -->
                        <h5 class="card-title">Price: £<?php echo $prod_obj->get_Price($x); ?></h5> <!--Displays the price of the product -->
                        <input type ="hidden" name ="prod_name" class ="btn btn-info" value="<?php echo $prod_obj->get_Name($x) ?>"/>
                        <input type ="hidden" name ="prod_price" class ="btn btn-info" value="<?php echo $prod_obj->get_Price($x); ?>"/>
                        <input type ="text" name="quantity" class="form-control" value="1"/>
                        <input type ="submit" name ="add_to_cart" class="btn btn-info" value="Add">
                    </div><!--End of Product -->
                </form> <!--End of form-->

                <?php
                }//End of For loop
                
                ?>
            </div><!--End of desserts-->



            <div id="drinks" class="col s12">
                <?php
                //Loops through each Drink product and displays is under the burger tab
                //using the getters inside my Product Class
                for($x = 25; $x <= 32; $x++){
                    ?>
                <form method ="POST"  class="" action = "order.php?action=add&id=<?php echo $prod_obj->get_ID($x);?>">
                    <div id="cardMenu" class="col-md-4 col-sm-4"> <!--Takes up 4 columns within the row (12 columns in total)-->
                                <h4><?php echo $prod_obj->get_Name($x); ?></h4> <!--Displays the name of the product -->
                                <h6><?php echo $prod_obj->get_Description($x); ?></h6><!--Displays the description of the product -->
                                <h5 class="card-title">Price: £<?php echo $prod_obj->get_Price($x); ?></h5> <!--Displays the price of the product -->
                                <input type ="hidden" name ="prod_name" class ="btn btn-info" value="<?php echo $prod_obj->get_Name($x) ?>"/>
                                <input type ="hidden" name ="prod_price" class ="btn btn-info" value="<?php echo $prod_obj->get_Price($x); ?>"/>
                                <input type ="text" name="quantity" class="form-control" value="1"/>
                                <input type ="submit" name ="add_to_cart" class="btn btn-info" value="Add">
                    </div><!--End of Product -->
                </form> <!--End of form-->

                <?php
                }//End of For loop
                ?>
            </div><!--End of drinks-->
            
    </div><!--End of row-->
</div> <!--End of container -->


    
</script>

         
<?php
//Include End of file
include 'eof.php';

?>
