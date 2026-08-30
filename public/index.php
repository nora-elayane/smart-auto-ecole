<?php

// إظهار الأخطاء للتطوير
ini_set('display_errors', 1);
error_reporting(E_ALL);

// استدعاء ملف الاتصال بالداتابيز والـ Controllers
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/StudentsController.php' ; 

// قراءة الـ URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri , '/') ; 
$basePath = '/smart-auto-ecole/public' ; 

// Simple Router
if ($uri === $basePath . '/dashboard' || $uri === $basePath .  '/index.php' || $uri === '') {
    $controller = new HomeController();
    $controller->index();
}elseif($uri === $basePath .  '/candidates'){
    $controller = new StudentController() ; 
    $controller->index() ; 
} else {
    // صفحة 404 إلا كان المسار خاطئ
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 - الصفحة غير موجودة</h1>";
    echo "<p>المسار الحالي: " . htmlspecialchars($uri) . "</p>"; 
}