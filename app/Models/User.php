<?php

namespace App\Models;

use PDO;

class User extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO users (name, email, password, current_level_id) VALUES (:name, :email, :password, :level_id)";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            'name' => htmlspecialchars(strip_tags($data['name'])),
            'email' => filter_var($data['email'], FILTER_SANITIZE_EMAIL),
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'level_id' => $data['level_id'] ?? 1 // Default to A1
        ]);
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

    public function saveResetToken($email, $token) {
        $this->db->prepare("DELETE FROM password_resets WHERE email = :email")->execute(['email' => $email]);
        $stmt = $this->db->prepare("INSERT INTO password_resets (email, token) VALUES (:email, :token)");
        return $stmt->execute(['email' => $email, 'token' => $token]);
    }

    public function findByResetToken($token) {
        $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE token = :token");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch();
    }

    public function updatePassword($email, $newPassword) {
        $stmt = $this->db->prepare("UPDATE users SET password = :password WHERE email = :email");
        return $stmt->execute([
            'email' => $email,
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);
    }

    public function deleteResetToken($email) {
        $stmt = $this->db->prepare("DELETE FROM password_resets WHERE email = :email");
        return $stmt->execute(['email' => $email]);
    }
}
