<div class="row mb-5 animate-up">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-2">
            <a href="/admin" class="btn btn-outline-primary btn-sm rounded-circle me-3">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="fw-800 mb-0">Sınav Yönetimi</h1>
        </div>
        <p class="text-muted ps-5">Ders: <?php echo htmlspecialchars($lesson['title']); ?></p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/admin/createQuestion/<?php echo $lesson['id']; ?>" class="btn btn-indigo">
            <i class="fas fa-plus me-2"></i> Yeni Soru Ekle
        </a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <?php 
            switch($_GET['success']) {
                case 'q_created': echo 'Soru başarıyla oluşturuldu.'; break;
                case 'q_updated': echo 'Soru başarıyla güncellendi.'; break;
                case 'q_deleted': echo 'Soru başarıyla silindi.'; break;
            }
        ?>
    </div>
<?php endif; ?>

<div class="row g-4 animate-up">
    <?php if (empty($questions)): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-5 text-center bg-card">
                <div class="text-muted mb-3"><i class="fas fa-info-circle fa-3x"></i></div>
                <h4>Henüz soru eklenmemiş.</h4>
                <p>Bu sınav için ilk sorunuzu ekleyerek başlayın.</p>
            </div>
        </div>
    <?php endif; ?>

    <?php foreach ($questions as $index => $question): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-card">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <h5 class="fw-bold mb-0">
                        <span class="text-primary me-2">#<?php echo $index + 1; ?></span>
                        <?php echo htmlspecialchars($question['question_text']); ?>
                    </h5>
                    <div>
                        <a href="/admin/editQuestion/<?php echo $question['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="/admin/deleteQuestion/<?php echo $question['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu soruyu silmek istediğinize emin misiniz?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                
                <div class="row g-3">
                    <?php foreach ($question['options'] as $option): ?>
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 <?php echo $option['is_correct'] ? 'bg-success bg-opacity-10 border border-success border-opacity-25' : 'bg-light bg-opacity-10 border border-white border-opacity-10'; ?>">
                                <div class="d-flex align-items-center">
                                    <?php if ($option['is_correct']): ?>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                    <?php else: ?>
                                        <i class="far fa-circle text-muted me-2"></i>
                                    <?php endif; ?>
                                    <span class="<?php echo $option['is_correct'] ? 'text-success fw-bold' : ''; ?>">
                                        <?php echo htmlspecialchars($option['option_text']); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
