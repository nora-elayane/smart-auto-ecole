<?php
// app/helpers.php
function hasRole($roles) {
    if (!isset($_SESSION['user_role'])) {
        return false;
    }
    if (is_array($roles)) {
        return in_array($_SESSION['user_role'], $roles);
    }
    return $_SESSION['user_role'] === $roles;
}

function authorize($roles) {
    if (!hasRole($roles)) {
        $_SESSION['flash'] = [
            'type' => 'danger',
            'message' => 'pas autorisé'
        ];
        redirect('/dashboard'); 
        exit;
    }
}


if (!function_exists('url')) {
    /**
     * Génère une URL absolue pour l'application.
     */
    function url($path = '') {
        $path = ltrim($path, '/');
        return BASE_URL . ($path ? '/' . $path : '');
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirige l'utilisateur vers une URL donnée et arrête le script.
     */
    function redirect($path) {
        header("Location: " . url($path));
        exit();
    }
}