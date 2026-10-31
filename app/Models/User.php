<?php

class User {
    private $conn;
    private $table = 'utilisateur'; 
    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

 public function getUsersByRole($role_id) {
    $query = "SELECT id_user, nom, prenom, telephone FROM utilisateur WHERE id_role = :role_id ORDER BY nom ASC";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':role_id', $role_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}