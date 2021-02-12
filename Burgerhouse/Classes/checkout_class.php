<?php
include("connect.php");
session_start();    //Start the session to get access to id, username and the cart
class Checkout{
    
     //User Details
     private $full_name;
     private $address1;
     private $address2;
     private $city;
     private $postcode;
     private $phonenumber;
     private $details;
     private $total;
     private $cust_id;
     private $delivery_type;
     private $qty = array();
     private $ids = array();
     private $prod_quant = array();
     
     
     //Variables for the user who has their details saved to the database
     private $auto_fill_name;
     private $auto_fill_address1;
     private $auto_fill_address2;
     private $auto_fill_email;
     private $auto_fill_city;
     private $auto_fill_postcode;
     private $auto_fill_number;
     
     private $amount_id = array();
     
     //Session Variables
     private $session_qty = array();

    
    /*Constructor*/
    public function __construct(){
        
        //Assigns these posted variables to local private variables
        $this->full_name=$_POST['name'];
        $this->address1 =$_POST['address1'];
        $this->address2 =$_POST['address2'];
        $this->city =$_POST['city'];
        $this->postcode =$_POST['postcode'];
        $this->phonenumber =$_POST['number'];
        $this->email = $_POST['email'];
        $this->cust_id = $_SESSION['id'];
        $this->delivery_type = $_POST['hidden_check'];
        
    } //End of constructor
    
    
    //Main function
    
    /*This function appends all of the user details into a variable to save multiple inserts.
      Once the data is appended, the get_order() function is ran, which will
      grab all the items from the cart and also the total price.
      If the user is logged in then the 'cust_id' field is set to the id of the user
      that is currently logged in and will be stored else it will be null inside the database
      The SQL insert statement is then prepared to submit all the data into the `order` table
      , also if the user is logged in then the add_history() function is ran which will save
      the users specific order history which can be viewed by the user to see their previous orders
      Once the order is finalised and submitted, the set_ids and get_id functions will set and get the current
      id's of products inside of the cart and update the stock according to the current quantity
      selected by the user per item, and lastly if the user is logged in, their details will be stored to
      the user_details table inside the database using the function add_user_details()
      meaning that the next time they are logged in and are checking out, their details are going to
      be auto filled into the appropriate input boxes using the auto_fill() setters and getters*/
      
    public function finalise_order($conn){
        $paid ="no";    //This is set to no because the user has selected pay by cash
        $address="";    //This variable is going to store the users address details to make submitting it into the database easier
        $details="";    //This variable is going to store the users order details to make submitting it into the database easier
        
        //Appending the users address to the $address variable
        $address .= $this->address1 . ', ' . $this->address2 . ', ' . $this->city . ', ' . $this->postcode. ', ' . $this->phonenumber . ', '. $this->email;
        
        //Execute get_order() function
        //This is going to retrieve all the order details from the session
        $this->get_order();
        
        //Appends the total price onto the end of $details.
        $this->details .=', Order Price: ' .  $this->total;
        
        //If the user is logged in then set cust_id to the customers_id
        //If they arent logged in it will be stored as null inside
        //the database
        if(isset($_SESSION['id'])){ $this->cust_id= $_SESSION['id']; }
        
        //Insert SQL statement which is going to store the order into the `order` table
        $query = "INSERT INTO `order` (order_details, order_address, cust_id, cust_name, delivery_type, paid)
                            VALUES(:details,:address,:cust_id,:name,:delivery,:paid);";
        
        //Prepares the pre-written SQL statement.
        $sql=$conn->prepare($query);
        
        //Parameter binding, to help prevent against SQL injection
        $sql->bindParam(':details', $this->details);
        $sql->bindParam(':address', $address);
        $sql->bindParam(':name', $this->full_name);
        $sql->bindParam(':delivery', $this->delivery_type);
        $sql->bindParam(':paid', $paid);
        $sql->bindParam(':cust_id', $this->cust_id);
        
        //Excecute the statement
        $sql->execute();
        
        //If the user is also logged in
        //Run function - add_history
        //Which is going to save their order to
        //order_histroy table and can be viewed by the user
        //to see when and what they have previously ordered from the restaurant
        if(isset($_SESSION['username'])){$this->add_history($conn);}
        
        //Call to other functions to be ran.
        $this->set_ids();
        $this->update_stock($conn);
        $this->redirect();
    }//End of function finalise_order($conn);
    

    
    //This function retrieves the order information from the session(cart)
    //and instantiates them to local variables
    //This is achieved by using a foreach loop which will
    //Loop through all the items in the session and append them into their appropriate
    public function get_order()
    {
        //For each item inside of the cart
        foreach($_SESSION['shopping_cart'] as $key => $product)
        {
        //Set private $total to the quantity of the item multiplied by the price
        $this->total = $this->total + ($product['quantity'] * $product['prod_price']);
        //Append the product name and also the amount of the item they want to order
        $this->details.= $product['prod_name'] . ' x ' . $product['quantity'] . ' ';
        } //End of foreach();
    
        //If the order is set for delivery it will cost an additional £1.50
        if($this->delivery_type == "Delivery"){
            $this->total = $this->total + 1.50;
        } //end of if
        
    }//End of get_order()
    
    
    
