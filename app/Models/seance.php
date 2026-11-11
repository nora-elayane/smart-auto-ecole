<?php
class Seance {
    private $conn;
    private $table = 'seance';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllSeances() {
        $query = "SELECT s.*, 
                         m.nom as moniteur_nom, m.prenom as moniteur_prenom,
                         v.marque, v.modele, v.immatriculation
                  FROM " . $this->table . " s
                  LEFT JOIN utilisateur m ON s.id_moniteur = m.id_user
                  LEFT JOIN vehicule v ON s.id_vehicule = v.id_vehicule
                  ORDER BY s.date DESC, s.heure_debut DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createSeance($data) {
        $query = "INSERT INTO " . $this->table . " (type, date, heure_debut, heure_fin, id_moniteur, id_vehicule) 
                  VALUES (:type, :date, :heure_debut, :heure_fin, :id_moniteur, :id_vehicule)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':date', $data['date']);
        $stmt->bindParam(':heure_debut', $data['heure_debut']);
        $stmt->bindParam(':heure_fin', $data['heure_fin']);
        $stmt->bindParam(':id_moniteur', $data['id_moniteur']);
        $stmt->bindParam(':id_vehicule', $data['id_vehicule']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Modification d'une séance (refusée au niveau SQL si elle est déjà réalisée)
    public function updateSeance($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET type = :type, date = :date, heure_debut = :heure_debut, heure_fin = :heure_fin,
                      id_moniteur = :id_moniteur, id_vehicule = :id_vehicule
                  WHERE id_seance = :id AND statut <> 'Réalisée'";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':type' => $data['type'], ':date' => $data['date'],
            ':heure_debut' => $data['heure_debut'], ':heure_fin' => $data['heure_fin'],
            ':id_moniteur' => $data['id_moniteur'], ':id_vehicule' => $data['id_vehicule'],
            ':id' => $id,
        ]);
    }

    public function getSeanceById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_seance = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteSeance($id) {
        // participation.id_seance n'a pas ON DELETE CASCADE : on supprime d'abord les inscriptions
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare("DELETE FROM participation WHERE id_seance = :id");
            $stmt->execute([':id' => $id]);
            $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE id_seance = :id");
            $stmt->execute([':id' => $id]);
            $this->conn->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) $this->conn->rollBack();
            error_log('deleteSeance: ' . $e->getMessage());
            return false;
        }
    }

    // UC10 : le moniteur confirme que la séance a été réalisée et ajoute une remarque
    public function validerSeance($id_seance, $remarque) {
        $query = "UPDATE " . $this->table . " 
                  SET statut = 'Réalisée', remarque_moniteur = :remarque 
                  WHERE id_seance = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([':remarque' => $remarque, ':id' => $id_seance]);
    }
}