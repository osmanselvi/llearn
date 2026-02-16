<?php

namespace App\Controllers;

class DashboardController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
    }

    public function index() {
        $data = [
            'title' => 'Dashboard - LLEARN',
            'name' => $_SESSION['user_name'],
            'level' => $_SESSION['user_level']
        ];
        
        $this->render('dashboard/index', $data);
    }
}
