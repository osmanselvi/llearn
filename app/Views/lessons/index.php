<h2 class="fw-bold mb-4">Haftalık Dersler</h2>

<div class="list-group shadow-sm border-0">
    <?php if (empty($lessons)): ?>
        <div class="alert alert-info">Bu hafta için henüz ders eklenmemiş.</div>
    <?php else: ?>
        <?php foreach ($lessons as $index => $lesson): ?>
            <a href="/lessons/view/<?php echo $lesson['id']; ?>" class="list-group-item list-group-item-action p-4 d-flex justify-content-between align-items-center mb-2 border-0 rounded">
                <div>
                    <span class="badge bg-light text-primary border mb-2"><?php echo strtoupper($lesson['type']); ?></span>
                    <h5 class="mb-0 fw-bold"><?php echo ($index + 1) . '. ' . htmlspecialchars($lesson['title']); ?></h5>
                </div>
                <i class="fas fa-chevron-right text-muted"></i>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
