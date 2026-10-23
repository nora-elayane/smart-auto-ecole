<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController {

    public function login() {
        if (isset($_SESSION['user_id'])) {
            redirect('/dashboard');
        }
        
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['mot_de_passe'] ?? '';

            if (empty($email) || empty($password)) {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Veuillez remplir tous les champs.'
                ];
                redirect('/login');
            }

            $database = new Database();
            $db = $database->getConnection();
            $userModel = new User($db);
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['mot_de_passe'])) {
                if (isset($user['etat']) && $user['etat'] !== 'Actif') {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => 'Votre compte est désactivé. Veuillez contacter l\'administration.'
                    ];
                    redirect('/login');
                }
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['user_nom'] = $user['nom'] . ' ' . $user['prenom'];
                $_SESSION['user_role'] = $user['id_role']; 

                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => 'Bienvenue, ' . $user['prenom'] . ' !'
                ];

                redirect('/dashboard');
            } else {
                $_SESSION['flash'] = [
                    'type' => 'danger',
                    'message' => 'Email ou mot de passe incorrect.'
                ];
                redirect('/login');
            }
        }
    }

    public function logout() {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();

        session_start();
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => 'Vous avez été déconnecté avec succès.'
        ];
        
        redirect('/login');
    }
}