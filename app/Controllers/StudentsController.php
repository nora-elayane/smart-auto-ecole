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
                header('Location: /smart-auto-ecole/public/candidates');
                //ajouter message dans url
                exit();
            }
        }
    }
}




?>