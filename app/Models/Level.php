<?php

namespace App\Models;

use PDO;

class Level extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM levels ORDER BY id ASC");
        return $stmt->fetchAll();
    }

    public function getWeeks($levelId) {
        $stmt = $this->db->prepare("SELECT * FROM weeks WHERE level_id = :level_id ORDER BY week_number ASC");
        $stmt->execute(['level_id' => $levelId]);
        return $stmt->fetchAll();
    }
}
