<div class="row mb-5 animate-up">
    <div class="col-md-8">
        <h1 class="fw-800 mb-1">Merhaba, <?php echo htmlspecialchars($name); ?>! 👋</h1>
        <p class="text-muted">Öğrenme yolculuğunda harika ilerliyorsun. Bugün yeni bir ders keşfetmeye ne dersin?</p>
    </div>
    <div class="col-md-4 text-md-end">
        <div class="p-3 bg-card rounded-4 shadow-sm d-inline-block border">
            <span class="text-muted small d-block">Mevcut Seviye</span>
            <span class="fw-bold text-primary h4 mb-0"><?php 
                $levels = [1 => 'A1', 2 => 'A2', 3 => 'B1', 4 => 'B2', 5 => 'C1'];
                echo $levels[$level] ?? 'A1'; 
            ?></span>
        </div>
    </div>
</div>

<div class="row g-4 mb-5 animate-up" style="animation-delay: 0.1s">
    <div class="col-md-4">
        <div class="card dashboard-stat-card border-0 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="bg-white bg-opacity-25 p-3 rounded-3">
                    <i class="fas fa-book-reader fa-xl"></i>
                </div>
                <span class="badge bg-white bg-opacity-25">Bu Hafta</span>
            </div>
            <h3 class="fw-bold mb-1">12 Ders</h3>
            <p class="mb-0 opacity-75">Tamamlanan İçerik</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 p-4" style="background: rgba(255,255,255,0.03);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="bg-success-light p-3 rounded-3" style="color: #10B981;">
                    <i class="fas fa-trophy fa-xl"></i>
                </div>
                <span class="badge bg-success bg-opacity-25 text-success">Ortalama</span>
            </div>
            <h3 class="fw-bold mb-1">85 / 100</h3>
            <p class="mb-0 text-muted">Sınav Başarısı</p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 p-4" style="background: rgba(255,255,255,0.03);">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="bg-warning-light p-3 rounded-3" style="color: #F59E0B;">
                    <i class="fas fa-clock fa-xl"></i>
                </div>
                <span class="badge bg-warning bg-opacity-25 text-warning">Kalan</span>
            </div>
            <h3 class="fw-bold mb-1">4 Hafta</h3>
            <p class="mb-0 text-muted">Mevcut Kur Sonu</p>
        </div>
    </div>
</div>

<div class="row animate-up" style="animation-delay: 0.2s">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold mb-0">Popüler Dersler</h5>
                <a href="/levels" class="small text-decoration-none">Tümünü Gör</a>
            </div>
            <div class="list-group list-group-flush">
                <a href="/levels" class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 rounded border border-white border-opacity-10">
                    <div class="bg-primary-light p-2 rounded me-3" style="color: #6366F1;">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">Daily Greetings</h6>
                        <small class="text-muted">A1 Seviye • 15 Dakika</small>
                    </div>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>
                <a href="/levels" class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 rounded border border-white border-opacity-10">
                    <div class="bg-warning-light p-2 rounded me-3" style="color: #F59E0B;">
                        <i class="fas fa-microphone"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0 fw-bold">Traveling in London</h6>
                        <small class="text-muted">A2 Seviye • 22 Dakika</small>
                    </div>
                    <i class="fas fa-chevron-right text-muted small"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 bg-primary text-white">
            <h5 class="fw-bold mb-4">Haftalık Hedef</h5>
            <div class="text-center py-3">
                <h2 class="display-4 fw-bold mb-0">75%</h2>
                <p class="opacity-75">Hedefe Ulaşıldı</p>
                <div class="progress bg-white bg-opacity-25 mb-4" style="height: 10px;">
                    <div class="progress-bar bg-white" style="width: 75%"></div>
                </div>
                <button class="btn btn-light text-primary w-100 fw-bold">Detayları Gör</button>
            </div>
        </div>
    </div>
</div>
