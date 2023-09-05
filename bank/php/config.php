<?php

class Database
{
    private $dsn = "mysql:host=localhost; dbname=bank";
    private $dbuser = "root";
    private $dbpass = "";

    public $conn;

    public function __construct()
    {
        try{
            $this->conn =  new PDO($this->dsn, $this->dbuser, $this->dbpass);
            // echo 'Connection established';
        }
        catch(PDOException $e){
            echo 'Error : '.$e->getMessage(); 
        }
        return $this->conn;
        
    }

    //Check Input

    public function test_input($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Error and success message alert

    public function showMessage($message){
        echo $message;
    }

}

?>