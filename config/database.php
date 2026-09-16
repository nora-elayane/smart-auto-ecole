<?php
class Database {
    private $conn; 

    public function getConnection() {
        $this->conn = null; 
        try {
            $this->conn = new PDO(
                "mysql:host=localhost;dbname=smart_auto_ecole;charset=utf8", 
                "root", 
                "1234",
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }

        return $this->conn; 
    }
}
?>