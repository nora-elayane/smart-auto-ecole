<?php
class Employe {
    private $conn; 
    private $table = "utilisateur"; 

    public function __construct($db){
        $this->conn = $db; 
    }

    public function getTotalemployes(){
        $stm = $this->conn->prepare("SELECT COUNT(*) AS total FROM " . $this->table . " WHERE id_role = 2 OR id_role = 3"); 
        $stm->execute(); 
        $result = $stm->fetch(PDO::FETCH_ASSOC); 
        return $result['total'] ?? 0; 
    }

    public function getAll() {
        $query = "SELECT u.*, r.nom_role 
                  FROM " . $this->table . " u 
                  JOIN role r ON u.id_role = r.id_role 
                  WHERE u.id_role = 2 OR u.id_role = 3 
                  ORDER BY u.id_user DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createemploye($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat, $roleId) {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, email, mot_de_passe, cin, telephone, adresse, date_naissance, photo, etat, id_role) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                  
        $stm = $this->conn->prepare($query);
        return $stm->execute([$nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat, $roleId]);
    }

 public function getById($id) {
    $query = "SELECT * FROM " . $this->table . " WHERE id_user = :id LIMIT 1";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateemploye($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat, $id, $id_role){
    $query = "UPDATE " . $this->table . " SET nom = ?, prenom = ?, email = ?, mot_de_passe = ?, cin = ?, telephone = ?, adresse = ?, date_naissance = ?, photo = ?, etat = ?, id_role = ? WHERE id_user = ?"; 
    
    $stm = $this->conn->prepare($query); 
    
    return $stm->execute([$nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat, $id_role, $id]); 
}
    public function archiveremploye($ids){
        if (!is_array($ids)) { $ids = [$ids]; }
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "UPDATE " . $this->table . " SET etat = ? WHERE id_user IN ($placeholders)";
        
        $stm = $this->conn->prepare($query);
        return $stm->execute(array_merge(["Inactif"], $ids));
    }

    public function activeremploye($ids){
        if (!is_array($ids)) { $ids = [$ids]; }
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "UPDATE " . $this->table . " SET etat = ? WHERE id_user IN ($placeholders)";
        
        $stm = $this->conn->prepare($query);
        return $stm->execute(array_merge(["Actif"], $ids));
    }

    public function deleteemploye($ids){
        if (!is_array($ids)) { $ids = [$ids]; }
        if (empty($ids)) return false;

        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $queryPhoto = "SELECT photo FROM " . $this->table . " WHERE id_user IN ($placeholders)";
        $stmtPhoto = $this->conn->prepare($queryPhoto);
        $stmtPhoto->execute($ids);
        $employes = $stmtPhoto->fetchAll(PDO::FETCH_ASSOC);

        foreach ($employes as $employe) {
            if (!empty($employe['photo'])) {
                $filePath = __DIR__ . '/../../public/uploads/' . $employe['photo'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }

        $query = "DELETE FROM " . $this->table . " WHERE id_user IN ($placeholders)";
        $stm = $this->conn->prepare($query);
        return $stm->execute($ids);
    }
}
?>