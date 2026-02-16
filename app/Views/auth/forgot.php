<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 mt-5 shadow-sm border-0">
            <h2 class="text-center fw-bold mb-4">Şifremi Unuttum</h2>
            <p class="text-muted text-center mb-4">E-posta adresinizi girin, size şifre sıfırlama bağlantısı gönderelim.</p>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form action="/auth/forgotPassword" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta Adresi</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="example@mail.com" required>
                </div>
                <div class="d-grid shadow-sm">
                    <button type="submit" class="btn btn-primary fw-bold">Bağlantı Gönder</button>
                </div>
            </form>
            <div class="text-center mt-4">
                <a href="/auth/login" class="text-decoration-none"><i class="fas fa-arrow-left me-2"></i>Giriş Sayfasına Dön</a>
            </div>
        </div>
    </div>
</div>
