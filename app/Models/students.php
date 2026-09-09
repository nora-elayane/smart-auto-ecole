<?php
class Students {
    private $conn ; 
    private $table = "utilisateur"  ; 
    public function __construct($db){
        $this->conn = $db ; 
    }
    public function getTotalstudents(){
        $stm = $this->conn->prepare("SELECT COUNT(*) AS total FROM "  . $this->table .  " WHERE id_role = 4") ; 
        $stm->execute() ; 
        $result = $stm->fetch(PDO::FETCH_ASSOC) ; 
        return $result['total'] ?? 0 ; 
    }
    public function getAll() {
    $query = "SELECT * FROM utilisateur WHERE id_role = 4 ORDER BY id_user DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // id_user	nom	prenom	email	mot_de_passe	cin	telephone	adresse	date_naissance	photo	etat	id_role	 
   public function createStudent($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat, $roleId) {
    $query = "INSERT INTO utilisateur (nom, prenom, email, mot_de_passe, cin, telephone, adresse, date_naissance, photo, etat, id_role) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
              
    $stm = $this->conn->prepare($query);
    return $stm->execute([$nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat, $roleId]);
}
public function getByid($id){
    $query = "SELECT * FROM " . $this->table . " WHERE id_user = ? " ; 
    $stm = $this->conn->prepare($query) ; 
    $stm->execute([$id]) ; 
    return  $stm->fetch(PDO::FETCH_ASSOC) ; 
}
public function updateStudent($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat , $id , $id_role){
    $query = "UPDATE " . $this->table . " SET nom = ? , prenom = ? , email = ? , mot_de_passe = ? , cin = ? , telephone = ? , adresse = ? , date_naissance = ? , photo = ? , etat = ? WHERE id_user = ? AND id_role = ?" ; 
    $stm = $this->conn->prepare($query) ; 
    return $stm->execute([$nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photo, $etat , $id , $id_role]) ; 

}
public function archiverStudent($ids){
    if (!is_array($ids)) { $ids = [$ids]; }
    if (empty($ids)) return false;

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $query = "UPDATE " . $this->table . " SET etat = ? WHERE id_user IN ($placeholders)";
    
    $stm = $this->conn->prepare($query);
    return $stm->execute(array_merge(["Inactif"], $ids));
}

public function activerStudent($ids){
    if (!is_array($ids)) { $ids = [$ids]; }
    if (empty($ids)) return false;

    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $query = "UPDATE " . $this->table . " SET etat = ? WHERE id_user IN ($placeholders)";
    
    $stm = $this->conn->prepare($query);
    return $stm->execute(array_merge(["Actif"], $ids));
}

public function deleteStudent($ids){
    if (!is_array($ids)) { $ids = [$ids]; }
    if (empty($ids)) return false;

    $placeholders = implode(',', array_fill(0, count($ids), '?'));

    $queryPhoto = "SELECT photo FROM " . $this->table . " WHERE id_user IN ($placeholders)";
    $stmtPhoto = $this->conn->prepare($queryPhoto);
    $stmtPhoto->execute($ids);
    $students = $stmtPhoto->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $student) {
        if (!empty($student['photo'])) {
            $filePath = __DIR__ . '/../../public/uploads/' . $student['photo'];
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