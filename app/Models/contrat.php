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

    public function getContratsByStudent($id_user){
             $query = "SELECT c.*, cat.code
                  FROM " . $this->table . " c
                  LEFT JOIN categorie cat ON c.id_categorie = cat.id_categorie
                  WHERE c.id_user = ?"; 

            $stm = $this->conn->prepare($query);
            $stm->execute([$id_user]);
            return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContratById($id_contrat){
           

    }

    public function updateContrat($id_contrat){


    }

    public function deleteContrat($id_contrat){

    }



    }

?>