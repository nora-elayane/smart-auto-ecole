<?php
require_once __DIR__ . '/../Models/students.php' ; 
class StudentController {
    public function index(){
        $database = new Database() ; 
        $db = $database->getConnection() ; 
        $studentModel = new Students($db) ; 
        $students = $studentModel->getAll() ; 
        require_once __DIR__ . '/../Views/students/index.php' ; 
    }
    public function createStudent() {
        $roleId = 4; // Candidat
        $pageTitle = "Nouveau Candidat";
        $backUrl = "/smart-auto-ecole/public/candidates";
        $formAction = "/smart-auto-ecole/public/candidates/storeStudent";
        require_once __DIR__ . '/../Views/users/create.php';
    }

    public function storeStudent() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
            $cin = $_POST['cin'];
            $telephone = $_POST['telephone'];
            $adresse = $_POST['adresse'] ?? null;
            $date = $_POST['date_naissance'];
            $etat = $_POST['etat'] ?? 'Actif';
            $roleId = $_POST['id_role']; 

            $photoName = null;
            if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
                $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
                $photoName = time() . '_' . $cin . '.' . $ext;
                move_uploaded_file($_FILES['photo']['tmp_name'], __DIR__ . '/../../public/uploads/' . $photoName);
            }

            $database = new Database();
            $db = $database->getConnection();
            $studentModel = new Students($db);
            $result = $studentModel->createStudent($nom, $prenom, $email, $mot, $cin, $telephone, $adresse, $date, $photoName, $etat, $roleId);

            if ($result) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Candidat ajouté avec succès.'];
                header('Location: /smart-auto-ecole/public/candidates');
                exit();
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

        if (!empty($_POST['mot_de_passe'])) {
            $mot = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
        } else {
            $mot = $_POST['oldmot'];
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
public function archive(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'] ; 
        $database = new Database() ; 
        $db = $database->getConnection() ; 
        $studentModel = new Students($db) ; 
        $result = $studentModel->archiverStudent($id);
        
        if ($result) {
          $_SESSION['flash'] = ['type' => 'warning', 'message' => 'Le candidat a été archivé.'];
            header('Location: /smart-auto-ecole/public/candidates');
            exit();
        }
    }
}
public function active(){
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'] ; 
        $database = new Database() ; 
        $db = $database->getConnection() ; 
        $studentModel = new Students($db) ; 
        $result = $studentModel->activerStudent($id);
        
        if ($result) {
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Le candidat a été réactivé.'];
            header('Location: /smart-auto-ecole/public/candidates');
            exit();
        }
    }
}
public function delete(){
     if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
        $id = $_GET['id'] ; 
        $database = new Database() ; 
        $db = $database->getConnection() ; 
        $studentModel = new Students($db) ; 
        $result = $studentModel->deleteStudent($id);
        
        if ($result) {
            $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Candidat supprimé définitivement.'];
            header('Location: /smart-auto-ecole/public/candidates');
            exit();
        }
    }
}
}




?>