<?php
include 'connect.php';

class Review{
    //Review Attribute Arrays();
    private $reviews = array();
    private $rev_id = array();
    private $user = array();
    private $content = array();
    private $rating = array();
    private $date_time=  array();
    
    private $user_rating;
    private $user_content;
    
    
    //Constructor
    public function __construct(){
        //Assigns the posted variables to local variables
        $this->user_rating = $_POST['rating'];
        $this->user_content = $_POST['content'];
        
    }
    
    //Retrieves all reviews from the database
    public function set_reviews($conn){

        //Prepares SQL statment and then executes it
        $query = "SELECT * FROM reviews";
        $sql = $conn->prepare($query);
        $sql->execute();
        
        //If rows reviews are returned from the database
        if ($sql->rowCount() > 0){
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                
                $this->rev_id[]=$row['rev_id'];
                $this->user[]=$row['user'];
                $this->content[]=$row['content'];
                $this->rating[]=$row['rating'];
                $this->reviews[] =$row;
                $this->date_time[]=$row['date_time'];
                
                
            } //End of while loop
            
        } //End of if the query returns any rows
        
        //ERROR HANDLING
        //If no reviews are returned display meesage
        else{
            echo "No reviews have been made yet!";
        }
    }//End of set_reviews() function


    //Getters to retrieve data from the class
    public function get_full(){return $this->reviews;}
    public function get_id($index){return $this->rev_id[$index];}
    public function get_user($index){return $this->user[$index];}
    public function get_content($index){return $this->content[$index];}
    public function get_rating($index){return $this->rating[$index];}
    public function get_review($index){return $this->reviews[$index];}
    public function get_rows(){ return $count = count($this->rev_id); }
    public function get_date($index){return $this->date_time[$index];}

    
    public function submit_review($conn){
        //If the form is submitted then
        //Error Handling: Check if the rating is out of bounds
        //If it is outwith the range then throw error
        //Else submit the review into the database
        if(isset($_POST['submit'])){
            
            if($this->user_rating < 0 || $this->user_rating > 5)
            {
                
            echo "<div id= 'error' class='alert alert-danger'>Ratings must be between 0 and 5!" . "</div>";
                
            }//End of range Check
        
            //If the the review content is empty
            //Throw an error
            elseif($this->user_content =="")
            {
                echo "<div id= 'error' class='alert alert-danger'>Content cannot be empty" . "</div>";
            }
            //Else if the inputs are valid then
            //Submit the review into the database
            else
            {
            //Prepare the SQL statment into a variable
            $review = "INSERT INTO reviews(user,content,rating)
                       VALUES(:user,:content,:rating)";
            
            //prepare() - Prepares a statement for execution and returns a statement object
            $sql = $conn->prepare($review); //Prepare pre-written statement
            $sql->bindParam(':user', $_SESSION['username']);
            $sql->bindParam(':content', $this->user_content);
            $sql->bindParam(':rating', $this->user_rating);
            $sql->execute();
            $this->redirect();
            } //End of else
            
        } //End if the form is submitted
        
    }//End of submit_review() function
    
    //Function that redirects the user to the review_page
    public function redirect(){header("Location: review_page.php");} //End of redirect
    
    //Admin Function
    //Deletes a review from the database
    public function delete_review($conn){
        $id = $_GET['id'];
        $sql = "DELETE FROM reviews WHERE rev_id=:id";
        $result = $conn->prepare($sql);
        $result->bindParam(':id',$id);
        $result->execute();
        
        header("Location: delete_review.php");
        
    }

} //End of review class
?>