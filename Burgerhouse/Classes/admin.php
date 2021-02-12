<?php
include 'connect.php';
class Admin{
    
    
    //Private Variables
     private $details=array();
     private $ids = array();
     private $address=array();
     private $cust_name = array();

    //Modify Order Variables      
     private $mod_details;
     private $mod_address;
     private $mod_id;
     private $id;
    
    //Edit Order Variables 
     private $mod_details1;
     private $mod_address1;
     
     //Modify Variables
     private $mod_qty;
     private $mod_stock_id;
     private $mod_name;
     
    //Delete Reviews variables
     
     
    //Constructor
     public function __construct()
     {
         $this->id = $_GET['id'];
        
     }//End of constructor
    
/*****************Edit Order************************/
    
     //This function is going to retrieve all the data from the order table
     //and display it back to the admin so they can then modify the order if need be.
     public function modify_order($conn){
         
         
         //Prepare SQL Statement
         $query = "SELECT * FROM `order`; ";
         $result=$conn->prepare($query);
         $result->execute();
         
         if($result->rowCount() > 0){
          
          while($order = $result->fetch(PDO::FETCH_ASSOC))
          {
           //Setters
           $this->details[] = $order['order_details'];
           $this->address[] = $order['order_address'];
           $this->ids[] = $order['order_id'];
           $this->cust_name[]= $order['cust_name'];
           

          }//End of while 
          
         }//End of if
         
     }//End of modify order 
     
     //These getters will return an orders details
     public function get_order($index){return $this->details[$index];}
     public function get_address($index){return $this->address[$index];}
     public function get_ids($index){return $this->ids[$index];}
     public function get_ids_count(){return $count = count($this->ids);}
     public function get_cust_name($index){return $this->cust_name[$index];}
 
 
    //This function will select the order from the database where the admin
    //it matches the id of the current selected order chosen by the admin
    public function edit_order($conn){
        $sql = "SELECT * FROM `order` WHERE order_id=:id LIMIT 1";
        $result = $conn->prepare($sql);
        $result->bindParam(':id',$this->id);
        $result->execute();
        
        if($result->rowCount() > 0){
            
            while($order = $result->fetch(PDO::FETCH_ASSOC)){
                
                $this->mod_details = $order['order_details'];
                $this->mod_address = $order['order_address'];
                $this->mod_id=$order['order_id'];
            }
        }
        else{
            echo 'No records found';
        }
    }
    
    //Gets the modified order details
    public function get_mod_details(){return $this->mod_details;}
    //Gets the modified order address
    public function get_mod_address(){return $this->mod_address;}
    //Gets the modified order id
    public function get_mod_id(){return $this->mod_id;}
    
    //This function will update the an order inside of the database
    public function update_order($conn){
            //Assigns posted variables to class variables
            $this->mod_details1 = $_POST['details'];
            $this->mod_address1 = $_POST['address'];
            $this->mod_id =$_POST['id'];
            
            //Updates the record inside the order table where it matches the current selected order
            $query = "UPDATE `order` SET order_details =:details, order_address=:address WHERE order_id=:id";
            $sql =$conn->prepare($query);
            $sql->bindParam(':details', $this->mod_details1);
            $sql->bindParam(':address', $this->mod_address1);
            $sql->bindParam(':id', $this->mod_id);
            
            $sql->execute();
            
            if($sql->execute()){
                echo"hi";
                header("Location: modify_order.php");
                
            }
            else{
                echo "fail";
            }
            
        }
        
/****************End of Modify Order********************/

/****************Start of Nodify Stock********************/ 
    //This function will retrieve the product from the database
    //where it matches the chosen product by the user
    public function get_stock($conn){
        $sql = "SELECT * FROM products WHERE prod_id=:id LIMIT 1";
        $result = $conn->prepare($sql);
        $result->bindParam(':id',$this->id);
        $result->execute();
        
        if($result->rowCount() > 0){
            while($order = $result->fetch(PDO::FETCH_ASSOC)){
                //Assigns results to private variables
                $this->mod_name = $order['prod_name'];
                $this->mod_qty = $order['prod_quantity'];
                $this->mod_stock_id=$order['prod_id'];
            }
        }
        else{
            //echo 'No records found';
        }
        
    }
    
    //Gets the name of the stock item chosen to be modified
    public function get_stock_name(){return $this->mod_name;}
    //Gets the quantity of the stock item chosen to be modified
    public function get_stock_qty(){return $this->mod_qty;}
    //Gets the id of the stock item chosen to be modified
    public function get_stock_id(){return $this->mod_stock_id;}
    
    public function modify_stock($conn){
        
        $this->quant=$_POST['quantity'];
        $this->mod_stock_id=$_POST['id'];
        
        
        //ERROR HANDLING
        /*If the admin tries to add a blank quantity or anything less than or equal 0
          the page is going to be reloaded until a valid input is given*/
        if($this->quant <= 0){
            header("Location: modify_stock_handler.php?id=" . $this->mod_stock_id ."");
        }else{
            //Updates the product quantity of the item selected by the admin
            //and the new quantity selected
            $sql ="UPDATE products SET prod_quantity =:quantity WHERE prod_id=:id";
            $result = $conn->prepare($sql);
            $result->bindParam(':quantity', $this->quant);
            $result->bindParam(':id', $this->mod_stock_id);
            $result->execute();
            if($result->execute()){
                 header("Location: modify_stock.php");
            //echo $this->get_q();
           }
            else
            {
                echo "no";
            } //End of else
            
        }//End of else

    } //End of modify_stock()
    
    public function get_q(){
        return $this->quant;
    }
    
}//End of admin class


?>