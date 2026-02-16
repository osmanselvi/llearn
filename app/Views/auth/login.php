<div class="row justify-content-center py-5 animate-up">
    <div class="col-md-5">
        <div class="text-center mb-5">
            <h1 class="fw-800 text-primary mb-2">Hoş Geldiniz</h1>
            <p class="text-muted">Öğrenme yolculuğuna devam etmek için giriş yapın.</p>
        </div>
        
        <div class="card p-5 border-0 shadow-lg">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mb-4 py-3 border-0 rounded-3 small">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo $error; ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registered'])): ?>
                <div class="alert alert-success mb-4 py-3 border-0 rounded-3 small">
                    <i class="fas fa-check-circle me-2"></i>Kayıt başarılı! Şimdi giriş yapabilirsiniz.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['reset'])): ?>
                <div class="alert alert-success mb-4 py-3 border-0 rounded-3 small">
                    <i class="fas fa-check-circle me-2"></i>Şifreniz başarıyla güncellendi.
                </div>
            <?php endif; ?>

            <form action="/auth/login" method="POST">
                <div class="mb-4">
                    <label for="email" class="form-label fw-bold small">E-posta Adresi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input type="email" name="email" id="email" class="form-control bg-light border-0 py-2" placeholder="email@adresi.com" required>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <label for="password" class="form-label fw-bold small mb-0">Şifre</label>
                        <a href="/auth/forgotPassword" class="small text-decoration-none">Şifremi Unuttum?</a>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-lock text-muted"></i></span>
                        <input type="password" name="password" id="password" class="form-control bg-light border-0 py-2" placeholder="••••••••" required>
                    </div>
                </div>
                
                <div class="d-grid mt-5">
                    <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 shadow-sm">Giriş Yap</button>
                </div>
            </form>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-muted">Hesabınız yok mu? <a href="/auth/register" class="text-primary fw-bold text-decoration-none">Hemen Ücretsiz Kayıt Olun</a></p>
        </div>
    </div>
</div>
