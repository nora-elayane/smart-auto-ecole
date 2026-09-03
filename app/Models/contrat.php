<?php 
class Contrat{
    private $conn ; 
    private $table = "contrat"  ; 
    public function __construct($db){
        $this->conn = $db ; 
    }
    public function createContrat($date , $prix , $statut , $id_user , $id_categorie){
        $query = "INSERT INTO " . $this->table . "(date_contrat ,	prix_final	, statut ,	id_user	, id_categorie) VALUES(? , ? , ? , ? , ?)" ; 
        $stm = $this->conn->prepare($query) ; 
        return $stm->execute([$date , $prix , $statut , $id_user , $id_categorie]) ;
    }

    }

?>