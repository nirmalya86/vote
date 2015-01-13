<?php

/**
 * Class login
 * handles the user's login and logout process
 */
class Index
{
    /**
     * @var object The database connection
     */
    private $db_connection = null;
    /**
     * @var array Collection of error messages
     */
    public $errors = array();
    /**
     * @var array Collection of success / neutral messages
     */
    public $messages = array();

    /**
     * the function "__construct()" automatically starts whenever an object of this class is created,
     * you know, when you do "$login = new Login();"
     */
    public function __construct()
    {
        // create/read session, absolutely necessary
        session_start();
        $this->getRanking();
    }

    /**
     * log in with post data
     */
    public function getRanking()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                 $rank=array();
                 $sql = "SELECT * FROM category ";
                 //echo $sql;
                 $result = $this->db_connection->query($sql);
                 return $result;
            }

    }
        public function getPlayer()
    {
        $this->db_connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {
                 $rank=array();
                 $sql = "SELECT sum(votes) AS rating,cat_name,player_name,COUNT (10) FROM votes INNER JOIN player on player.player_id=votes.player_id INNER JOIN category on player.cat_id=category.cat_id where category.publish_date<votes.post_date  group by votes.player_id  order by rating desc HAVING COUNT (10) <= 10 limit 10;";
                 //echo $sql;
                 $result = $this->db_connection->query($sql);
                 return $result;
            }

    }
 
}
