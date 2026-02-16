<div class="row mb-5 animate-up">
    <div class="col-md-6">
        <h1 class="fw-800">İçerik Yönetimi</h1>
        <p class="text-muted">Tüm dersleri, haftaları ve seviyeleri buradan yönetebilirsiniz.</p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="/admin/createLesson" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Yeni Ders Ekle
        </a>
    </div>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
        <?php 
            switch($_GET['success']) {
                case 'created': echo 'Der başarıyla oluşturuldu.'; break;
                case 'updated': echo 'Der başarıyla güncellendi.'; break;
                case 'deleted': echo 'Der başarıyla silindi.'; break;
            }
        ?>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-up">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-card">
                <tr>
                    <th class="ps-4">Seviye</th>
                    <th>Hafta</th>
                    <th>Der Başlığı</th>
                    <th>Tür</th>
                    <th>Sıra</th>
                    <th class="text-end pe-4">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-3">
                                <?php echo htmlspecialchars($lesson['level_name']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($lesson['week_title']); ?></td>
                        <td>
                            <div class="fw-bold"><?php echo htmlspecialchars($lesson['title']); ?></div>
                        </td>
                        <td>
                            <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">
                                <?php echo htmlspecialchars($lesson['type']); ?>
                            </small>
                        </td>
                        <td><?php echo $lesson['order_number']; ?></td>
                        <td class="text-end pe-4">
                            <?php if ($lesson['type'] === 'quiz'): ?>
                                <a href="/admin/manageQuiz/<?php echo $lesson['id']; ?>" class="btn btn-sm btn-indigo me-2">
                                    <i class="fas fa-question-circle me-1"></i> Sınav
                                </a>
                            <?php endif; ?>
                            <a href="/admin/editLesson/<?php echo $lesson['id']; ?>" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="/admin/deleteLesson/<?php echo $lesson['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bu dersi silmek istediğinize emin misiniz?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
