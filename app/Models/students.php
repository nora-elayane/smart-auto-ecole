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
}

?>