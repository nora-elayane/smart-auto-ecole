<?php

class Vehicule {
    private $conn;
    private $table = 'vehicule';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id_vehicule DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_vehicule = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createVehicule($immatriculation, $marque, $modele, $date_assurance, $date_visite_technique, $etat) {
        $query = "INSERT INTO " . $this->table . " 
                  (immatriculation, marque, modele, date_assurance, date_visite_technique, etat) 
                  VALUES (:immatriculation, :marque, :modele, :date_assurance, :date_visite_technique, :etat)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':immatriculation', $immatriculation);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':modele', $modele);
        $stmt->bindParam(':date_assurance', $date_assurance);
        $stmt->bindParam(':date_visite_technique', $date_visite_technique);
        $stmt->bindParam(':etat', $etat);

        return $stmt->execute();
    }

    public function updateVehicule($id, $immatriculation, $marque, $modele, $date_assurance, $date_visite_technique, $etat) {
        $query = "UPDATE " . $this->table . " 
                  SET immatriculation = :immatriculation, 
                      marque = :marque, 
                      modele = :modele, 
                      date_assurance = :date_assurance, 
                      date_visite_technique = :date_visite_technique, 
                      etat = :etat 
                  WHERE id_vehicule = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':immatriculation', $immatriculation);
        $stmt->bindParam(':marque', $marque);
        $stmt->bindParam(':modele', $modele);
        $stmt->bindParam(':date_assurance', $date_assurance);
        $stmt->bindParam(':date_visite_technique', $date_visite_technique);
        $stmt->bindParam(':etat', $etat);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function deleteVehicule($ids) {
        if (is_array($ids)) {
            $in = str_repeat('?,', count($ids) - 1) . '?';
            $query = "DELETE FROM " . $this->table . " WHERE id_vehicule IN ($in)";
            $stmt = $this->conn->prepare($query);
            return $stmt->execute($ids);
        } else {
            $query = "DELETE FROM " . $this->table . " WHERE id_vehicule = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $ids, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }
}