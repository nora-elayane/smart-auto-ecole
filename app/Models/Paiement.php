<?php

class Paiement {
    private $conn;
    private $table = "paiement";

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Enregistrer un nouveau paiement (UC07)
     */
    public function createPaiement($id_contrat, $montant, $mode_paiement, $reference = null) {
        $date_paiement = date('Y-m-d H:i:s');

        $query = "INSERT INTO " . $this->table . " 
                  (montant, date_paiement, mode_paiement, reference, id_contrat) 
                  VALUES (?, ?, ?, ?, ?)";

        $stm = $this->conn->prepare($query);
        $result = $stm->execute([
            $montant,
            $date_paiement,
            $mode_paiement,
            $reference,
            $id_contrat
        ]);

        return $result ? $this->conn->lastInsertId() : false;
    }

    /**
     * Récupérer tous les paiements d'un contrat
     */
    public function getPaiementsByContrat($id_contrat) {
        $query = "SELECT * FROM " . $this->table . " WHERE id_contrat = ? ORDER BY date_paiement DESC";
        $stm = $this->conn->prepare($query);
        $stm->execute([$id_contrat]);
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePaiement($id_paiement, $montant, $mode_paiement, $reference) {
    $query = "UPDATE " . $this->table . " SET montant = ?, mode_paiement = ?, reference = ? WHERE id_paiement = ?";
    $stm = $this->conn->prepare($query);
    return $stm->execute([$montant, $mode_paiement, $reference, $id_paiement]);
}

public function deletePaiement($id_paiement) {
    $query = "DELETE FROM " . $this->table . " WHERE id_paiement = ?";
    $stm = $this->conn->prepare($query);
    return $stm->execute([$id_paiement]);
}

public function getPaiementWithDetails($id_paiement) {
    $query = "SELECT p.*, c.num_enregistrement, u.nom, u.prenom, u.cin, cat.code as categorie_code 
              FROM " . $this->table . " p
              JOIN contrat c ON p.id_contrat = c.id_contrat
              JOIN utilisateur u ON c.id_user = u.id_user
              LEFT JOIN categorie cat ON c.id_categorie = cat.id_categorie
              WHERE p.id_paiement = ? LIMIT 1";
    $stm = $this->conn->prepare($query);
    $stm->execute([$id_paiement]);
    return $stm->fetch(PDO::FETCH_ASSOC);
}
}