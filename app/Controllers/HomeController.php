<?php

namespace App\Controllers;

class HomeController extends Controller {
    public function index() {
        $data = [
            'title' => 'LLEARN - İngilizce Öğrenim Platformu',
            'message' => 'Hoş Geldiniz!'
        ];
        $this->render('home/index', $data);
    }
}
