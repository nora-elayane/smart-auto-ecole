<?php

class Database{
    private $conn ; 
    public function getConnection(){
        $this->conn = null ; 
        try{
            $this->conn = new PDO("mysql:host=localhost;dbname=smart_auto_ecole;charset=utf8" , "root" , "1234") ;
        }catch(PDOException $e){
            echo $e->getMessage() ; 
        }
        return $this->conn ; 
    }
}





?>