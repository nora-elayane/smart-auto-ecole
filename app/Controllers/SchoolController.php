<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../Models/SchoolInfo.php';

class SchoolController {
    private $db;
    private $schoolModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->schoolModel = new SchoolInfo($this->db);
    }

    public function index() {
        $schoolInfo = $this->schoolModel->getInfo();
        require_once __DIR__ . '/../Views/layouts/sidebar.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // كود Update
            header('Location: /smart-auto-ecole/public/settings/school');
            exit;
        }
    }
}