<?php
// 1. Charger la configuration et les helpers
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../app/helpers.php';

// 2. Démarrer la session si nécessaire
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Mode Debug (à désactiver en production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Base de données et contrôleurs principaux
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php'; // 🟢 إضافة الـ AuthController
require_once __DIR__ . '/../app/Controllers/HomeController.php';
require_once __DIR__ . '/../app/Controllers/StudentsController.php'; 
require_once __DIR__ . '/../app/Controllers/ContratController.php';
require_once __DIR__ . '/../app/Controllers/EmployeController.php'; 
require_once __DIR__ . '/../app/Controllers/VehiculeController.php'; 

// 3. Extraction et nettoyage de l'URI
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = rtrim($requestUri, '/');

// Supprimer le BASE_URL pour ne garder que la route relative
$route = str_replace(BASE_URL, '', $requestUri);

if ($route === '' || $route === '/index.php') {
    $route = '/dashboard';
}

$publicRoutes = ['/login', '/login/submit'];
if (!isset($_SESSION['user_id']) && !in_array($route, $publicRoutes)) {
    redirect('/login');
}

// 4. Dispatch Table (Table de Routage Centralisée)
$routes = [
    // Routes d'authentification (حرة للجميع)
    '/login'                   => [AuthController::class, 'login'],
    '/login/submit'            => [AuthController::class, 'authenticate'],
    '/logout'                  => [AuthController::class, 'logout'],

    // Dashboard & Home
    '/dashboard'               => [HomeController::class, 'index'],

    // Candidates / Students
    '/candidates'              => [StudentController::class, 'index'],
    '/candidates/create'       => [StudentController::class, 'create'],       
    '/candidates/createStudent'=> [StudentController::class, 'create'],
    '/candidates/storeStudent' => [StudentController::class, 'store'],
    '/candidates/edit'         => [StudentController::class, 'edit'],
    '/candidates/store'        => [StudentController::class, 'store'],      
    '/candidates/update'       => [StudentController::class, 'update'],
    '/candidates/archive'      => [StudentController::class, 'archive'],
    '/candidates/activate'     => [StudentController::class, 'activate'],
    '/candidates/delete'       => [StudentController::class, 'delete'],
    '/candidates/show'         => [ContratController::class, 'showContrats'],

    // Contrats (Routes standardisées)
    '/contrats'                => [ContratController::class, 'index'],
    '/contrats/create'         => [ContratController::class, 'create'],
    '/contrats/store'          => [ContratController::class, 'store'],
    '/contrats/edit'           => [ContratController::class, 'edit'],
    '/contrats/update'         => [ContratController::class, 'update'],
    '/contrats/delete'         => [ContratController::class, 'delete'],

    // Contrats (Routes Legacy pour compatibilité)
    '/candidates/contrats/create' => [ContratController::class, 'create'],
    '/candidates/contrats/store'  => [ContratController::class, 'store'],
    '/candidates/contrats/edit'   => [ContratController::class, 'edit'],
    '/candidates/contrats/update' => [ContratController::class, 'update'],
    '/candidates/contrats/delete' => [ContratController::class, 'delete'],
    '/candidates/contrats/print'  => [ContratController::class, 'print'],

    // Employés
    '/employes'                => [EmployeController::class, 'index'],
    '/employes/create'         => [EmployeController::class, 'create'],
    '/employes/store'          => [EmployeController::class, 'store'],
    '/employes/edit'           => [EmployeController::class, 'edit'],
    '/employes/update'         => [EmployeController::class, 'update'],
    '/employes/archive'        => [EmployeController::class, 'archive'],
    '/employes/active'         => [EmployeController::class, 'activate'],
    '/employes/delete'         => [EmployeController::class, 'delete'],

    // Véhicules
    '/vehicules'               => [VehiculeController::class, 'index'],
    '/vehicules/create'        => [VehiculeController::class, 'create'],
    '/vehicules/store'         => [VehiculeController::class, 'store'],
    '/vehicules/edit'          => [VehiculeController::class, 'edit'],
    '/vehicules/update'        => [VehiculeController::class, 'update'],
    '/vehicules/delete'        => [VehiculeController::class, 'delete'],

    // Paramètres (School)
    '/settings/school'        => ['SchoolController', 'index'],
    '/settings/school/update' => ['SchoolController', 'update'],
];

// 5. Exécution du Dispatcher
if (array_key_exists($route, $routes)) {
    [$controllerClass, $method] = $routes[$route];

    // Chargement dynamique du contrôleur si non encore inclus
    if ($controllerClass === 'SchoolController') {
        require_once __DIR__ . '/../app/Controllers/SchoolController.php';
    }

    $controller = new $controllerClass();
    $controller->$method();
} else {
    // Page 404 propre
    header("HTTP/1.0 404 Not Found");
    echo "<h1>404 Page Not Found</h1>";
    echo "<p>Route demandée non trouvée : " . htmlspecialchars($route) . "</p>";
}