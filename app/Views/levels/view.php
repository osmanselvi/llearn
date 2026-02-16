<div class="row mb-5 animate-up">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <a href="/levels" class="btn btn-light rounded-circle p-3 me-3">
                <i class="fas fa-chevron-left text-primary"></i>
            </a>
            <h1 class="fw-800 mb-0">Eğitim Programı</h1>
        </div>
        <p class="text-muted lead">Bu seviye için özel olarak hazırlanan haftalık çalışma planınız aşağıdadır.</p>
    </div>
</div>

<?php if (empty($weeks)): ?>
    <div class="alert alert-info py-4 border-0 rounded-4 shadow-sm">
        <i class="fas fa-info-circle me-2"></i>Bu seviye için henüz içerik eklenmemiş.
    </div>
<?php else: ?>
    <div class="row g-4 animate-up">
        <?php foreach ($weeks as $week): ?>
            <div class="col-md-12">
                <div class="card border-0 shadow-sm p-4 rounded-4 list-group-item-action">
                    <div class="row align-items-center">
                        <div class="col-md-1 text-center">
                            <div class="bg-primary-light p-3 rounded-3 d-inline-block" style="color: #6366F1;">
                                <h4 class="fw-bold mb-0"><?php echo $week['week_number']; ?></h4>
                                <small class="text-uppercase fw-bold" style="font-size: 0.6rem;">Hafta</small>
                            </div>
                        </div>
                        <div class="col-md-8 ps-md-4">
                            <h5 class="fw-bold mb-1"><?php echo htmlspecialchars($week['title']); ?></h5>
                            <p class="text-muted mb-0 small">Grammar, Vocabulary ve Reading pratikleri ile dolu yoğun bir içerik.</p>
                        </div>
                        <div class="col-md-3 text-md-end mt-3 mt-md-0">
                            <a href="/lessons/week/<?php echo $week['id']; ?>" class="btn btn-primary px-4 fw-bold">
                                Derslere Başla <i class="fas fa-play ms-2" style="font-size: 0.8rem;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
