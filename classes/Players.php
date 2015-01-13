<?php

/**
 * Class registration
 * handles the user registration
 */
class Players
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
    
    public $player=null;
    
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
            $this->listplayers();
       
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    public function listplayers()
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
                $sql = "SELECT * FROM player INNER JOIN category where player.cat_id=category.cat_id;";
                $this->player = $this->db_connection->query($sql);
               // return $this->user;
                
                $sql = "SELECT * FROM  category ;";
                $this->cat=$this->db_connection->query($sql);              
                
               
       
        }
    }
    public function addPlayer(){
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
                $player = $this->db_connection->real_escape_string(strip_tags($_POST['player'], ENT_QUOTES));
       
                    // write new user's data into database
                    $sql = "INSERT INTO player (player_name,cat_id)
                            VALUES('" . $player . "','" . $catname . "');";
                    //echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        //echo $sql;die;
                        $this->messages[] = "Player has been added successfully.";
                    } else {
                        $this->errors[] = "Sorry, Please go back and try again.";
                    }
                }
              
    }
    
    
    public function editPlayer(){
                  $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                $id = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                $cat = $this->db_connection->real_escape_string(strip_tags($_REQUEST['category'], ENT_QUOTES));
                $player = $this->db_connection->real_escape_string(strip_tags($_REQUEST['player'], ENT_QUOTES));

                    // write new user's data into database
                    $sql = "update player set cat_id='".$cat."', player_name='".$player."' where player_id='".$id."';";
                    //echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        $this->messages[] = "Player has been updated successfully.";

                    } else {
                        $this->errors[] = "Sorry, oparation failed. Please go back and try again.";
                    }
                
            }   
        
    }

        public function deletePlayer(){
          $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                // check if user or email address already exists
                $sql = "delete FROM player where player_id=$uid";
                $query_new_user_insert= $this->db_connection->query($sql);
               // return $this->user; 
               
                        //send a email to the user
               $this->messages[] = "Player has been deleted successfully.";
                    
                
               
       
        }
        
    }
    
    public function getplayer(){
         $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

               $uid = $this->db_connection->real_escape_string(strip_tags($_REQUEST['id'], ENT_QUOTES));
                // check if user or email address already exists
                $sql = "select * FROM player INNER JOIN category  where category.cat_id=player.cat_id and player_id=$uid";
                //echo $sql;die;
                $query_new_user= $this->db_connection->query($sql);
                return $query_new_user->fetch_object();
                          
               
       
        }
        
    }
    

    

}
