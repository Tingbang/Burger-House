<?php
include("connect.php");

/*The User class handles submitting user data into the database for the signup page and also is
responsible for logging the user in and setting the session vairablse
*/

class User{
    //User Properties
    private $username;
    private $password;
    private $email;
    private $dob;
    
    //Login
    private $conf_user;
    private $conf_pass;
    private $account_count=array();
  
    
    //This constructo will assign the variables passed in from the form, to private variables
    public function __construct(){
        //Assigning the posted data to the private varibles
        $this->username = $_POST['username'];
        $this->password = $_POST['password1'];
        $this->conf_pass=$_POST['password2'];
        $this->email = $_POST['email'];
        $this->dob=$_POST['dob'];
        
        //Assigning the login variables
        $this->conf_user=$_POST['conf_user'];
        $this->conf_pass=$_POST['conf_pass'];
    }
    
    
    //Getter that will return the username
    public function get_user(){ return $this->username; }

    
    /*Register user function that firstly checks if the user already exists
    inside the database, if they do an error is thrown and if not then the register function continues to check
    if password and confirm password both match then the function will salt the password and insert the 
    account details into the database.
    */ 
    public function register($conn, $username, $password, $conf_pass, $email, $dob){
        //Username check
        $query = "SELECT * FROM users WHERE username = :username";
        $sql = $conn->prepare($query);
        $sql->bindParam(":username", $this->username);
        $sql->execute();
        
        //If the user already exists
        
        if($sql->rowCount() > 0){
            echo '<div id="error" class="alert alert-danger" role="alert">
                  <strong>Oh snap!</strong> It appears that username is already taken
                  </div>';
        }//If the username already exists
         //Else if the username doesen't already exist
        else{
            
            if ($password == $conf_pass){
            $salt = "faiugh2asnzn38n1pok";
            
            $this->password = sha1($this->password.$salt);
            
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, dob)
                               VALUES (:username, :password, :email, :dob);");
                                          
            //Binding the parameters
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':dob', $this->dob);
            
            if($stmt ->execute()){
                echo '<div id="error" class="alert alert-success" role="alert">
                      <strong>Well done!</strong> Account Successfully created!.
                    </div>';
                
            }   //End of execute
        }
        //ERROR HANDLING
        //if passwords don't match display error message
        else{
            echo '<div id="error" class="alert alert-danger" role="alert">
                  <strong>Oh snap!</strong> The passwords you have entered dont match!, please re-enter
                  </div>';
            }  //End of else
        }// End of else

    } //End of register function
    
    

    //loginUser function, retrieves the user's sign in details from the form
    //It checks against the database to see if the credentials match
    //If their details are correct they will be logged in.
    //A session will be set as their 'username'
    //Also a cookie will be set for 24 hours that stores their username
    public function loginUser($conn,$conf_user,$conf_pass){
        
        //Selects the username from the database where it matches the posted username from the form
        $query = "SELECT * FROM users WHERE username=:username LIMIT 1";
        $sql = $conn->prepare($query);          //Prepares the SQL staement
        $sql->bindParam(":username", $conf_user);
        //ensuring the statement excecutes
        if($sql->execute()){

        }
        
        //If the user exists inside the database, fetch their details.
        if($sql->rowCount() > 0){
             $salt = "faiugh2asnzn38n1pok";         //Salt to be added to the the password
             $conf_pass = sha1($conf_pass.$salt);   //Salts the password using SHA1() encrpytion method
            
            //While the query is returning results
            while ($row = $sql->fetch(PDO::FETCH_ASSOC))
            {
                //Binds returned data to local variables
                $admin =$row['admin_check'];        //Admin Check Column
                $db_pass = $row['password'];        //Password stored inside the database
                $id= $row['user_id'];               //The ID of the user returned from the query
     
                //If the passwords match then log the user in
                if($conf_pass == $db_pass){
                    //Set the session to the username to the person who is logged in.
                    $_SESSION['username'] = $conf_user;
                    //Set another session to the id of the user who is logged in
                    $_SESSION['id'] = $id;
                    
                    //If the admin check is true
                    //and the person who is logged in is an admin
                    if($admin ==1){
                        //Unset the username session to avoid convlict in other areas of the website.
                        unset($_SESSION['username']);
                        //Set a session called admin
                        $_SESSION['admin'] = $admin;
                    }
                    //Set a cookie for 24 hours
                    //Set the cookies value to the username of the person logged in
                    $cookie_name = "username";
                    $cookie_value = $conf_user;

                    setcookie($cookie_name, $cookie_value,time()+(86400*30), "/");
                    echo "Welcome " , $_COOKIE['username1'];
                    
                    //After everything in the function has ran and is successful
                    //Redirect the user back to the Home page.
                    header("Location: index.php");
                
                }//end of if passwords match
    
                //ERROR HANDLING
                //If the password enteres doesent match the one stored in the database then
                //run else condition and display error
            
                else{   //If passwords don't match
                
                echo '<div id="error" class="alert alert-danger" role="alert">
                      <strong>Oh snap!</strong> The password you have entered is wrong.
                      Please re-enter your password!
                      </div>';
                      
                    } //End of else condition
                    
                    
            } // End while loop
            
        } //End of if statement that checks that the username exists inside the database
        
        //ERROR HANDLING
        //If no username is returned from the database
        //display the following error:
        else
        {
            echo '<div id="error" class="alert alert-danger" role="alert">
                  <strong>Oh snap!</strong> Username doesent exist!
                  </div>';
        } //End Else
        
    } // End Login User Function()


    //This function will count the amount of user
    //accounts are stored inside the database
    public function count_accounts($conn){
        $query = "SELECT * FROM users";
        $sql = $conn->prepare($query);

        //ensuring the statement excecutes
        if($sql->execute()){
            
            if($sql->rowCount() > 0){
                
              while($row = $sql->fetch(PDO::FETCH_ASSOC))
              {
                 $this->account_count[] = $row['user_id'];
              }//end of while
                
            } //End of rowcount
    
        }
    }//end of count_accounts()
    
    
    //This function will count the amount of admin
    //accounts are stored inside the database
    public function count_admin($conn){
        $one = 1;
        $query = "SELECT * FROM users WHERE admin_check=:one";
        $sql = $conn->prepare($query);
        $sql->bindParam('one', $one);

        //ensuring the statement excecutes
        if($sql->execute()){
            
            if($sql->rowCount() > 0){
                
              while($row = $sql->fetch(PDO::FETCH_ASSOC))
              {
                //Insantiate private array account_count to returned row admin_check
                 $this->account_count[] = $row['admin_check'];
              }//end of while
                
            } //End of rowcount
    
        } //End of if statement
        
    }//End of count_admin()
    
    //getting the account count
    public function get_count(){return $count = count($this->account_count);}
    
    
    //This function will send the user a code for subscribing to the mailing list
    //C9.io blocks PHP's email function so this will work for the client
    //When the server is deployed.
     public function email(){
      $to="darrenlallybusiness@hotmail.com";
      $body = "Thank you for subcribing to our mailing list! Use code : BIGSAVER in store
      to claim your 20% discount";
      $subject ="Discount";
      $headers ="From: JIburgerhouse@glasgow.com";
      
      if(mail($to,$subject,$body,$headers)){
          //echo "success";
      }
      else{
          "failed to send";
      }
  } //End of email function
} //End of class
?>  <!--Close php-->
