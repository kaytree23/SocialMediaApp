<?php
class Database
{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "mybook_db";

    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->conn->connect_error)
        {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function read($query)
    {
        $result = $this->conn->query($query);

        if ($result && $result->num_rows > 0)
        {
            $data = [];
            while ($row = $result->fetch_assoc())
            {
                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    public function run($query)
    {
        return $this->conn->query($query);
    }
}