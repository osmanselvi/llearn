<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card p-4 mt-5 shadow-sm border-0">
            <h2 class="text-center fw-bold mb-4">Yeni Şifre Oluştur</h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form action="/auth/resetPassword/<?php echo $token; ?>" method="POST">
                <div class="mb-3">
                    <label for="password" class="form-label">Yeni Şifre</label>
                    <input type="password" name="password" id="password" class="form-control" required minlength="6">
                    <div class="form-text">Şifreniz en az 6 karakter olmalıdır.</div>
                </div>
                <div class="d-grid shadow-sm">
                    <button type="submit" class="btn btn-success fw-bold">Şifreyi Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>
