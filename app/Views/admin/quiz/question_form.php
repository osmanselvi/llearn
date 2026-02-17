<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 animate-up">
            <div class="d-flex align-items-center mb-5">
                <a href="/admin/manageQuiz/<?php echo isset($question) ? $question['lesson_id'] : $lesson_id; ?>" class="btn btn-outline-primary btn-sm rounded-circle me-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="fw-800 mb-0"><?php echo isset($question) ? 'Alıştırmayı Düzenle' : 'Yeni Alıştırma/Soru Ekle'; ?></h2>
            </div>

            <form action="" method="POST" id="questionForm">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Alıştırma Türü</label>
                        <select class="form-select" name="type" id="typeSelect" onchange="toggleTypeFields()" required>
                            <option value="multiple_choice" <?php echo (isset($question) && $question['type'] == 'multiple_choice') ? 'selected' : ''; ?>>Çoktan Seçmeli (Multiple Choice)</option>
                            <option value="matching" <?php echo (isset($question) && $question['type'] == 'matching') ? 'selected' : ''; ?>>Eşleştirme (Matching)</option>
                            <option value="gap_fill" <?php echo (isset($question) && $question['type'] == 'gap_fill') ? 'selected' : ''; ?>>Boşluk Doldurma (Gap-fill)</option>
                            <option value="listening" <?php echo (isset($question) && $question['type'] == 'listening') ? 'selected' : ''; ?>>Dinleme (Listening)</option>
                            <option value="writing" <?php echo (isset($question) && $question['type'] == 'writing') ? 'selected' : ''; ?>>Yazma (Writing/Open-ended)</option>
                            <option value="dialogue" <?php echo (isset($question) && $question['type'] == 'dialogue') ? 'selected' : ''; ?>>Diyalog (Dialogue)</option>
                        </select>
                    </div>

                    <div class="col-md-6" id="audioField" style="display: none;">
                        <label class="form-label fw-bold">Ses Dosyası (Audio URL)</label>
                        <input type="text" class="form-control" name="audio_url" value="<?php echo isset($question) ? htmlspecialchars($question['audio_url']) : ''; ?>" placeholder="https://example.com/audio.mp3">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold" id="questionLabel">Soru veya Talimat Metni</label>
                        <textarea class="form-control" name="question_text" rows="2" required><?php echo isset($question) ? htmlspecialchars($question['question_text']) : ''; ?></textarea>
                    </div>

                    <div class="col-12" id="extraDataField" style="display: none;">
                        <label class="form-label fw-bold">Ek Veri / Ana Metin (Boşluk doldurma veya Diyalog için)</label>
                        <textarea class="form-control" name="extra_data" rows="4" placeholder="Örn: I [ ] to school every day."><?php echo isset($question) ? htmlspecialchars($question['extra_data']) : ''; ?></textarea>
                        <small class="text-muted">Boşluk doldurma için [ ] kullanın. Seçeneklerle sırasıyla eşleşecektir.</small>
                    </div>

                    <div class="col-12" id="optionsSection">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Seçenekler / Cevaplar / Eşler</h5>
                            <button type="button" class="btn btn-sm btn-outline-indigo" onclick="addOption()">
                                <i class="fas fa-plus me-1"></i> Yeni Ekle
                            </button>
                        </div>
                        
                        <div id="optionsContainer">
                            <?php if (isset($question)): ?>
                                <?php foreach ($question['options'] as $index => $option): ?>
                                    <div class="option-row mb-3 d-flex align-items-center bg-slate-800 p-3 rounded-3 border border-slate-700">
                                        <div class="form-check me-3 mc-only">
                                            <input class="form-check-input" type="radio" name="correct_option" value="<?php echo $index; ?>" <?php echo $option['is_correct'] ? 'checked' : ''; ?>>
                                        </div>
                                        <div class="flex-grow-1 me-2">
                                            <input type="text" class="form-control mb-2" name="options[]" value="<?php echo htmlspecialchars($option['option_text']); ?>" placeholder="Cevap/Seçenek metni" required>
                                            <input type="text" class="form-control form-control-sm matching-only" name="match_keys[]" value="<?php echo htmlspecialchars($option['match_key']); ?>" placeholder="Eşleşen Anahtar (Matching Key)" style="display: none;">
                                        </div>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="this.parentElement.remove()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="option-row mb-3 d-flex align-items-center bg-slate-800 p-3 rounded-3 border border-slate-700">
                                    <div class="form-check me-3 mc-only">
                                        <input class="form-check-input" type="radio" name="correct_option" value="0" checked>
                                    </div>
                                    <div class="flex-grow-1 me-2">
                                        <input type="text" class="form-control mb-2" name="options[]" placeholder="Cevap/Seçenek metni" required>
                                        <input type="text" class="form-control form-control-sm matching-only" name="match_keys[]" placeholder="Eşleşen Anahtar (Matching Key)" style="display: none;">
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 mt-5">
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-800 py-3 shadow-indigo">
                            <?php echo isset($question) ? 'Değişiklikleri Güncelle' : 'Alıştırmayı Kaydet'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleTypeFields() {
    const type = document.getElementById('typeSelect').value;
    const audioField = document.getElementById('audioField');
    const extraDataField = document.getElementById('extraDataField');
    const questionLabel = document.getElementById('questionLabel');
    const mcOnly = document.querySelectorAll('.mc-only');
    const matchingOnly = document.querySelectorAll('.matching-only');

    // Default visibility
    audioField.style.display = (type === 'listening') ? 'block' : 'none';
    extraDataField.style.display = (type === 'gap_fill' || type === 'dialogue' || type === 'writing') ? 'block' : 'none';
    
    questionLabel.innerText = (type === 'gap_fill' || type === 'writing') ? 'Talimat Metni' : 'Soru Metni';

    mcOnly.forEach(el => el.style.display = (type === 'multiple_choice' || type === 'listening') ? 'block' : 'none');
    matchingOnly.forEach(el => el.style.display = (type === 'matching') ? 'block' : 'none');
}

function addOption() {
    const container = document.getElementById('optionsContainer');
    const index = container.children.length;
    const type = document.getElementById('typeSelect').value;
    const row = document.createElement('div');
    row.className = 'option-row mb-3 d-flex align-items-center bg-slate-800 p-3 rounded-3 border border-slate-700 animate-fade-in';
    
    const isMc = (type === 'multiple_choice' || type === 'listening');
    const isMatching = (type === 'matching');

    row.innerHTML = `
        <div class="form-check me-3 mc-only" style="display: ${isMc ? 'block' : 'none'}">
            <input class="form-check-input" type="radio" name="correct_option" value="${index}">
        </div>
        <div class="flex-grow-1 me-2">
            <input type="text" class="form-control mb-2" name="options[]" placeholder="Cevap/Seçenek metni" required>
            <input type="text" class="form-control form-control-sm matching-only" name="match_keys[]" placeholder="Eşleşen Anahtar (Matching Key)" style="display: ${isMatching ? 'block' : 'none'}">
        </div>
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

// Initial call
document.addEventListener('DOMContentLoaded', toggleTypeFields);
</script>
