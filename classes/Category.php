<?php

/**
 * Class registration
 * handles the user registration
 */
class Category
{
    /**
     * @var object $db_connection The database connection
     */
    private $db_connection = null;
    /**
     * @var array $errors Collection of error messages
     */
    public $errors = array();
    
    public $cat =null;
    
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
            $this->listCategory();
       
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    public function listCategory()
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
                $sql = "SELECT * FROM category;";
                $this->user = $this->db_connection->query($sql);
               // return $this->user;
                
               
       
        }
    }
    public function addCategory(){
         //print_r($_POST);
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $catname = $this->db_connection->real_escape_string(strip_tags($_POST['category'], ENT_QUOTES));
               
                // check if user or email address already exists
                $sql = "SELECT * FROM category WHERE cat_name = '" . $catname . "';";
                $query_check_cat_name = $this->db_connection->query($sql);

                if ($query_check_cat_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that Category is already added.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO category (cat_name)
                            VALUES('" . $catname . "');";
                    //echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        //echo $sql;die;
                        $this->messages[] = "Category has been created successfully.";
                    } else {
                        $this->errors[] = "Sorry, Please go back and try again.";
                    }
                }
            }   
    }
    
    
    public function editCategory(){
                  $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                $id = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                $cat = $this->db_connection->real_escape_string(strip_tags($_REQUEST['category'], ENT_QUOTES));

                    // write new user's data into database
                    $sql = "update category set cat_name='".$cat."' where cat_id='".$id."';";
                    //echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        $this->messages[] = "Category has been updated successfully.";

                    } else {
                        $this->errors[] = "Sorry, oparation failed. Please go back and try again.";
                    }
                
            }   
        
    }

        public function deleteCategory(){
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                // check if user or email address already exists
                $sql = "delete FROM category where cat_id=$uid";
                $query_new_user_insert= $this->db_connection->query($sql);
               // return $this->user; 
               
                        //send a email to the user
               $this->messages[] = "Category has been deleted successfully.";
                    
                
               
       
        }
        
    }
    
    public function getcategory(){
         $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                // check if user or email address already exists
                $sql = "select * FROM category where cat_id=$uid";
                $query_new_user= $this->db_connection->query($sql);
                return $query_new_user->fetch_object();
                          
               
       
        }
        
    }
    

    

}
