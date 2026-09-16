<?php
class SchoolInfo {
    private $conn;
    private $table = "school_info";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getInfo() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = 1 LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateInfo($data) {
        $query = "UPDATE " . $this->table . " SET 
                    nom_ecole = :nom_ecole,
                    num_autorisation = :num_autorisation,
                    num_registre_national = :num_registre_national,
                    num_patente = :num_patente,
                    num_rc = :num_rc,
                    adresse = :adresse,
                    ville = :ville,
                    telephone = :telephone,
                    fax = :fax,
                    email = :email,
                    representant_legal = :representant_legal
                  WHERE id = 1";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute($data);
    }
}