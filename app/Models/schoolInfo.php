<?php
class SchoolInfo {
    private $conn;
    private $table = 'school_info';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getInfo() {
        $query = "SELECT * FROM " . $this->table . " LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }
}