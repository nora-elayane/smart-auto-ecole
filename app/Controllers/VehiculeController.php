<?php
require_once __DIR__ . '/../Models/Vehicule.php';
require_once __DIR__ . '/../Models/schoolInfo.php';

class VehiculeController {

    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $vehiculeModel = new Vehicule($db);
        $vehicules = $vehiculeModel->getAll();

        $schoolModel = new SchoolInfo($db);
        $schoolInfo = $schoolModel->getInfo();

        require_once __DIR__ . '/../Views/vehicules/index.php';
    }

    public function create() {
        $pageTitle = "Nouvelle Véhicule";
        $backUrl = "/smart-auto-ecole/public/vehicules";
        $formAction = "/smart-auto-ecole/public/vehicules/store";
        require_once __DIR__ . '/../Views/vehicules/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $immatriculation = trim($_POST['immatriculation'] ?? '');
            $marque = trim($_POST['marque'] ?? '');
            $modele = trim($_POST['modele'] ?? '');
            $date_assurance = $_POST['date_assurance'] ?? null;
            $date_visite_technique = $_POST['date_visite_technique'] ?? null;
$etat = $_POST['etat'] ?? 'Disponible';
            $database = new Database();
            $db = $database->getConnection();
            $vehiculeModel = new Vehicule($db);

            if ($vehiculeModel->createVehicule($immatriculation, $marque, $modele, $date_assurance, $date_visite_technique, $etat)) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Véhicule ajoutée avec succès.'];
                header('Location: /smart-auto-ecole/public/vehicules');
                exit();
            }
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /smart-auto-ecole/public/vehicules');
            exit();
        }

        $database = new Database();
        $db = $database->getConnection();
        $vehiculeModel = new Vehicule($db);
        $vehicule = $vehiculeModel->getById($id);

        $pageTitle = "Modifier Véhicule";
        $backUrl = "/smart-auto-ecole/public/vehicules";
        $formAction = "/smart-auto-ecole/public/vehicules/update";
        require_once __DIR__ . '/../Views/vehicules/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $immatriculation = trim($_POST['immatriculation'] ?? '');
            $marque = trim($_POST['marque'] ?? '');
            $modele = trim($_POST['modele'] ?? '');
            $date_assurance = $_POST['date_assurance'] ?? null;
            $date_visite_technique = $_POST['date_visite_technique'] ?? null;
            $etat = $_POST['etat'] ?? 'En service';

            $database = new Database();
            $db = $database->getConnection();
            $vehiculeModel = new Vehicule($db);

            if ($vehiculeModel->updateVehicule($id, $immatriculation, $marque, $modele, $date_assurance, $date_visite_technique, $etat)) {
                $_SESSION['flash'] = ['type' => 'info', 'message' => 'Véhicule modifiée avec succès.'];
                header('Location: /smart-auto-ecole/public/vehicules');
                exit();
            }
        }
    }

    public function delete() {
        $raw = $_GET['ids'] ?? $_GET['id'] ?? null;
        if ($raw) {
            $ids = explode(',', $raw);
            $database = new Database();
            $db = $database->getConnection();
            $vehiculeModel = new Vehicule($db);

            if ($vehiculeModel->deleteVehicule($ids)) {
                $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Véhicule(s) supprimée(s) avec succès.'];
            }
        }
        header('Location: /smart-auto-ecole/public/vehicules');
        exit();
    }
}