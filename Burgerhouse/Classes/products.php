<?php
ob_start();
include 'connect.php';

class Products{
    //Product Variables
    private $prod_name = array();
    private $prod_price = array();
    private $prod_description = array();
    private $prod_id = array();
    private $prod_quantity = array();
    private $prod_ident = array();
    
    //Modify Variables
    private $mod_quant;
    private $mod_id;
    
    //Stock Error
    private $stock_error;
    
    //Constructor
    public function __construct($conn){
        //sql
        //put exectute in other page and try output like that
        //Prepare the query
        $query = "SELECT * FROM products ORDER by prod_id ASC";
        $result = $conn->prepare($query);
        $result->bindParam(":prod_id", $prod_id);
        $this->count =$result->rowCount();
        $result->execute();
        
        if($result->rowCount() >0){
    
            while($product = $result->fetch(PDO::FETCH_ASSOC)){
                //Setters
                $this->prod_id[] = $product['prod_id'];
                $this->prod_name[] = $product['prod_name'];
                $this->prod_price[] = $product['prod_price'];
                $this->prod_description[] = $product['prod_description'];
                $this->prod_quantity[] = $product['prod_quantity']; 
                $this->prod_ident[] = $product['prod_ident']; 
            }   //End of while
        
        }   //End of if($result->rowCount());
        //ERROR HANDLING
        //If no data is returned from the query
        //Display "no results found"
        else{
            echo "no results found";
        }

    } //end of function
    
    //ERROR HANDLING
    //IF a product within the database is out of stock then
    //an error message is displayed to the user on the menu screen
    //before they order
    public function check_stock()
    {   
        //Start for loop in the range of all of the products inside the database
        for($x = 0; $x < $this->get_rows(); $x++){
            //If the quantity of a product is 0 then an error is displayed.
            if($this->get_qty($x) == 0){
                echo "<div id= 'error' class='alert alert-danger'>" . $this->get_Name($x) . " is out of stock!" . "</div>";
            }//End of if condition
        } //End of for loop
      
    }//End of check_stock() funtion
    
    //Returns an error if theres an issue with the stock/
    public function get_error(){return $this->stock_error;}
    
    //Getters for each of the product fields
    public function get_rows(){ return $count = count($this->prod_id); }
    public function get_id($index){return $this->prod_id[$index];}
    public function get_Name($index){ return $this->prod_name[$index]; }
    public function get_qty($index){return $this->prod_quantity[$index];}
    public function get_Price($index){ return $this->prod_price[$index]; }
    public function get_Description($index){ return $this->prod_description[$index]; }
    

    public function RemoveStock($conn){
        $this->mod_quant = $_POST['quantity'];
        $this->mod_id = $_POST['id'];

        $sql ="UPDATE products SET prod_quantity =:quantity WHERE prod_id=:id";
        
        $result = $conn->prepare($sql);
        $result->bindParam(':quantity', $this->mod_quant);
        $result->bindParam(':id', $this->mod_id);
        if($result->execute()){
            echo "yas";
        }else{
            echo "not updated";
        }

    }  //End of RemoveStock($conn)

}
ob_end_flush();
?>