<?php 
require_once __DIR__ . '/../Models/contrat.php'; 
require_once __DIR__ . '/../Models/students.php'; // استدعاء موديل الطالب

class ContratController{
   public function showContrats() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id_candidate = $_GET["id"] ?? null; 

            if ($id_candidate) {
                $database = new Database(); 
                $db = $database->getConnection(); 

                // 1. جلب معلومات الكونديدا الشخصية
                $studentModel = new Students($db); // أو اسم الموديل عندك فـ Models/students.php
                $candidat = $studentModel->getByid($id_candidate); 

                // 2. جلب قائمة العقود الخاصين بيه
                $contratModel = new Contrat($db); 
                $contrats = $contratModel->getContratsByStudent($id_candidate); 

                // 3. استدعاء الفيو
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
        require_once __DIR__ . '/../Views/students/contrats/create.php' ;
         }
   }
}

   public function store() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        // 1. استقبال البيانات
        $id_user      = $_POST['id_user'] ?? null;
        $id_categorie = $_POST['id_categorie'] ?? null;
        $date_contrat = $_POST['date_contrat'] ?? date('Y-m-d');
        $prix_final   = $_POST['prix_final'] ?? null;
        $statut       = $_POST['statut'] ?? 'En cours';

        // 2. تحقق مرن (تأكد من عدم وجود null أو نص فارغ)
        if (!empty($id_user) && !empty($id_categorie) && !empty($prix_final)) {
            $database = new Database();
            $db = $database->getConnection();

            $contratModel = new Contrat($db);

            // استدعاء الدالة بنفس ترتيب البرامترات التي حددتها فـ Model:
            // createContrat($date, $prix, $statut, $id_user, $id_categorie)
            $result = $contratModel->createContrat($date_contrat, $prix_final, $statut, $id_user, $id_categorie);

            if ($result) {
                // النجاح والتحويل لصفحة الكونديدا
                header("Location: /smart-auto-ecole/public/candidates/show?id=" . $id_user);
                exit();
            } else {
                echo "Erreur lors de la création du contrat dans la base de données.";
            }
        } else {
            // للتأكد والتشخيص: كشف المحتوى القادم من $_POST
            echo "<pre style='background: #f8f9fa; padding: 15px; border: 1px solid #ccc;'>";
            echo "<strong>البيانات القادمة من الفورم:</strong><br>";
            var_dump($_POST);
            echo "</pre>";
            echo "<p style='color: red;'>Veuillez remplir tous les champs obligatoires.</p>";
        }
    }
}
}

?>
