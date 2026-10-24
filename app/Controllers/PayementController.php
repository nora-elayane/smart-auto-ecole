<?php

class PaymentController {

    public function store() {
        authorize([1, 2]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_contrat = $_POST['id_contrat'] ?? null;
            $montant = floatval($_POST['montant'] ?? 0);
            $mode_paiement = trim($_POST['mode_paiement'] ?? 'Espèces');
            $reference = !empty($_POST['reference']) ? trim($_POST['reference']) : null;

            if ($id_contrat && $montant > 0) {
                $database = new Database();
                $db = $database->getConnection();

                require_once __DIR__ . '/../Models/Paiement.php';
                $paiementModel = new Paiement($db);

                $insertedId = $paiementModel->createPaiement($id_contrat, $montant, $mode_paiement, $reference);

                if ($insertedId) {
                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => 'Paiement de ' . number_format($montant, 2) . ' DH ajouté avec succès !'
                    ];
                } else {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Erreur lors de l\'enregistrement dans la base de données.'
                    ];
                }
            }

            header("Location: " . BASE_URL . "/contrats/show?id=" . $id_contrat);
            exit();
        }
    }

 public function print() {
    authorize([1, 2]);
    
    // Récupération de l'id depuis table-actions.js (GET ou POST)
    $id = $_GET['id'] ?? $_POST['id'] ?? null;
    
    if (!$id) {
        header("Location: " . BASE_URL . "/contrats");
        exit();
    }

    $database = new Database();
    $db = $database->getConnection();
    
    require_once __DIR__ . '/../Models/Paiement.php';
    require_once __DIR__ . '/../Models/SchoolInfo.php';
    
    $paiementModel = new Paiement($db);
    $schoolModel = new SchoolInfo($db);
    
    $paiement = $paiementModel->getPaiementWithDetails($id);
    $schoolInfo = $schoolModel->getInfo();

    require_once __DIR__ . '/../Views/prints/recu_paiement.php';
}
public function update() {
    authorize([1, 2]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_paiement = $_POST['id_paiement'];
        $id_contrat = $_POST['id_contrat'];
        $montant = floatval($_POST['montant']);
        $mode = $_POST['mode_paiement'];
        $ref = $_POST['reference'];

        $database = new Database();
        $db = $database->getConnection();
        require_once __DIR__ . '/../Models/Paiement.php';
        (new Paiement($db))->updatePaiement($id_paiement, $montant, $mode, $ref);

        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Paiement mis à jour !'];
        header("Location: " . BASE_URL . "/contrats/show?id=" . $id_contrat);
        exit();
    }
}

public function delete() {
    authorize([1, 2]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_paiement = $_POST['id_paiement'];
        $id_contrat = $_POST['id_contrat'];

        $database = new Database();
        $db = $database->getConnection();
        require_once __DIR__ . '/../Models/Paiement.php';
        (new Paiement($db))->deletePaiement($id_paiement);

        $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Paiement supprimé !'];
        header("Location: " . BASE_URL . "/contrats/show?id=" . $id_contrat);
        exit();
    }
}
}