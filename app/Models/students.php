<?php
class Students {
    private $conn ; 
    private $table = "utilisateur"  ; 
    public function __construct($db){
        $this->conn = $db ; 
    }
    public function getTotalstudents(){
        $stm = $this->conn->prepare("SELECT COUNT(*) AS total FROM "  . $this->table .  " WHERE id_role = 3") ; 
        $stm->execute() ; 
        $result = $stm->fetch(PDO::FETCH_ASSOC) ; 
        return $result['total'] ?? 0 ; 
    }
    public function getAll(){
        $stm = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE id_role = 3 ORDER BY id_user DESC") ;
        $stm->execute() ; 
        return  $stm->fetchAll(PDO::FETCH_ASSOC) ?  $stm->fetchAll(PDO::FETCH_ASSOC):  "non" ; 
    }
}

?>