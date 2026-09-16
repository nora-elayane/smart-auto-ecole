<?php 
require_once __DIR__ . '/../Models/contrat.php'; 
require_once __DIR__ . '/../Models/students.php'; 
require_once __DIR__ . '/../Models/categories.php'; 
require_once __DIR__ . '/../Models/schoolInfo.php';


class ContratController{
   public function showContrats() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_candidate = $_GET["id"] ?? null; 

            if ($id_candidate) {
                $database = new Database(); 
                $db = $database->getConnection(); 

                $studentModel = new Students($db); 
                $candidat = $studentModel->getByid($id_candidate); 

                $contratModel = new Contrat($db); 
                $contrats = $contratModel->getContratsByStudent($id_candidate); 

                require_once __DIR__ . '/../Views/students/show.php'; 
            } else {
                header("Location: /smart-auto-ecole/public/candidates");
                exit();
            }
        }
    }
   public function create(){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id_candidate = $_GET["id"] ?? null ; 
        if($id_candidate){ 
        $database = new Database();
    $db = $database->getConnection();
    
    $categoryModel = new Categorie($db); 
    $categories = $categoryModel->getAllCategories();
        require_once __DIR__ . '/../Views/students/contrats/create.php' ;
         }
   }
}

   public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id_user      = $_POST['id_user'] ?? null;
        $id_categorie = $_POST['id_categorie'] ?? null;
        $date_contrat = $_POST['date_contrat'] ?? date('Y-m-d');
        $prix_final   = $_POST['prix_final'] ?? null;
        $statut       = $_POST['statut'] ?? 'En cours';
        $num_enregistrement = $_POST['num_enregistrement'] ?? null;

        if (!empty($id_user) && !empty($id_categorie) && !empty($prix_final)) {
            $database = new Database();
            $db = $database->getConnection();

            $contratModel = new Contrat($db);

            // createContrat($date, $prix, $statut, $id_user, $id_categorie)
            $result = $contratModel->createContrat($date_contrat, $prix_final, $statut, $id_user, $id_categorie , $num_enregistrement);

            if ($result) {
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Contrat ajouté avec succès.'];
                header("Location: /smart-auto-ecole/public/candidates/show?id=" . $id_user);
                exit();

            } else {
                echo "Erreur lors de la création du contrat dans la base de données.";
            }
        } else {
            echo "<pre style='background: #f8f9fa; padding: 15px; border: 1px solid #ccc;'>";
            echo "<strong>البيانات القادمة من الفورم:</strong><br>";
            var_dump($_POST);
            echo "</pre>";
            echo "<p style='color: red;'>Veuillez remplir tous les champs obligatoires.</p>";
        }
    }
}
private function parseIdsFromRequest() {
        $raw = $_GET['ids'] ?? $_GET['id'] ?? null;
        if (!$raw) return [];
        $ids = explode(',', $raw);
        return array_map('intval', array_filter($ids));
    }
 public function delete(){
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $ids = $this->parseIdsFromRequest();
        $studentId = null;
        if (!empty($ids)) {
            $database = new Database(); 
            $db = $database->getConnection(); 
            $contratModel = new Contrat($db); 
            $studentId = $contratModel->getStudentIdByContratId($ids[0]);

            if ($contratModel->deleteContrat($ids)) {
                $count = count($ids);
                $msg = ($count > 1) ? "$count contrats supprimés." : 'Contrat supprimé.';
                $_SESSION['flash'] = ['type' => 'danger', 'message' => $msg];
            }
        }

        if ($studentId) {
            header('Location: /smart-auto-ecole/public/candidates/show?id=' . $studentId);
        } else {
            header('Location: /smart-auto-ecole/public/candidates');
        }
        exit();
    }
}
public function edit() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id_contrat = $_GET['id'] ?? null;
        if (!$id_contrat) {
            $ids = $this->parseIdsFromRequest();
            $id_contrat = $ids[0] ?? null;
        }

        if ($id_contrat) {
            $database = new Database();
            $db = $database->getConnection();

            $contratModel = new Contrat($db);
            $contrat = $contratModel->getContratById($id_contrat);

            $categoryModel = new Categorie($db);
            $categories = $categoryModel->getAllCategories();

            if ($contrat) {
                require_once __DIR__ . '/../Views/students/contrats/edit.php';
                exit();
            }
        }

        header("Location: /smart-auto-ecole/public/candidates");
        exit();
    }
}

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_contrat   = $_POST['id_contrat'] ?? null;
            $id_user      = $_POST['id_user'] ?? null;
            $id_categorie = $_POST['id_categorie'] ?? null;
            $date_contrat = $_POST['date_contrat'] ?? null;
            $prix_final   = $_POST['prix_final'] ?? null;
            $statut       = $_POST['statut'] ?? 'En cours';
            $num_enregistrement = $_POST['num_enregistrement'] ?? null;

            if (!empty($id_user) && !empty($id_categorie) && !empty($date_contrat) && !empty($prix_final)) {
                $database = new Database();
                $db = $database->getConnection();

                $contratModel = new Contrat($db);
                $result = $contratModel->updateContrat($id_contrat, 
    $date_contrat, 
    $prix_final, 
    $statut, 
    $id_categorie, 
    $num_enregistrement);

                if ($result) {
                    if (session_status() === PHP_SESSION_NONE) session_start();
                    $_SESSION['flash'] = ['type' => 'success', 'message' => 'Contrat mis à jour avec succès.'];
                    header("Location: /smart-auto-ecole/public/candidates/show?id=" . $id_user);
                    exit();
                } else {
                    echo "Erreur lors de la mise à jour du contrat.";
                }
            } else {
                header("Location: /smart-auto-ecole/public/candidates/contrats/edit?id=" . $id_contrat);
                exit();
            }
        }
    }

    public function print() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $type = $_GET['type'] ?? 'contrat';
        $id_contrat = $_GET['id'] ?? null;

        if (empty($id_contrat)) {
            die("Error " . var_export($id_contrat, true));
        }

        $database = new Database();
        $db = $database->getConnection();

        $schoolModel = new SchoolInfo($db);
        $school = $schoolModel->getInfo();

        $contratModel = new Contrat($db);
        $contrat = $contratModel->getContratById($id_contrat);

        if (!$contrat) {
            die("Error " . htmlspecialchars($id_contrat));
        }

        $studentModel = new Students($db);
        $candidat = $studentModel->getByid($contrat['id_user']);

        $baseViewPath = __DIR__ . '/../Views/students/prints/';

        switch ($type) {
            case 'attestation':
                $file = $baseViewPath . 'attestation_print.php';
                break;
            case 'carte':
                $file = $baseViewPath . 'carte_print.php';
                break;
            case 'contrat':
            default:
                $file = $baseViewPath . 'contrat_print.php';
                break;
        }

        if (file_exists($file)) {
            require_once $file;
        } else {
            die("Error " . htmlspecialchars($file));
        }
    }
}
 
}

?>
