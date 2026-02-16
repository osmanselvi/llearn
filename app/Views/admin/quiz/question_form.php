<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 animate-up">
            <div class="d-flex align-items-center mb-5">
                <a href="/admin/manageQuiz/<?php echo isset($question) ? $question['lesson_id'] : $lesson_id; ?>" class="btn btn-outline-primary btn-sm rounded-circle me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-800 mb-0"><?php echo isset($question) ? 'Soruyu Düzenle' : 'Yeni Soru Ekle'; ?></h2>
            </div>

            <form action="" method="POST" id="questionForm">
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label fw-bold">Soru Metni</label>
                        <textarea class="form-control" name="question_text" rows="3" required><?php echo isset($question) ? htmlspecialchars($question['question_text']) : ''; ?></textarea>
                    </div>

                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Seçenekler</h5>
                            <button type="button" class="btn btn-sm btn-outline-indigo" onclick="addOption()">
                                <i class="fas fa-plus me-1"></i> Seçenek Ekle
                            </button>
                        </div>
                        
                        <div id="optionsContainer">
                            <?php if (isset($question)): ?>
                                <?php foreach ($question['options'] as $index => $option): ?>
                                    <div class="option-row mb-3 d-flex align-items-center">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="correct_option" value="<?php echo $index; ?>" <?php echo $option['is_correct'] ? 'checked' : ''; ?> required>
                                        </div>
                                        <input type="text" class="form-control me-2" name="options[]" value="<?php echo htmlspecialchars($option['option_text']); ?>" placeholder="Seçenek metni" required>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.parentElement.remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="option-row mb-3 d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="correct_option" value="0" checked required>
                                    </div>
                                    <input type="text" class="form-control me-2" name="options[]" placeholder="Seçenek metni" required>
                                </div>
                                <div class="option-row mb-3 d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="correct_option" value="1" required>
                                    </div>
                                    <input type="text" class="form-control me-2" name="options[]" placeholder="Seçenek metni" required>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                            <?php echo isset($question) ? 'Güncelle' : 'Kaydet'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addOption() {
    const container = document.getElementById('optionsContainer');
    const index = container.children.length;
    const row = document.createElement('div');
    row.className = 'option-row mb-3 d-flex align-items-center';
    row.innerHTML = `
        <div class="form-check me-3">
            <input class="form-check-input" type="radio" name="correct_option" value="${index}" required>
        </div>
        <input type="text" class="form-control me-2" name="options[]" placeholder="Seçenek metni" required>
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.parentElement.remove(); reindexOptions();">
            <i class="fas fa-times"></i>
        </button>
    `;
    container.appendChild(row);
}

function reindexOptions() {
    const radios = document.querySelectorAll('input[name="correct_option"]');
    radios.forEach((radio, index) => {
        radio.value = index;
    });
}
</script>