    //If the user is logged in then this function will be ran
    //This function will insert the users order into the order_history table inside the database
    //This is just incase they wish to view any previous orders they have made to the restaraunt
    public function add_history($conn){
        
        //Prepare SQL INSERT statement - that will submit the users order history into the order_history table
        $history_query ="INSERT INTO order_history (customer_id, order_details)
                        VALUES(:cust_id, :order_details);";
        
        //Prepare the SQL statement                
        $insert=$conn->prepare($history_query);
        //Parameter binding to help prevent SQL injection
        $insert->bindParam(':cust_id', $this->cust_id);
        $insert->bindParam(':order_details', $this->details);
        //Excecute the SQL statement
        $insert->execute();

    }//End of add_history function();
    
    
    //amount_of_orders selects everything from the orders table
    //and then assings the variables to amount_id - which is going to be
    //used to get the count of records inside the database
    //and details to store the order details inside
    public function amount_of_orders($conn){
        
        $amount_query = "SELECT * FROM `order`;";
        $amount_order=$conn->prepare($amount_query);
        $amount_order->execute();
        
        if($amount_order->rowCount() > 0){
            while($order = $amount_order->fetch(PDO::FETCH_ASSOC)){
                $this->amount_id[] =$order['hist_id'];
                $this->details[] =$order['order_details'];
            }//End of while loop
        }//End of if rowCount() >0
    }
    
    //Getters that return the count of records inside the order table
    // and returns the order details stored inside the order details
    public function get_amount(){return $count = count($this->amount_id);}
    public function get_details(){return $this->details;}
    
    //If the user is logged in then this function will be ran
    ////This function is ran when their personal details don't exist inside the database
    //and will insert their personal details into the user_details table
    public function add_user_details($conn){
        if(isset($_SESSION['username'])){
            
            $user_details = "INSERT INTO user_details(user_id, name, address1,address2,email,city, postcode,phone_number)
                            VALUES(:userid,:name,:address1,:address2,:email,:city,:postcode,:phonenumber)";
                            
            $insert_user=$conn->prepare($user_details);
            $insert_user->bindParam(':userid',$_SESSION['id']);
            $insert_user->bindParam(':name',$this->full_name);
            $insert_user->bindParam(':address1',$this->address1);
            $insert_user->bindParam(':address2',$this->address2);
            $insert_user->bindParam(':email',$this->email);
            $insert_user->bindParam(':city',$this->city);
            $insert_user->bindParam(':postcode',$this->postcode);
            $insert_user->bindParam(':phonenumber',$this->phonenumber);

            if($insert_user->execute()){
                header("Location: index.php");   
            }
            
        }
    }
    
    
    //This function is ran when their personal details already exist inside the database
    //and need to be updated instead of being re-inserted.
    public function update_user_details($conn){
        //Prepares update details statement
        $user_update = "UPDATE user_details SET user_id=:userid,
                        name=:name,address1=:address1,address2=:address2,
                        email=:email,city=:city,postcode=:postcode,phone_number=:phonenumber";
        //Prepares the statement for execution
        $update_user=$conn->prepare($user_update);
        
        //Parameter Binding to help prevent against SQL injection.
        $update_user->bindParam(':userid',$_SESSION['id']);
        $update_user->bindParam(':name',$this->full_name);
        $update_user->bindParam(':address1',$this->address1);
        $update_user->bindParam(':address2',$this->address2);
        $update_user->bindParam(':email',$this->email);
        $update_user->bindParam(':city',$this->city);
        $update_user->bindParam(':postcode',$this->postcode);
        $update_user->bindParam(':phonenumber',$this->phonenumber);
        $update_user->execute();
        
        if($update_user->execute()){
            //echo "success";
            //header("Location: index.php");
        }
    } //End of update_user_details() function
    
    
    
    
    public function update_stock($conn){
       //Gets the quantity of each item inside the session and instantiates it to the session_qty[] array
       foreach($_SESSION['shopping_cart'] as $key => $product){ $this->session_qty[] = $product['quantity']; }
        
   
        //Loops through the amount of items inside the cart
        for($x = 0; $x < $this->getid_count($x); $x++)
        {   
            //Prepares the SQL statement to select the quantity from the products that match the ID of those inside the cart
            $get_quanty = "SELECT prod_quantity FROM products WHERE prod_id =" .$this->get_ids($x);";";
            $update=$conn->prepare($get_quanty);    //Prepares the statement
            $update->execute();                     //Execute the query
        
            if($update->rowCount() > 0 ){           //If any rows are returned from the database
                
                while($result = $update->fetch(PDO::FETCH_ASSOC)){      //Fethches all of the results
                
                    if($result['prod_quant'] == 0){
                        echo 'Error! Item is out of stock please make a new selection';
                    }
                    
                    $this->prod_quant[] = $result['prod_quantity'];     //Sets the quantity of a product from the database to $product_quant arrayt
                }//End of while
            }//end of rowcount
        }//End of for
        
            //Prepares the statement to query the database
            //It is decrementing each item in the baskets stock quantity
            //by however much is being ordered
           
           //Loops through the amount of products inside the cart and updates the database with the total quantity of products - the qty purchased from the user
           //Where it matches the product inside the database
        for($i = 0; $i < $this->getid_count($i); $i++){
            $sql1 = "UPDATE products SET prod_quantity=". $this->get_prod_quant($i). "-:qty WHERE prod_id=:id;";
            $update1=$conn->prepare($sql1);
                
            $update1->bindParam(':id',$this->get_ids($i));
            $update1->bindParam(':qty',$this->session_qty[$i]);
            $update1->execute();
            }   //End of for
    } //End of function update_stock($conn);
    
    
    //Returns the product quantity for the current item it is at in the index
    public function get_prod_quant($index){ return $this->prod_quant[$index];}


