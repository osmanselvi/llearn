<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 mt-5">
            <h2 class="text-center mb-4">Yeni Hesap Oluştur</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="/auth/register" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Ad Soyad</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta Adresi</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Şifre</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Kayıt Ol</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <p>Zaten hesabınız var mı? <a href="/auth/login">Giriş Yap</a></p>
            </div>
        </div>
    </div>
</div>
