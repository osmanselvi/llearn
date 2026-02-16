<?php

namespace App\Controllers;

use App\Models\Level;

class LevelsController extends Controller {
    private $levelModel;

    public function __construct() {
        $this->levelModel = new Level();
    }

    public function index() {
        $data = [
            'title' => 'Seviyeler - LLEARN',
            'levels' => $this->levelModel->getAll()
        ];
        $this->render('levels/index', $data);
    }

    public function view($id) {
        $weeks = $this->levelModel->getWeeks($id);
        $data = [
            'title' => 'Seviye Detayları - LLEARN',
            'weeks' => $weeks,
            'level_id' => $id
        ];
        $this->render('levels/view', $data);
    }
}
