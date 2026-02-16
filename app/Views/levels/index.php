<h1 class="mb-4 fw-bold text-center">İngilizce Seviyeleri</h1>
<p class="lead text-center mb-5">Hedeflediğiniz seviyeyi seçin ve öğrenmeye başlayın.</p>

<div class="row mb-5 animate-up">
    <div class="col-md-12 text-center">
        <h1 class="fw-800 display-5 mb-3">Eğitim Seviyeleri</h1>
        <p class="text-muted lead mx-auto" style="max-width: 600px;">Başlangıçtan ileri seviyeye kadar yapılandırılmış müfredatımızla hedefinize adım adım yaklaşın.</p>
    </div>
</div>

<div class="row g-4 animate-up">
    <?php foreach ($levels as $level): ?>
        <div class="col-md-4">
            <div class="card border-0 h-100 p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-primary-light p-3 rounded-circle me-3" style="color: #6366F1;">
                        <span class="h4 fw-bold mb-0"><?php echo htmlspecialchars($level['name']); ?></span>
                    </div>
                    <h5 class="fw-bold mb-0">Seviye Eğitimi</h5>
                </div>
                <p class="text-muted mb-4"><?php echo htmlspecialchars($level['description']); ?></p>
                <div class="mt-auto">
                    <a href="/levels/view/<?php echo $level['id']; ?>" class="btn btn-outline-primary w-100 fw-bold">
                        Haftaları İncele <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
