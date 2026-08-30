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
}





?>