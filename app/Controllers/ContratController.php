<?php 
require_once __DIR__ . '/../Models/contrat.php'; 
require_once __DIR__ . '/../Models/students.php'; 
require_once __DIR__ . '/../Models/categories.php'; 
require_once __DIR__ . '/../Models/schoolInfo.php';


class ContratController{
    public function index() {
    $database = new Database();
    $db = $database->getConnection();

    $contratModel = new Contrat($db);
    $contrats = $contratModel->getAllWithCandidat();

    $pageTitle = "Gestion des Contrats";
    require_once __DIR__ . '/../Views/contrats/index.php';
}
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
public function create() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id_candidate = $_GET["id"] ?? null; 
        
        $from = $_GET['from'] ?? (!empty($id_candidate) ? 'candidate' : 'contrats');
        
        $database = new Database();
        $db = $database->getConnection();
        
        $categoryModel = new Categorie($db); 
        $categories = $categoryModel->getAllCategories();

        $studentModel = new Students($db); 
        $candidats = $studentModel->getAll(); 

        require_once __DIR__ . '/../Views/students/contrats/create.php';
        exit();
    }
}

   public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_user      = $_POST['id_user'] ?? null;
        $id_categorie = $_POST['id_categorie'] ?? null;
        $date_contrat = $_POST['date_contrat'] ?? null;
        $prix_final   = $_POST['prix_final'] ?? null;
        $statut       = $_POST['statut'] ?? 'En cours';
        $num_enregistrement = $_POST['num_enregistrement'] ?? null;
        
        $from = $_POST['from'] ?? 'contrats';

        if (!empty($id_user) && !empty($id_categorie) && !empty($date_contrat) && !empty($prix_final)) {
            $database = new Database();
            $db = $database->getConnection();

            $contratModel = new Contrat($db);
            
            // ($date, $prix, $statut, $id_user, $id_categorie, $num_enregistrement)
            $result = $contratModel->createContrat(
                $date_contrat, 
                $prix_final, 
                $statut, 
                $id_user, 
                $id_categorie, 
                $num_enregistrement
            );

            if ($result) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Contrat créé avec succès.'];

                if ($from === 'candidate' && !empty($id_user)) {
                    header("Location: /smart-auto-ecole/public/candidates/show?id=" . $id_user);
                } else {
                    header("Location: /smart-auto-ecole/public/contrats");
                }
                exit();
            } else {
                echo "Erreur lors de la création du contrat.";
            }
        } else {
            header("Location: /smart-auto-ecole/public/contrats/create?from=" . $from);
            exit();
        }
    }
}


private function parseIdsFromRequest() {
    if (isset($_GET['ids'])) {
        return is_array($_GET['ids']) ? $_GET['ids'] : [$_GET['ids']];
    }
    if (isset($_POST['ids'])) {
        return is_array($_POST['ids']) ? $_POST['ids'] : [$_POST['ids']];
    }
    if (isset($_GET['id'])) {
        return [$_GET['id']];
    }
    if (isset($_POST['id'])) {
        return [$_POST['id']];
    }
    return [];
}
public function delete() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' || $_SERVER['REQUEST_METHOD'] === 'POST') {
        $ids = $this->parseIdsFromRequest();
        $from = $_REQUEST['from'] ?? 'candidate';
        $studentId = null;

        if (!empty($ids)) {
            $database = new Database(); 
            $db = $database->getConnection(); 
            $contratModel = new Contrat($db); 
            
            $studentId = $contratModel->getStudentIdByContratId($ids[0]);

            if ($contratModel->deleteContrat($ids)) {
                $count = count($ids);
                $msg = ($count > 1) ? "$count contrats supprimés." : 'Contrat supprimé avec succès.';
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['flash'] = ['type' => 'danger', 'message' => $msg];
            }
        }

        if ($from === 'contrats') {
            header('Location: /smart-auto-ecole/public/contrats');
        } elseif ($studentId) {
            header('Location: /smart-auto-ecole/public/candidates/show?id=' . $studentId);
        } else {
            header('Location: /smart-auto-ecole/public/contrats');
        }
        exit();
    }
}
public function edit() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $id_contrat = $_GET['id'] ?? null;
        $from = $_GET['from'] ?? 'candidate';

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

        $redirectUrl = ($from === 'contrats') ? '/smart-auto-ecole/public/contrats' : '/smart-auto-ecole/public/candidates';
        header("Location: " . $redirectUrl);
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
        
        $from = $_POST['from'] ?? 'candidate';

        if (!empty($id_user) && !empty($id_categorie) && !empty($date_contrat) && !empty($prix_final)) {
            $database = new Database();
            $db = $database->getConnection();

            $contratModel = new Contrat($db);
            $result = $contratModel->updateContrat(
                $id_contrat, 
                $date_contrat, 
                $prix_final, 
                $statut, 
                $id_categorie, 
                $num_enregistrement
            );

            if ($result) {
                if (session_status() === PHP_SESSION_NONE) session_start();
                $_SESSION['flash'] = ['type' => 'success', 'message' => 'Contrat mis à jour avec succès.'];

                if ($from === 'contrats') {
                    header("Location: /smart-auto-ecole/public/contrats");
                } else {
                    header("Location: /smart-auto-ecole/public/candidates/show?id=" . $id_user);
                }
                exit();
            } else {
                echo "Erreur lors de la mise à jour du contrat.";
            }
        } else {
            header("Location: /smart-auto-ecole/public/contrats/edit?id=" . $id_contrat . "&from=" . $from);
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
