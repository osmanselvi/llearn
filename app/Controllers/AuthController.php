<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Mail;

class AuthController extends Controller {
    private $userModel;
    private $mail;

    public function __construct() {
        $this->userModel = new User();
        $this->mail = new Mail();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("[DEBUG] Login attempt received for: " . $_POST['email']);
            
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user) {
                error_log("[DEBUG] User found in database: " . $user['email']);
                if ($this->userModel->verifyPassword($password, $user['password'])) {
                    error_log("[DEBUG] Password verified for user: " . $user['email']);
                    
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user_name'] = $user['name'];
                    $_SESSION['user_level'] = $user['current_level_id'];
                    $_SESSION['user_role'] = $user['role'];
                    
                    error_log("[DEBUG] Session set, redirecting to /dashboard");
                    header('Location: /dashboard');
                    exit;
                } else {
                    error_log("[DEBUG] Password verification failed for user: " . $user['email']);
                    $data['error'] = 'Geçersiz e-posta veya şifre.';
                }
            } else {
                error_log("[DEBUG] User NOT found in database for email: " . $email);
                $data['error'] = 'Geçersiz e-posta veya şifre.';
            }
        }

        $data['title'] = 'Giriş Yap - LLEARN';
        $this->render('auth/login', $data ?? []);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'level_id' => 1 // A1 default
            ];

            // Simple validation
            if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
                $viewData['error'] = 'Lütfen tüm alanları doldurun.';
            } elseif ($this->userModel->findByEmail($data['email'])) {
                $viewData['error'] = 'Bu e-posta adresi zaten kayıtlı.';
            } else {
                if ($this->userModel->create($data)) {
                    // Welcome Email
                    $subject = "LLEARN LMS'e Hoş Geldiniz!";
                    $body = "<h1>Merhaba " . htmlspecialchars($data['name']) . ",</h1>
                             <p>İngilizce öğrenme yolculuğuna başladığınız için tebrikler! Hesabınız başarıyla oluşturuldu.</p>
                             <p>Hemen giriş yapıp derslerinize başlayabilirsiniz.</p>";
                    $this->mail->send($data['email'], $subject, $body);

                    header('Location: /auth/login?registered=1');
                    exit;
                } else {
                    $viewData['error'] = 'Kayıt sırasında bir hata oluştu.';
                }
            }
        }

        $viewData['title'] = 'Kayıt Ol - LLEARN';
        $this->render('auth/register', $viewData ?? []);
    }

    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $user = $this->userModel->findByEmail($email);

            if ($user) {
                $token = bin2hex(random_bytes(32));
                $this->userModel->saveResetToken($email, $token);

                $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/auth/resetPassword/" . $token;
                $subject = "Şifre Sıfırlama Talebi";
                $body = "<h1>Şifre Sıfırlama</h1>
                         <p>Şifrenizi sıfırlamak için lütfen aşağıdaki bağlantıya tıklayın:</p>
                         <p><a href='$resetLink'>$resetLink</a></p>
                         <p>Bu talebi siz yapmadıysanız lütfen bu e-postayı dikkate almayın.</p>";
                
                if ($this->mail->send($email, $subject, $body)) {
                    $viewData['success'] = 'Şifre sıfırlama bağlantısı e-posta adresinize gönderildi.';
                } else {
                    $viewData['error'] = 'E-posta gönderilirken bir hata oluştu.';
                }
            } else {
                $viewData['error'] = 'Bu e-posta adresi sistemde kayıtlı değil.';
            }
        }

        $viewData['title'] = 'Şifremi Unuttum - LLEARN';
        $this->render('auth/forgot', $viewData ?? []);
    }

    public function resetPassword($token = null) {
        if (!$token) {
            header('Location: /auth/login');
            exit;
        }

        $resetData = $this->userModel->findByResetToken($token);
        if (!$resetData) {
            die("Geçersiz veya süresi dolmuş token.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            if (strlen($password) < 6) {
                $viewData['error'] = 'Şifre en az 6 karakter olmalıdır.';
            } else {
                $this->userModel->updatePassword($resetData['email'], $password);
                $this->userModel->deleteResetToken($resetData['email']);
                header('Location: /auth/login?reset=1');
                exit;
            }
        }

        $viewData['title'] = 'Yeni Şifre Oluştur - LLEARN';
        $viewData['token'] = $token;
        $this->render('auth/reset', $viewData ?? []);
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /');
        exit;
    }
}