    //Sets all of the id's in the shopping cart
    //to private array id's
    public function set_ids(){
        foreach($_SESSION['shopping_cart'] as $key=> $product)
        {
            //Adds all of the products id's inside the shopping cart to an array called ids
            $this->ids[] =$product['id'];
            //echo $product['p']
        } //end of set_ids
        
    } //End of set_id's
    
    
    //Returns the id at the current index of the loop
    public function get_ids($index){return $this->ids[$index];}
    
    //Counts the amount of id's inside the array
    public function getid_count(){return count($this->ids);}
    
    
    
    //This function will redirect the user to either the delivery_invoice page
    //or the collection_invoice page based on what delivery_type they have selected.
    public function redirect(){
        if($this->delivery_type = "Delivery"){
            header("Location: delivery_invoice.php");
            
        }elseif($this->delivery_type="Collection"){
            header("Location: collection_invoice.php");
            die();
        }
    }
    
    //This function will select the users_details from the database
    //If they have them stored.
    public function auto_fill($conn){
        //Making sure the user is logged in
        if(isset($_SESSION['id'])){
            //Prepares SQL statement to select details from the database
            $auto_fill = "SELECT * FROM user_details WHERE user_id =:id;";
            //Prepares the SQL statment for execution            
            $sql_auto_fill = $conn->prepare($auto_fill);
            //Bind Parameter to help prevent SQL Injection  
            $sql_auto_fill->bindParam(':id',$_SESSION['id']);
            //Excecute SQL statement
            $sql_auto_fill->execute();
            
            //If the query returns any rows then insantiate the results
            //into their appropriate variables
            //and also run the update_user_details function
            //incase they enter change their details
            //it is automatically updated
             if($sql_auto_fill->rowCount() >0)
             {
                 while($info = $sql_auto_fill->fetch(PDO::FETCH_ASSOC))
                 {
                     $this->auto_fill_name = $info['name'];
                     $this->auto_fill_address1 = $info['address1'];
                     $this->auto_fill_address2 = $info['address2'];
                     $this->auto_fill_email = $info['email'];
                     $this->auto_fill_city = $info['city'];
                     $this->auto_fill_postcode = $info['postcode'];
                     $this->auto_fill_number = $info['phone_number'];
                        
                 }
                 //if the results are returned run this function
                 //$this->update_user_details($conn);
                 
             } //End if
             //If no rows are returned then add the user's details into the user_details table
             else{
                 //$this->add_user_details($conn);
             }
            
        }//End if the session is set
        
        
    }//End autofill function
    
    //Getts all of the autofill data.
    public function get_autofill_name(){return $this->auto_fill_name;}
    public function get_autofill_address1(){return $this->auto_fill_address1;}
    public function get_autofill_address2(){return $this->auto_fill_address2;}
    public function get_autofill_email(){return $this->auto_fill_email;}
    public function get_autofill_city(){return $this->auto_fill_city;}
    public function get_autofill_postcode(){return $this->auto_fill_postcode;}
    public function get_autofill_phonenumber(){return $this->auto_fill_number;}

    
}//End of Class
?>