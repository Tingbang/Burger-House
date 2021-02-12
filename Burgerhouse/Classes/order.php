<?php
include 'connect.php';
session_start();

class Order{
 
 //Previous order variables
 private $prev_details= array();
 private $prev_date=array();
 private $prev_id =array();
    
     //This function retrieves a users previous orders made to the restaraunt
     public function view_previous_orders($conn){
        
        //Pre-write the SQL command that will select everything from the order_history table
        //where it matches the current user's id that is logged in.
        $previous_order = "SELECT * FROM order_history WHERE customer_id=:id;";
        //Prepare the SQL statement 
        $select_order=$conn->prepare($previous_order);
        //Parameter binding to help prevent against SQL Injection
        $select_order->bindParam(':id', $_SESSION['id']);
        //Execute the SQL statement
        $select_order->execute();
        
        //If the query is successful and returns rows
        if($select_order->rowCount() > 0){
            //Fetches all of the results from the query
            while($history = $select_order->fetch(PDO::FETCH_ASSOC)){
                //Assigns results to local private variables
                $this->prev_details[] = $history['order_details'];
                $this->prev_date[] = $history['date_time'];
                $this->prev_id[] =$history['hist_id'];
            }//End of while loop
        }//End of if rowCount() >0
    }//End of view_previous_orders
    

    //Previous order getters that are used to display data
    public function get_prev_details($index){return $this->prev_details[$index];}
    public function get_prev_date($index){return $this->prev_date[$index];}
    public function get_prev_rows(){return $count= count($this->prev_id);}
}
