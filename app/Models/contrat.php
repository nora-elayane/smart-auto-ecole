<?php 
class Contrat{
    private $conn ; 
    private $table = "contrat"  ; 
    public function __construct($db){
        $this->conn = $db ; 
    }
    public function createContrat($date, $prix, $statut, $id_user, $id_categorie, $num_enregistrement = null) {
    $query = "INSERT INTO " . $this->table . " (date_contrat, prix_final, statut, id_user, id_categorie, num_enregistrement) VALUES (?, ?, ?, ?, ?, ?)"; 
    $stm = $this->conn->prepare($query); 
    return $stm->execute([$date, $prix, $statut, $id_user, $id_categorie, $num_enregistrement]);
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

  public function getContratById($id_contrat) {
    $query = "SELECT c.*, cat.code 
              FROM " . $this->table . " c
              LEFT JOIN categorie cat ON c.id_categorie = cat.id_categorie 
              WHERE c.id_contrat = ? 
              LIMIT 1";
              
    $stm = $this->conn->prepare($query);
    $stm->execute([$id_contrat]);
    return $stm->fetch(PDO::FETCH_ASSOC);
}

  public function updateContrat($id_contrat, $date, $prix, $statut, $id_categorie, $num_enregistrement = null) {
    $query = "UPDATE " . $this->table . " 
              SET date_contrat = ?, 
                  prix_final = ?, 
                  statut = ?, 
                  id_categorie = ?, 
                  num_enregistrement = ? 
              WHERE id_contrat = ?";
              
    $stm = $this->conn->prepare($query);
    
    // الترتيب هنا خاصو يكون متبع نفس ترتيب العلامات (?) فـ الـ Query بالضبط
    return $stm->execute([
        $date,               // 1. date_contrat
        $prix,               // 2. prix_final
        $statut,             // 3. statut
        $id_categorie,       // 4. id_categorie
        $num_enregistrement, // 5. num_enregistrement
        $id_contrat          // 6. WHERE id_contrat
    ]);
}
    public function getStudentIdByContratId($contratId) {
    $query = "SELECT id_user FROM " . $this->table . " WHERE id_contrat = ? LIMIT 1";
    $stm = $this->conn->prepare($query);
    $stm->execute([$contratId]);
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    return $row['id_user'] ?? null;
}

    public function deleteContrat($ids){
        if (!is_array($ids)) { $ids = [$ids]; }
    if (empty($ids)) return false;
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "DELETE FROM " . $this->table . " WHERE id_contrat IN ($placeholders)" ;
        $stm = $this->conn->prepare($query) ; 
        return $stm->execute($ids) ;
    }
    

    }

?>