<?php

namespace App\Controllers;

class Controller {
    protected function render($view, $data = []) {
        extract($data);
        
        $viewFile = __DIR__ . "/../Views/" . $view . ".php";
        
        if (file_exists($viewFile)) {
            require_once __DIR__ . "/../Views/layout/header.php";
            require_once $viewFile;
            require_once __DIR__ . "/../Views/layout/footer.php";
        } else {
            die("View '$view' not found.");
        }
    }

    protected function requireAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: /dashboard');
            exit;
        }
    }

    protected function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }
}
