<?php
class PlanningController {
        public function index() {
        authorize([1, 2]); 
        
        $database = new Database();
        $db = $database->getConnection();
        
        require_once __DIR__ . '/../Models/seance.php';
        require_once __DIR__ . '/../Models/User.php'; 
        require_once __DIR__ . '/../Models/Vehicule.php'; 
        
        $seanceModel = new Seance($db);
        $userModel = new User($db);
        $vehiculeModel = new Vehicule($db);
        
        $seances = $seanceModel->getAllSeances();
        $moniteurs = $userModel->getUsersByRole(2);
        $vehicules = $vehiculeModel->getAllVehicules();

        require_once __DIR__ . '/../Views/planning/index.php';
    }

    public function store() {
        authorize([1, 2]);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();
            
            require_once __DIR__ . '/../Models/seance.php';
            $seanceModel = new Seance($db);
            
            $data = [
                'type' => $_POST['type'] ?? 'Conduite',
                'date' => $_POST['date'] ?? '',
                'heure_debut' => $_POST['heure_debut'] ?? '',
                'heure_fin' => $_POST['heure_fin'] ?? '',
                'id_moniteur' => !empty($_POST['id_moniteur']) ? $_POST['id_moniteur'] : null,
                'id_vehicule' => !empty($_POST['id_vehicule']) ? $_POST['id_vehicule'] : null
            ];

            $id_seance = $seanceModel->createSeance($data);
            
            if ($id_seance) {
                if (!empty($_POST['id_contrat'])) {
                    require_once __DIR__ . '/../Models/participation.php';
                    $participationModel = new Participation($db);
                    $participationModel->addParticipation($id_seance, $_POST['id_contrat']);
                }

                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Seance planifié avec succé'];
            } else {
                $_SESSION['flash'] = ['type' => 'danger', 'message' =>'Ereur'];
            }
            
            header("Location: " . BASE_URL . "/planning");
            exit();
        }
    }

    public function delete() {
        authorize([1, 2]);
        $id = $_POST['id_seance'] ?? $_GET['id'] ?? null;
        
        if ($id) {
            $database = new Database();
            $db = $database->getConnection();
            
            require_once __DIR__ . '/../Models/seance.php';
            $seanceModel = new Seance($db);
            
            if ($seanceModel->deleteSeance($id)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Seance supprimé avec succé'];
            } else {
                $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Erreur'];
            }
        }
        
        header("Location: " . BASE_URL . "/planning");
        exit();
    }
}