<?php

/**
 * Class registration
 * handles the user registration
 */
class Rating
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
            $this->listRating();
       
    }

    /**
     * handles the entire registration process. checks all error possibilities
     * and creates a new user in the database if everything is fine
     */
    public function listRating($id=0)
    {
                   // create a database connection
        
             $whr="";
             if($id>0){
                $whr=" where category.cat_id=$id"; 
             }
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
               
                // check if user or email address already exists
                $sql = "SELECT sum(votes) AS rating,cat_name,player_name FROM votes INNER JOIN player on player.player_id=votes.player_id INNER JOIN category on player.cat_id=category.cat_id $whr group by votes.player_id  order by rating desc limit 10;";
                $this->player = $this->db_connection->query($sql);
               // return $this->user;
                //echo $sql;die;
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
    
    
    public function publish(){
                  $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }
             if ($_REQUEST['cat']<=0) {                                 
                $this->errors[] = "Please select a category to publish.";
            }
            $catname = $this->db_connection->real_escape_string(strip_tags($_POST['cat'], ENT_QUOTES));
            // if no connection errors (= working database connection)
             if ($_REQUEST['cat']<=0) {                                 
                $this->errors[] = "Please select a category to publish.";
            }
            elseif (!$this->db_connection->connect_errno) {

                    // write new user's data into database
                    $sql = "update `category` set `publish_date`='".gmdate("Y-m-d H:i:s")."' where `cat_id`='".$catname."'";
                   // echo $sql;die;
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        //send a email to the user
                        $this->messages[] = "It has been successfully published.";

                    } else {
                        $this->errors[] = "Sorry, oparation failed. Please go back and try again.";
                    }
                
            }   
        
    }
    
    public function rate(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
         
                $sql = "SELECT * FROM  category ;";
                $this->cat=$this->db_connection->query($sql);           
//               / return $this->cat;
                $this->messages[] = "It has been successfully submited.";
               
       
        }
    }


     public function rateThis(){
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
         
           $catname = $this->db_connection->real_escape_string(strip_tags($_POST['cat'], ENT_QUOTES));
           $player = $this->db_connection->real_escape_string(strip_tags($_POST['player'], ENT_QUOTES));
           //print_r($_POST['player']);
           $i=10;
           foreach ($_POST['player'] as $v){
               $sql = "SELECT * FROM player where player_name='".$v."'";
              // echo $sql;
                $result_of_login_check = $this->db_connection->query($sql);
                $result_row = $result_of_login_check->fetch_object();
                    
               $play = $this->db_connection->real_escape_string(strip_tags($v, ENT_QUOTES)); 
               $sql = "INSERT INTO votes (player_id,votes,user_id,post_date)
               VALUES('" . $result_row->player_id . "','" . $i . "','" . $_SESSION['user_id'] . "','" . gmdate("Y-m-d H:i:s") . "');";
               // echo $sql;
               $this->cat=$this->db_connection->query($sql);
               $i--;
              // echo $sql;
           }
           
           //print_r($_POST);die;
              //  $sql = "SELECT * FROM  category ;";
                //$this->cat=$this->db_connection->query($sql);           
//               / return $this->cat;
               
       
        }
    }

    public function getPlayer($id=0)
    {
                   // create a database connection
        
             $whr="";
             if($id>0){
                $whr=" where category.cat_id=$id"; 
             }
            $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
               
                // check if user or email address already exists
                $sql = "SELECT * FROM player where cat_id=$id";
                $this->player = $this->db_connection->query($sql);
               // return $this->user;
                //echo $sql;die;
                $sql = "SELECT * FROM  category ;";
                $this->cat=$this->db_connection->query($sql);              
                
               
       
        }
    }

}
