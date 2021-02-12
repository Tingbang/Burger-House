<?php
include 'connect.php';
session_start();

//This class is going to handle all the items that the user puts into their order.
class Cart{
    
    //Private Variables
    private $total;
    private $productName = array();

    //This function will display the cart to the user.
    public function displayCart(){
        ?>
        <div class="item-absolute"> <!--This Class adds styling to the table and aligns it to the top left of the page-->
              <br /> 
                <!--table-responsive is a bootstrap class that makes the table responsive to any resolution it is being viewed at-->
                <div class="table-responsive w-120">  
                  <table id="table" class="table table">  
                    <tr><th colspan="5"><h3 >Order Details</h3></th></tr>   
                    <tr>  
                         <th width="40%">Product Name</th>  
                         <th width="10%">Quantity</th>  
                         <th width="20%">Price</th>  
                         <th width="15%">Total</th>  
                         <th width="5%">Action</th>  
                    </tr>  
                    <?php   
                    
                    if(!empty($_SESSION['shopping_cart'])):     //Making sure that the array isnt empty
                        
                         $total = 0;                            //Set $total to 0;
                    
                         foreach($_SESSION['shopping_cart'] as $key => $product):   //For each item inside of the session(cart)
                         
                    //Print them out inside the table     
                    ?>  
        
                    <tr>  
                       <td id ="name"><?php echo $product['prod_name']; ?></td>
                       <td id ="quant"><?php echo $product['quantity']; ?></td>  
                       <td id="price">£<?php echo $product['prod_price']; ?></td>  
                        
                       <td>£ <?php echo number_format($product['quantity'] * $product['prod_price'], 2); ?></td>  
                       <td>
                           <a href="order.php?action=delete&id=<?php echo $product['id']; ?>">
                                <div class="btn-danger">Remove</div>
                           </a>
                       </td>  
                    </tr>  
                    <?php 
                    //Display total which is calculated by multiplying the quantity by the items price
                    $total = $total + ($product['quantity'] * $product['prod_price']);  
                    endforeach;     //php keyword
                    ?>  
        
                    <!--Display Grand Total -->
                    <tr>  
                         <td colspan="3" align="right">Total</td>  
                         <td align="right">£ <?php echo number_format($total, 2); ?></td> <!--formats the total price to .2 decimal places--> 
                         <td></td>  
                    </tr>  
                    <tr>
                        <!-- Show checkout button only if the shopping cart is not empty -->
                        <!-- Ensuring that the user can't check out an empty basket -->
                        <td colspan="5">
                         <?php 
                            if (isset($_SESSION['shopping_cart'])):
                            if (count($_SESSION['shopping_cart']) > 0):
                         ?>
                            <a href="checkout.php" class="btn btn-info button">Checkout</a>
                         <?php endif; endif; ?>
                        </td>
                    </tr>
                    <?php  
                    endif;  //Php keywords
                    ?>  
                </table>  
            </div>
        </div> <!--Close item-kjlimu, absolute Class-->
        <?php
    } //end of display_cart()
    
    
    //Add to cart function
    public function addCart(){
        
        //Check if add to cart button has been pressed
        if(filter_input(INPUT_POST, 'add_to_cart')){
            //Check if the current session is set to shopping cart
            if(isset($_SESSION['shopping_cart'])){
                //keeps track of how many items are in the cart
                $count1 = count($_SESSION['shopping_cart']); 
                //keeps track of array keys and matches them with product id
                $product_ids = array_column($_SESSION['shopping_cart'], 'id');
                
                //If the product doesen't exist inside the session then add it to the cart
                if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
                    $_SESSION['shopping_cart'][$count1] = array(
                    'id'=> filter_input(INPUT_GET, 'id'),
                    'prod_name'=> filter_input(INPUT_POST, 'prod_name'),
                    'prod_price'=> filter_input(INPUT_POST, 'prod_price'),
                    'quantity'=> filter_input(INPUT_POST, 'quantity')
                    
                    );
                    
                }
                //If Product already exists, increase quantity (Not Working)************
                else
                {
                    //match array key to the id of the product being added to the cart
                    for ($i = 0; $i < count($product_ids); $i++){
                        //If the product already exists inside the cart
                        if($product_ids == filter_input(INPUT_GET, 'id')){
                            //Increase the quantity of the item, so the product isn't being duplicated in the cart
                            $_SESSION['shopping_cart']['quantity'] += filter_input(INPUT_POST, 'quantity');
                        }//End of if
                    } //End of for loop
                    
                } //End of else
                
            }
            // f cart doesent exist, create first product with array key 0
            else
            { 
                //create array using submitted form data, start with 0
                $_SESSION['shopping_cart'][0] = array(
                    'id'=> filter_input(INPUT_GET, 'id'),
                    'prod_name'=> filter_input(INPUT_POST, 'prod_name'),
                    'prod_price'=> filter_input(INPUT_POST, 'prod_price'),
                    'quantity'=> filter_input(INPUT_POST, 'quantity')
                    ); //End of array
                    
            } //End of else
        } //End of if its set by post.
    } //End of addCart()
    
    
    
    //This fucntion will remove an item from the cart that a user has selected
    public function removeItem(){
        
        //if the remove item button is clicked then
        if(filter_input(INPUT_GET, 'action') == 'delete'){
            
            //Loop through all of the products in the cart until it matches with the GET id Variable
            foreach($_SESSION['shopping_cart'] as $key => $product){
                
                //If the id's match
                if($product['id'] == filter_input(INPUT_GET, 'id')){
                    //Removes the product from the shopping cart when it matches the correct id
                    unset($_SESSION['shopping_cart'][$key]);
                }
            }
            //Reset session array keys, so that they match with their $product_ids
            $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
            
        }

    }//End of removeItem() function
    
    //This function is for the checkout page to display
    //the order summary to the user
    public function orderSummary(){
        
        //For each item inside of the basket
        foreach($_SESSION['shopping_cart'] as $key => $product):
        //Display the product name and its price inline with it
        //Bootstraps 4 .pullright class allows me to align the prices to the right
        //Whilst keeping the elements inline
        echo '<span>' . $product['prod_name'] . '</span> ' .
        
             'x <span class="text-center">' . $product['quantity'] . '</span>' . 
             '<span class ="pull-right"> £' . $product['prod_price'] . '</span>';
             
            //Each iteration of the loop a new total is produced
            //and by the time the loop ends it gets the correct total of the
            //products inside the basket and the total is instantiated to a 
            //Private variable called total
            $this->total = $this->total + ($product['quantity'] * $product['prod_price']);
            $this->productName[]= $product['prod_name'];
            
            ?><hr>
            <?php
        endforeach; //End of the foreach loop (php allows the use of keywords) 
        
        echo 'Order Total: £'. $this->print_total(); //Calls the print_total() getter and displays

    }
    
    //Gets the total price
    public function print_total(){return $this->total;}
    
    //Gets the product name
    public function get_name($index){return $this->productName[$index];}
 
} //End of class
    
    
    


