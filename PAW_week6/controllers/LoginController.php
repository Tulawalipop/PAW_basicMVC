<?php
require_once __DIR__ . '/../models/UserModel.php';

class LoginController {

    public function handleRequest() {
        session_start();

        // Logout: index.php?action=logout
        if (isset($_GET['action']) && $_GET['action'] === 'logout') {
            session_destroy();
            header('Location: index.php');
            exit;
        }

        // Proses form login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->checkLogin($email, $password);

            if ($user) {
                session_regenerate_id(true);
                $_SESSION['user'] = $user;
                header('Location: index.php');
                exit;
            }

            $this->render('login', [
                'error' => 'Email atau password salah.'
            ]);
            return;
        }

        if (isset($_SESSION['user'])) {
            $this->render('dashboard');
        } else {
            $this->render('login');
        }
    }

    private function render($view, $data = []) {
        extract($data);
        include __DIR__ . '/../views/' . $view . '.php';
    }
}