<?php

namespace App\Models;

use PDO;
use PDOException;

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct() {
        // .env dosyasından okuma simülasyonu (basit bir parser)
        $env = parse_ini_file(__DIR__ . '/../../.env');
        
        $this->host = $env['DB_HOST'] ?? 'localhost';
        $this->db_name = $env['DB_NAME'] ?? 'llearn_db';
        $this->username = $env['DB_USER'] ?? 'llearn_user';
        $this->password = $env['DB_PASS'] ?? '';
    }

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch(PDOException $exception) {
            error_log("Bağlantı Hatası: " . $exception->getMessage());
            die("Veritabanı bağlantısı kurulamadı. Lütfen sistem yöneticisine başvurun.");
        }

        return $this->conn;
    }
}
