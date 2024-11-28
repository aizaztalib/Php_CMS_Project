<?php

class DbConn
{
    private $servername;
    private $username;
    private $password;
    private $database;
    private $connection;

    public function __construct() {
        $this->servername = "localhost";
        $this->username = "root"; 
        $this->password = "";     
        $this->database = "cms";   

        $this->connect();
    }

    private function connect() {
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->database);
        
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function close() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }

    public function get_connection() {
        return $this->connection;
    }
}

$db = new DbConn();
?>
