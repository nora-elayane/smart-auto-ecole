<?php 
class Categorie{
     private $conn ; 
    private $table = "categorie"  ; 
    public function __construct($db){
        $this->conn = $db ; 
    }
    public function getAllCategories(){
        $query = "SELECT * FROM " . $this->table ;
        $stm = $this->conn->prepare($query) ; 
        $stm->execute() ; 
        return $stm->fetchAll(PDO::FETCH_ASSOC) ; 
    }
}


?>