<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/StudentsController.php' ; 

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
}else {
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Page Not Found/h1>";
    echo "<p>current path " . htmlspecialchars($uri) . "</p>"; 
}