<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/StudentsController.php' ; 
require_once __DIR__ . '/../app/Controllers/ContratController.php' ; 

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri , '/') ; 
$basePath = '/smart-auto-ecole/public' ; 

if ($uri === $basePath . '/dashboard' || $uri === $basePath .  '/index.php' || $uri === '') {
    $controller = new HomeController();
    $controller->index();
}elseif($uri === $basePath .  '/candidates'){
    $controller = new StudentController() ; 
    $controller->index() ; 
}elseif($uri === $basePath . '/candidates/createStudent'){
    $controller = new StudentController() ;
    $controller->createStudent() ;

}elseif($uri === $basePath . '/candidates/storeStudent'){
    $controller = new StudentController();
    $controller->storeStudent();
}elseif($uri === $basePath . '/candidates/edit'){
    $controller = new StudentController();
    $controller->edit();
}elseif($uri === $basePath . '/candidates/update'){
    $controller = new StudentController();
    $controller->update();
}elseif($uri === $basePath . '/candidates/archive'){
    $controller = new StudentController();
    $controller->archive();
}elseif($uri === $basePath . '/candidates/activate'){
    $controller = new StudentController();
    $controller->active();
}elseif($uri === $basePath . '/candidates/delete'){
    $controller = new StudentController();
    $controller->delete();
}elseif($uri === $basePath . '/candidates/show'){
    $controller = new ContratController();
    $controller->showContrats();
}elseif($uri === $basePath . '/candidates/contrats/create'){
    $controller = new ContratController();
    $controller->create();
}elseif($uri === $basePath . '/candidates/contrats/store'){
    $controller = new ContratController();
    $controller->store();
}else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Page Not Found/h1>";
    echo "<p>current path " . htmlspecialchars($uri) . "</p>"; 
}