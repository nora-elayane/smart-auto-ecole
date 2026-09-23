<?php
// app/helpers.php

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