<?php
require_once __DIR__ . '/../Models/Employe.php'; 
require_once __DIR__ . '/../Models/schoolInfo.php'; 

class EmployeController {

   public function index() {
    $database = new Database(); 
    $db = $database->getConnection(); 
    
    $employeModel = new Employe($db); 
    
    $employes = $employeModel->getAll(); 

    $schoolModel = new SchoolInfo($db);
    $schoolInfo = $schoolModel->getInfo();

    require_once __DIR__ . '/../Views/employes/index.php'; 
}

    public function show() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /smart-auto-ecole/public/employes');
            exit();
        }

        $database = new Database();
        $db = $database->getConnection();
        $employeModel = new Employe($db);
        $student = $employeModel->getByid($id);

        if (!$student) {
            header('Location: /smart-auto-ecole/public/employes');
            exit();
        }

        $pageTitle = "Détails de l'Employé";
        require_once __DIR__ . '/../Views/users/show.php';
    }

    public function create() {
        $roleId = 2; // Employé
        $pageTitle = "Nouveau Employé";
        $backUrl = "/smart-auto-ecole/public/employes";
        $formAction = "/smart-auto-ecole/public/employes/store";
        require_once __DIR__ . '/../Views/users/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $mot = password_hash($_POST['mot_de_passe'] ?? '123456', PASSWORD_BCRYPT);
            $cin = $_POST['cin'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $adresse = $_POST['adresse'] ?? null;
            $date = $_POST['date_naissance'] ?? '';
            $etat = $_POST['etat'] ?? 'Actif';
            $roleId = $_POST['id_role'] ?? 2; 

            $photoName = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $cleanCin = trim(str_replace(' ', '', $cin));
                $photoName = time() . '_' . $cleanCin . '.' . $ext;
                
                $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/smart-auto-ecole/public/uploads/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }
                move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . $photoName);
            }

            $database = new Database();
            $db = $database->getConnection();
            $employeModel = new Employe($db);
            $result = $employeModel->createEmploye($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photoName, $etat, $roleId);

            if ($result) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Employé ajouté avec succès.'];
                header('Location: /smart-auto-ecole/public/employes');
                exit();
            }
        }
    }

    public function edit() {
        $roleId = 2; // Employé
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'] ?? null; 
            
            if (!$id) {
                header('Location: /smart-auto-ecole/public/employes');
                exit();
            }

            $database = new Database();
            $db = $database->getConnection();
            $employeModel = new Employe($db);
            $student = $employeModel->getByid($id); 

            $pageTitle = "Editer Employé";
            $backUrl = "/smart-auto-ecole/public/employes";
            $formAction = "/smart-auto-ecole/public/employes/update";
            require_once __DIR__ . '/../Views/users/edit.php';
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $cin = $_POST['cin'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $adresse = $_POST['adresse'] ?? null;
            $date = $_POST['date_naissance'] ?? '';
            $etat = $_POST['etat'] ?? 'Actif';
            $roleId = $_POST['id_role'] ?? 2;

            $oldPassword = $_POST['oldmot'] ?? $_POST['mot_de_passe_actuel'] ?? null;

            if (!empty($_POST['mot_de_passe'])) {
                $mot = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
            } else {
                $mot = $oldPassword; 
            }

            $photoName = $_POST['oldphoto'] ?? null;

            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $cleanCin = trim(str_replace(' ', '', $cin));
                $newPhotoName = time() . '_' . $cleanCin . '.' . $ext;
                
                $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/smart-auto-ecole/public/uploads/';
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . $newPhotoName)) {
                    if (!empty($_POST['oldphoto'])) {
                        $oldPath = $targetDir . basename($_POST['oldphoto']);
                        if (file_exists($oldPath)) {
                            unlink($oldPath);
                        }
                    }
                    $photoName = $newPhotoName;
                }
            }

            $database = new Database();
            $db = $database->getConnection();
            $employeModel = new Employe($db);

            $result = $employeModel->updateemploye($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photoName, $etat, $id, $roleId);

            if ($result) {
                $_SESSION['flash'] = ['type' => 'info', 'message' => 'Modifications enregistrées avec succès.'];
                header('Location: /smart-auto-ecole/public/employes');
                exit();     
            } else {
                $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Erreur lors de la mise à jour.'];
                header('Location: /smart-auto-ecole/public/employes/edit?id=' . $id);
                exit();
            }
        }
    }

    private function parseIdsFromRequest() {
        $raw = $_GET['ids'] ?? $_GET['id'] ?? null;
        if (!$raw) return [];

        $ids = explode(',', $raw);
        return array_map('intval', array_filter($ids));
    }

    public function archive() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ids = $this->parseIdsFromRequest();
            if (!empty($ids)) {
                $database = new Database(); 
                $db = $database->getConnection(); 
                $employeModel = new Employe($db); 
                
                if ($employeModel->archiverEmploye($ids)) {
                    $count = count($ids);
                    $msg = ($count > 1) ? "$count employés ont été archivés." : "L'employé a été archivé.";
                    $_SESSION['flash'] = ['type' => 'warning', 'message' => $msg];
                }
            }
            header('Location: /smart-auto-ecole/public/employes');
            exit();
        }
    }

    public function active() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ids = $this->parseIdsFromRequest();
            if (!empty($ids)) {
                $database = new Database(); 
                $db = $database->getConnection(); 
                $employeModel = new Employe($db); 

                if ($employeModel->activerEmploye($ids)) {
                    $count = count($ids);
                    $msg = ($count > 1) ? "$count employés ont été réactivés." : "L'employé a été réactivé.";
                    $_SESSION['flash'] = ['type' => 'success', 'message' => $msg];
                }
            }
            header('Location: /smart-auto-ecole/public/employes');
            exit();
        }
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ids = $this->parseIdsFromRequest();
            if (!empty($ids)) {
                $database = new Database(); 
                $db = $database->getConnection(); 
                $employeModel = new Employe($db); 

                if ($employeModel->deleteemploye($ids)) {
                    $count = count($ids);
                    $msg = ($count > 1) ? "$count employés supprimés définitivement." : "Employé supprimé définitivement.";
                    $_SESSION['flash'] = ['type' => 'danger', 'message' => $msg];
                }
            }
            header('Location: /smart-auto-ecole/public/employes');
            exit();
        }
    }
}
?>