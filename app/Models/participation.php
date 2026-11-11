<?php
class Participation {
    private $conn;
    private $table = 'participation';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function addParticipation($id_seance, $id_contrat, $remarque = null) {
        $query = "INSERT INTO " . $this->table . " (id_seance, id_contrat, presence, remarque) 
                  VALUES (:id_seance, :id_contrat, 'En attente', :remarque)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id_seance', $id_seance);
        $stmt->bindParam(':id_contrat', $id_contrat);
        $stmt->bindParam(':remarque', $remarque);

        return $stmt->execute();
    }

    public function getParticipantsBySeance($id_seance) {
        $query = "SELECT p.*, c.num_enregistrement, u.nom, u.prenom, u.telephone
                  FROM " . $this->table . " p
                  JOIN contrat c ON p.id_contrat = c.id_contrat
                  JOIN utilisateur u ON c.id_user = u.id_user
                  WHERE p.id_seance = :id_seance";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_seance', $id_seance);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Le candidat est-il déjà inscrit à cette séance ?
    public function exists($id_seance, $id_contrat) {
        $query = "SELECT COUNT(*) FROM " . $this->table . " WHERE id_seance = :s AND id_contrat = :c";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':s' => $id_seance, ':c' => $id_contrat]);
        return (int)$stmt->fetchColumn() > 0;
    }

    // Séance à laquelle appartient une participation
    public function getSeanceId($id_participation) {
        $query = "SELECT id_seance FROM " . $this->table . " WHERE id_participation = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $id_participation]);
        return $stmt->fetchColumn();
    }

    public function updatePresence($id_participation, $presence, $remarque) {
        $query = "UPDATE " . $this->table . " 
                  SET presence = :presence, remarque = :remarque 
                  WHERE id_participation = :id";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':presence', $presence);
        $stmt->bindParam(':remarque', $remarque);
        $stmt->bindParam(':id', $id_participation);

        return $stmt->execute();
    }

    public function deleteParticipation($id_participation) {
        $query = "DELETE FROM " . $this->table . " WHERE id_participation = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id_participation);
        return $stmt->execute();
    }
}