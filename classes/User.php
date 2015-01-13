<?php

/**
 * Class registration
 * handles the user registration
 */
class User
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    
    public $user =null;
    
    /**
     * @var array $messages Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$registration = new Registration();"
     */
    public function __construct()
    {
            // session_start();
            $this->listUser();
       
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    private function listUser()
    {
                   // create a database connection
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               
                // check if user or email address already exists
                $sql = "SELECT * FROM users;";
                $this->user = $this->db_connection->query($sql);
               // return $this->user;
                
               
       
        }
    }
    public function addUSer(){
         //print_r($_POST);
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $fname = $this->db_connection->real_escape_string(strip_tags($_POST['fname'], ENT_QUOTES));
                $lname = $this->db_connection->real_escape_string(strip_tags($_POST['lname'], ENT_QUOTES));
                $email = $this->db_connection->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
                $state = $this->db_connection->real_escape_string(strip_tags($_POST['state'], ENT_QUOTES));
                $city = $this->db_connection->real_escape_string(strip_tags($_POST['city'], ENT_QUOTES));
                $zip = $this->db_connection->real_escape_string(strip_tags($_POST['zip'], ENT_QUOTES));
                $number = $this->db_connection->real_escape_string(strip_tags($_POST['number'], ENT_QUOTES));
                $password=  $this->generateRandomString();         

               //echo $password;
                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_email = '" . $email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that email address is already taken.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO users (user_email,fname,lname,address,state,city,zip,phone_number,password)
                            VALUES('" . $email . "', '" . $fname . "', '" . $lname . "', '" . $address . "', '" . $state . "', '" . $city . "', '" . $zip . "', '" . $number . "', '" . md5($password). "');";
                    //echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        $this->sendMail($email,$password);
                        $this->messages[] = "Your account has been created successfully. Password has been sent to the email address";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            }   
    }
    
    public function sendMail($email,$password){
        $to = "$email";
        $subject = "This is subject";
        $message = "This is sample message.Your account has been created with us.Your email id is $email and password is $password. Now can login to our site with this login credentials";
        $message .= "<h1>This is headline.</h1>";
        $header = "From:".FROM_EMAIL." \r\n";        
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $retval = mail ($to,$subject,$message,$header);
    }
    
    function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

    public function deleteUser(){
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                // check if user or email address already exists
                $sql = "delete FROM users where user_id=$uid";
                $query_new_user_insert= $this->db_connection->query($sql);
               // return $this->user; 
               
                        //send a email to the user
               $this->messages[] = "account has been deleted successfully.";
                    
                
               
       
        }
        
    } 
        public function resetUser(){
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
               $password=  $this->generateRandomString();
               // check if user or email address already exists
                $sql = "update users set password='".md5($password)."' where user_id=$uid";
               // echo $sql;
                $query_new_user_insert= $this->db_connection->query($sql);
               // return $this->user; 
               $this->resetMail($email,$password);
                        //send a email to the user
               $this->messages[] = "account password has been reset successfully.";   
                        
       
        }
        
    }
    public function resetMail($email,$password){
        $to = "$email";
        $subject = "This is subject";
        $message = "This is sample message.Your password has been created with us.Your email id is $email and password is $password. Now can login to our site with this login credentials";
        $message .= "<h1>This is headline.</h1>";
        $header = "From:".FROM_EMAIL." \r\n";        
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $retval = mail ($to,$subject,$message,$header);
    }
    
    public function getUser(){
         $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                // check if user or email address already exists
                $sql = "select * FROM users where user_id=$uid";
                $query_new_user= $this->db_connection->query($sql);
                return $query_new_user->fetch_object();
                          
               
       
        }
        
    }
    
    public function updateUSer(){
         //print_r($_POST);
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                $id = $this->db_connection->real_escape_string(strip_tags($_POST['id'], ENT_QUOTES));
                // escaping, additionally removing everything that could be (html/javascript-) code
                $fname = $this->db_connection->real_escape_string(strip_tags($_POST['fname'], ENT_QUOTES));
                $lname = $this->db_connection->real_escape_string(strip_tags($_POST['lname'], ENT_QUOTES));
                $email = $this->db_connection->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
                $state = $this->db_connection->real_escape_string(strip_tags($_POST['state'], ENT_QUOTES));
                $city = $this->db_connection->real_escape_string(strip_tags($_POST['city'], ENT_QUOTES));
                $zip = $this->db_connection->real_escape_string(strip_tags($_POST['zip'], ENT_QUOTES));
                $number = $this->db_connection->real_escape_string(strip_tags($_POST['number'], ENT_QUOTES));
                $password="random";         

                    // write new user's data into database
                    $sql = "update users set user_email='".$email."',fname='".$fname."',lname='".$lname."',address='".$address."',state='".$state."',city='".$city."',zip='".$zip."',phone_number='".$number."' where user_id='".$id."';";
                    //echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        $this->messages[] = "Your account has been updated successfully.";

                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                
            }   
    }
    
    
    public function addUSer2(){
         //print_r($_POST);
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $fname = $this->db_connection->real_escape_string(strip_tags($_POST['fname'], ENT_QUOTES));
                $lname = $this->db_connection->real_escape_string(strip_tags($_POST['lname'], ENT_QUOTES));
                $email = $this->db_connection->real_escape_string(strip_tags($_POST['email'], ENT_QUOTES));
                $address = $this->db_connection->real_escape_string(strip_tags($_POST['address'], ENT_QUOTES));
                $state = $this->db_connection->real_escape_string(strip_tags($_POST['state'], ENT_QUOTES));
                $city = $this->db_connection->real_escape_string(strip_tags($_POST['city'], ENT_QUOTES));
                $zip = $this->db_connection->real_escape_string(strip_tags($_POST['zip'], ENT_QUOTES));
                $number = $this->db_connection->real_escape_string(strip_tags($_POST['number'], ENT_QUOTES));
                $password=  $number = $this->db_connection->real_escape_string(strip_tags($_POST['password'], ENT_QUOTES));         

               //echo $password;
                // check if user or email address already exists
                $sql = "SELECT * FROM users WHERE user_email = '" . $email . "';";
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that email address is already taken.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO users (user_email,fname,lname,address,state,city,zip,phone_number,password)
                            VALUES('" . $email . "', '" . $fname . "', '" . $lname . "', '" . $address . "', '" . $state . "', '" . $city . "', '" . $zip . "', '" . $number . "', '" . md5($password). "');";
                   // echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        $this->sendMail2($email,$password);
                        $this->messages[] = "Your account has been created successfully. Password has been sent to the email address";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            }   
    }
    
        public function sendMail2($email,$password){
        $to = "$email";
        $subject = "This is subject";
        $message = "This is sample message.Your account has been created with us.Your email id is $email and password is $password. Now can login to our site with this login credentials";
        $message .= "<h1>This is headline.</h1>";
        $header = "From:".FROM_EMAIL." \r\n";        
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $retval = mail ($to,$subject,$message,$header);
    }
    

}
