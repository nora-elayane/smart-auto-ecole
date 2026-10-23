<?php
require_once __DIR__ . '/../Models/students.php'; 
require_once __DIR__ . '/../Models/schoolInfo.php'; 

class StudentController {

public function __construct() {
        authorize([1, 2]);
    }

    public function index(){
        $database = new Database(); 
        $db = $database->getConnection(); 
        
        $studentModel = new Students($db); 
        $students = $studentModel->getAll(); 

        $schoolModel = new SchoolInfo($db);
        $schoolInfo = $schoolModel->getInfo();

        require_once __DIR__ . '/../Views/students/index.php'; 
    }

    public function create() {
        $roleId = 4; // Candidat
        $pageTitle = "Nouveau Candidat";
        $backUrl = "/smart-auto-ecole/public/candidates";
        $formAction = "/smart-auto-ecole/public/candidates/store";
        require_once __DIR__ . '/../Views/users/create.php';
    }

public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            // 1. Nettoyage des entrées (Sanitization)
            $nom       = trim($_POST['nom'] ?? '');
            $prenom    = trim($_POST['prenom'] ?? '');
            $email     = trim($_POST['email'] ?? '');
            $cin       = trim($_POST['cin'] ?? '');
            $telephone = trim($_POST['telephone'] ?? '');
            $date      = $_POST['date_naissance'] ?? null;
            $roleId    = $_POST['id_role'] ?? null;
            $adresse   = trim($_POST['adresse'] ?? '');
            $etat      = $_POST['etat'] ?? 'Actif';

            // 2. Validation côté serveur avec Expressions Régulières (Regex)
            if (empty($nom) || empty($prenom) || empty($email) || empty($cin) || empty($telephone)) {
                throw new Exception("Veuillez remplir tous les champs obligatoires.");
            }

            //  Validation Regex Format Email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("L'adresse e-mail n'est pas valide.");
            }

            //  Validation Regex CIN Marocain (Ex: AB123456 ou A12345)
            if (!preg_match('/^[A-Za-z]{1,2}[0-9]{5,6}$/', $cin)) {
                throw new Exception("Le format du CIN n'est pas valide (ex: AB123456).");
            }

            //  Validation Regex Téléphone Marocain (Ex: 0612345678 ou 0712345678 ou +212...)
            if (!preg_match('/^(0|\+212)[5-7][0-9]{8}$/', $telephone)) {
                throw new Exception("Le numéro de téléphone n'est pas valide.");
            }

            //  Hash du mot de passe
            $mot = !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT) : null;

            // 3. Gestion sécurisée de l'upload de la photo
            $photoName = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
                $allowedExts = ['jpg', 'jpeg', 'png', 'webp'];

                if (!in_array($ext, $allowedExts)) {
                    throw new Exception("Le format de l'image n'est pas autorisé (JPG, PNG, WEBP uniquement).");
                }

                // Vérification de la taille (max 2 Mo)
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    throw new Exception("La taille de l'image ne doit pas dépasser 2 Mo.");
                }

                $uploadDir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $photoName = time() . '_' . preg_replace('/[^A-Za-z0-9]/', '', $cin) . '.' . $ext;
                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $uploadDir . $photoName)) {
                    throw new Exception("Échec du téléchargement de la photo.");
                }
            }

            // 4. Insertion en Base de Données
            $database = new Database();
            $db = $database->getConnection();
            $studentModel = new Students($db);

            $result = $studentModel->create($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photoName, $etat, $roleId);

            if ($result) {
                $_SESSION['flash'] = [
                    'type' => 'success', 
                    'message' => 'Candidat ajouté avec succès.'
                ];
                redirect('/candidates');
            } else {
                throw new Exception("Impossible d'ajouter le candidat.");
            }

        } catch (PDOException $e) {
            error_log("Database Error in store(): " . $e->getMessage()); 

            if ($e->getCode() == 23000 || str_contains($e->getMessage(), '23000')) {
                $message = "Le CIN ou l'adresse e-mail renseigné existe déjà dans le système.";
            } else {
                $message = "Une erreur technique est survenue lors de l'enregistrement. Veuillez réessayer.";
            }

            $_SESSION['flash'] = [
                'type' => 'danger', 
                'message' => $message
            ];
            redirect('/candidates/create');

        } catch (Exception $e) {
            $_SESSION['flash'] = [
                'type' => 'danger', 
                'message' => $e->getMessage()
            ];
            redirect('/candidates/create');
        }
    }
}
    public function edit(){
                $roleId = 4; // Candidat
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $id = $_GET['id'] ; 
                $database = new Database();
                $db = $database->getConnection();
                $studentModel = new Students($db);
                $student = $studentModel->getByid($id) ; 
                $pageTitle = "Editer Candidat";
                $backUrl = "/smart-auto-ecole/public/candidates";
                $formAction = "/smart-auto-ecole/public/candidates/update";
                require_once __DIR__ . '/../Views/users/edit.php';
    }}
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
        $roleId = $_POST['id_role'] ?? 4;

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
            $photoName = time() . '_' . $cleanCin . '.' . $ext;
            
            $targetDir = __DIR__ . '/../../public/uploads/';
            $targetPath = $targetDir . $photoName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
                if (!empty($_POST['oldphoto'])) {
                    $oldPath = $targetDir . $_POST['oldphoto'];
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }
        }

        $database = new Database();
        $db = $database->getConnection();
        $studentModel = new Students($db);

        $result = $studentModel->updateStudent($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photoName, $etat, $id, $roleId);

        if ($result) {
            $_SESSION['flash'] = ['type' => 'info', 'message' => 'Modifications enregistrées avec succès.'];            header('Location: /smart-auto-ecole/public/candidates');
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

    public function archive(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ids = $this->parseIdsFromRequest();
            if (!empty($ids)) {
                $database = new Database(); 
                $db = $database->getConnection(); 
                $studentModel = new Students($db); 
                
                if ($studentModel->archiverStudent($ids)) {
                    $count = count($ids);
                    $msg = ($count > 1) ? "$count candidats ont été archivés." : 'Le candidat a été archivé.';
                    $_SESSION['flash'] = ['type' => 'warning', 'message' => $msg];
                }
            }
            header('Location: /smart-auto-ecole/public/candidates');
            exit();
        }
    }

    public function activate(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ids = $this->parseIdsFromRequest();
            if (!empty($ids)) {
                $database = new Database(); 
                $db = $database->getConnection(); 
                $studentModel = new Students($db); 

                if ($studentModel->activerStudent($ids)) {
                    $count = count($ids);
                    $msg = ($count > 1) ? "$count candidats ont été réactivés." : 'Le candidat a été réactivé.';
                    $_SESSION['flash'] = ['type' => 'success', 'message' => $msg];
                }
            }
            header('Location: /smart-auto-ecole/public/candidates');
            exit();
        }
    }

    public function delete(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $ids = $this->parseIdsFromRequest();
            if (!empty($ids)) {
                $database = new Database(); 
                $db = $database->getConnection(); 
                $studentModel = new Students($db); 

                if ($studentModel->deleteStudent($ids)) {
                    $count = count($ids);
                    $msg = ($count > 1) ? "$count candidats supprimés définitivement." : 'Candidat supprimé définitivement.';
                    $_SESSION['flash'] = ['type' => 'danger', 'message' => $msg];
                }
            }
            header('Location: /smart-auto-ecole/public/candidates');
            exit();
        }
    }
}




?>