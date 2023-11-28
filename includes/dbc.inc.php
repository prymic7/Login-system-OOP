<?php


class Database
{
    private $db_host;
    private $db_username;
    private $db_passwd;
    private $db_name;
    private $connection;
    public function __construct($db_host, $db_username, $db_passwd, $db_name)
    {
        $this->db_host = $db_host;
        $this->db_username = $db_username;
        $this->db_passwd = $db_passwd;
        $this->db_name = $db_name;
    }

    public function connect()
    {
        $this->connection = mysqli_connect($this->db_host, $this->db_username, $this->db_passwd, $this->db_name);
        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
        echo "Connected successfully";
        return $this->connection;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}

$database = new Database("localhost", "root", "", "appdb");
$connection = $database->connect();





