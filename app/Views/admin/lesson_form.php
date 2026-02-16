<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 animate-up">
            <div class="d-flex align-items-center mb-5">
                <a href="/admin" class="btn btn-outline-primary btn-sm rounded-circle me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-800 mb-0"><?php echo isset($lesson) ? 'Dersi Düzenle' : 'Yeni Ders Ekle'; ?></h2>
            </div>

            <form action="" method="POST">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Seviye</label>
                        <select class="form-select" id="level_id" required>
                            <option value="">Seviye Seçin</option>
                            <?php foreach ($levels as $level): ?>
                                <option value="<?php echo $level['id']; ?>" <?php echo (isset($lesson) && $lesson['level_id'] == $level['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($level['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hafta</label>
                        <select class="form-select" name="week_id" id="week_id" required>
                            <option value="">Önce Seviye Seçin</option>
                            <!-- AJAX or Server side pre-load for edit -->
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Der Başlığı</label>
                        <input type="text" class="form-control" name="title" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['title'] ?? '') : ''; ?>" required>
                    </div>

                    <div class="col-md-8">
                        <label class="form-label fw-bold">Der Tipi</label>
                        <select class="form-select" name="type" required>
                            <?php 
                            $types = ['grammar', 'vocabulary', 'reading', 'podcast', 'infographic', 'quiz', 'video', 'text', 'image'];
                            foreach($types as $type): ?>
                                <option value="<?php echo $type; ?>" <?php echo (isset($lesson) && $lesson['type'] == $type) ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($type); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Sıralama</label>
                        <input type="number" class="form-control" name="order_number" value="<?php echo isset($lesson) ? $lesson['order_number'] : '0'; ?>" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Video URL (Embed)</label>
                        <input type="url" class="form-control" name="video_url" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['video_url'] ?? '') : ''; ?>" placeholder="https://www.youtube.com/embed/...">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Audio URL (MP3)</label>
                        <input type="url" class="form-control" name="audio_url" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['audio_url'] ?? '') : ''; ?>" placeholder="https://example.com/audio.mp3">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Görsel URL</label>
                        <input type="url" class="form-control" name="image_url" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['image_url'] ?? '') : ''; ?>" placeholder="https://example.com/image.jpg">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Alan Becerisi (MEB)</label>
                        <input type="text" class="form-control" name="skill_area" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['skill_area'] ?? '') : ''; ?>" placeholder="Örn: Listening & Speaking">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Kavramsal Beceri (MEB)</label>
                        <input type="text" class="form-control" name="conceptual_skill" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['conceptual_skill'] ?? '') : ''; ?>" placeholder="Örn: Çözümleme">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Eğilim (MEB)</label>
                        <input type="text" class="form-control" name="disposition" value="<?php echo isset($lesson) ? htmlspecialchars($lesson['disposition'] ?? '') : ''; ?>" placeholder="Örn: Merak">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold">Der İçeriği (HTML/Text)</label>
                        <textarea class="form-control" name="content_text" rows="10"><?php echo isset($lesson) ? htmlspecialchars($lesson['content_text'] ?? '') : ''; ?></textarea>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                            <?php echo isset($lesson) ? 'Güncelle' : 'Kaydet'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('level_id').addEventListener('change', function() {
    const levelId = this.value;
    const weekSelect = document.getElementById('week_id');
    
    if (!levelId) {
        weekSelect.innerHTML = '<option value="">Önce Seviye Seçin</option>';
        return;
    }

    fetch('/admin/getWeeks/' + levelId)
        .then(response => response.json())
        .then(data => {
            weekSelect.innerHTML = '<option value="">Hafta Seçin</option>';
            data.forEach(week => {
                const option = document.createElement('option');
                option.value = week.id;
                option.textContent = 'Hafta ' + week.week_number + ': ' + week.title;
                if (<?php echo isset($lesson) ? $lesson['week_id'] : '0'; ?> == week.id) {
                    option.selected = true;
                }
                weekSelect.appendChild(option);
            });
        });
});

// Trigger change on page load if editing
<?php if (isset($lesson)): ?>
window.addEventListener('load', () => {
    document.getElementById('level_id').dispatchEvent(new Event('change'));
});
<?php endif; ?>
</script>
