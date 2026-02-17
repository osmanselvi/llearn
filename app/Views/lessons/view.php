<div class="row justify-content-center animate-up">
    <div class="col-lg-9">
        <div class="d-flex align-items-center mb-4">
            <a href="/lessons/week/<?php echo $lesson['week_id']; ?>" class="btn btn-light rounded-circle p-3 me-3">
                <i class="fas fa-chevron-left text-primary"></i>
            </a>
            <h1 class="fw-800 mb-0"><?php echo htmlspecialchars($lesson['title']); ?></h1>
        </div>

        <?php if ($lesson['video_url']): ?>
            <div class="ratio ratio-16x9 mb-5 shadow-lg rounded-4 overflow-hidden border-0">
                <iframe src="<?php echo htmlspecialchars($lesson['video_url']); ?>" title="Lesson Video" allowfullscreen></iframe>
            </div>
        <?php endif; ?>

        <?php if ($lesson['audio_url']): ?>
            <div class="card p-4 border-0 shadow-sm mb-5 bg-card rounded-4">
                <h5 class="fw-bold mb-4 d-flex align-items-center">
                    <div class="bg-primary-light p-2 rounded me-3" style="color: #6366F1;">
                        <i class="fas fa-headphones"></i>
                    </div>
                    Dersi Dinle
                </h5>
                <audio controls class="w-100">
                    <source src="<?php echo htmlspecialchars($lesson['audio_url']); ?>" type="audio/mpeg">
                    Tarayıcınız ses öğesini desteklemiyor.
                </audio>
            </div>
        <?php endif; ?>

        <?php if ($lesson['image_url']): ?>
            <div class="mb-5 text-center">
                <img src="<?php echo htmlspecialchars($lesson['image_url']); ?>" alt="<?php echo htmlspecialchars($lesson['title']); ?>" class="img-fluid rounded-4 shadow-sm">
            </div>
        <?php endif; ?>

        <?php if ($lesson['type'] === 'quiz' && isset($questions)): ?>
            <div class="card p-5 border-0 shadow-lg mb-5 rounded-4 bg-card">
                <div class="d-flex align-items-center mb-5">
                    <div class="bg-success-light p-3 rounded-3 me-3" style="color: #10B981;">
                        <i class="fas fa-tasks fa-xl"></i>
                    </div>
                    <h3 class="fw-800 mb-0">İnteraktif Sınav</h3>
                </div>

                <?php if (isset($_GET['score'])): ?>
                    <div class="alert alert-info py-4 border-0 rounded-4 mb-5 text-center" style="background: rgba(99, 102, 241, 0.1); color: #6366F1;">
                        <span class="text-muted d-block small mb-1">Sınav Sonucu</span>
                        <h2 class="fw-800 text-primary mb-0"><?php echo (int)$_GET['score']; ?> / 100</h2>
                    </div>
                <?php endif; ?>

                <form action="/lessons/submitQuiz/<?php echo $lesson['id']; ?>" method="POST" id="interactiveQuizForm">
                    <?php foreach ($questions as $qIndex => $question): ?>
                        <div class="mb-5 p-4 rounded-4 border border-white border-opacity-10" style="background: rgba(255,255,255,0.02);">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold mb-0"><?php echo ($qIndex + 1) . ". " . htmlspecialchars($question['question_text']); ?></h5>
                                <span class="badge bg-indigo-soft text-indigo small"><?php echo strtoupper($question['type']); ?></span>
                            </div>

                            <?php if ($question['type'] === 'listening' && $question['audio_url']): ?>
                                <div class="mb-4">
                                    <audio controls class="w-100">
                                        <source src="<?php echo htmlspecialchars($question['audio_url']); ?>" type="audio/mpeg">
                                    </audio>
                                </div>
                            <?php endif; ?>

                            <?php if ($question['type'] === 'gap_fill' && $question['extra_data']): ?>
                                <div class="mb-4 p-3 bg-slate-900 rounded-3 border border-white border-opacity-5 gap-fill-container">
                                    <?php 
                                        $parts = explode('[ ]', $question['extra_data']);
                                        foreach ($parts as $pIdx => $part) {
                                            echo htmlspecialchars($part);
                                            if ($pIdx < count($parts) - 1) {
                                                echo '<input type="text" name="question_' . $question['id'] . '[]" class="gap-fill-input me-1 ms-1" required autocomplete="off">';
                                            }
                                        }
                                    ?>
                                </div>
                            <?php elseif ($question['type'] === 'matching'): ?>
                                <div class="row g-3 matching-container" data-question-id="<?php echo $question['id']; ?>">
                                    <div class="col-6">
                                        <?php foreach ($question['options'] as $oIdx => $option): ?>
                                            <div class="p-2 mb-2 bg-slate-800 rounded border border-white border-opacity-10 text-center select-match-item" data-id="<?php echo $option['id']; ?>">
                                                <?php echo htmlspecialchars($option['option_text']); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="col-6">
                                        <?php 
                                            $shuffledOptions = $question['options']; 
                                            shuffle($shuffledOptions);
                                            foreach ($shuffledOptions as $sOption): 
                                        ?>
                                            <div class="p-2 mb-2 bg-indigo-soft text-indigo rounded border border-indigo border-opacity-25 text-center select-match-key" data-id="<?php echo $sOption['id']; ?>">
                                                <?php echo htmlspecialchars($sOption['match_key']); ?>
                                            </div>
                                            <input type="hidden" name="question_<?php echo $question['id']; ?>_match[<?php echo $sOption['id']; ?>]" id="match_input_<?php echo $sOption['id']; ?>">
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php elseif ($question['type'] === 'writing'): ?>
                                <div class="mb-4">
                                    <textarea class="form-control bg-slate-900 border-white border-opacity-10 text-white" name="question_<?php echo $question['id']; ?>" rows="4" placeholder="Cevabınızı buraya yazın..." required></textarea>
                                </div>
                            <?php elseif ($question['type'] === 'dialogue'): ?>
                                <div class="mb-4 bg-slate-900 p-3 rounded-3 border border-indigo border-opacity-10">
                                    <pre class="mb-0 text-white" style="white-space: pre-wrap; font-family: inherit;"><?php echo htmlspecialchars($question['extra_data']); ?></pre>
                                </div>
                                <div class="row g-2">
                                    <?php foreach ($question['options'] as $option): ?>
                                        <div class="col-md-6">
                                            <div class="form-check custom-radio mb-2">
                                                <input class="form-check-input" type="radio" name="question_<?php echo $question['id']; ?>" id="opt_<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" required>
                                                <label class="form-check-label fw-500 ps-2" for="opt_<?php echo $option['id']; ?>">
                                                    <?php echo htmlspecialchars($option['option_text']); ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <?php foreach ($question['options'] as $option): ?>
                                    <div class="form-check custom-radio mb-3">
                                        <input class="form-check-input" type="radio" name="question_<?php echo $question['id']; ?>" id="opt_<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" required>
                                        <label class="form-check-label fw-500 ps-2" for="opt_<?php echo $option['id']; ?>">
                                            <?php echo htmlspecialchars($option['option_text']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 rounded-pill shadow-lg shadow-indigo-soft hover-animate">Başarımı Ölç ve Gönder</button>
                    </div>
                </form>

<style>
.gap-fill-input {
    border: none;
    border-bottom: 2px solid #6366F1;
    background: transparent;
    color: #6366F1;
    font-weight: bold;
    padding: 0 5px;
    width: 80px;
    text-align: center;
    outline: none;
}
.select-match-item, .select-match-key {
    cursor: pointer;
    transition: all 0.2s;
}
.select-match-item.active {
    background: #6366F1 !important;
    color: white !important;
    border-color: #6366F1 !important;
}
.select-match-key.matched {
    background: #10B981 !important;
    color: white !important;
}
</style>

<script>
document.querySelectorAll('.matching-container').forEach(container => {
    let selectedItem = null;
    
    container.querySelectorAll('.select-match-item').forEach(item => {
        item.addEventListener('click', () => {
            container.querySelectorAll('.select-match-item').forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            selectedItem = item;
        });
    });

    container.querySelectorAll('.select-match-key').forEach(key => {
        key.addEventListener('click', () => {
            if (selectedItem) {
                const itemId = selectedItem.dataset.id;
                const keyId = key.dataset.id;
                
                // Visual feedback
                key.classList.add('matched');
                key.innerText = key.innerText.split(' 🔗 ')[0] + ' 🔗 ' + selectedItem.innerText;
                
                // Set hidden input
                document.getElementById('match_input_' + keyId).value = itemId;
                
                selectedItem.style.opacity = '0.5';
                selectedItem.style.pointerEvents = 'none';
                selectedItem = null;
            }
        });
    });
});
</script>
            </div>
        <?php endif; ?>

        <?php if ($lesson['content_text']): ?>
            <div class="card p-5 border-0 shadow-sm mb-5 rounded-4 bg-card">
                <div class="lesson-content">
                    <?php echo nl2br($lesson['content_text']); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between align-items-center mt-5 mb-5 pb-5">
            <a href="/lessons/week/<?php echo $lesson['week_id']; ?>" class="text-decoration-none text-muted fw-bold">
                <i class="fas fa-arrow-left me-2"></i> Listeye Geri Dön
            </a>
            <?php if ($lesson['type'] !== 'quiz'): ?>
                <form action="/lessons/complete/<?php echo $lesson['id']; ?>" method="POST">
                    <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm">
                        <i class="fas fa-check-circle me-2"></i>Dersi Tamamla
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card p-4 border-0 shadow-sm sticky-top rounded-4" style="top: 100px;">
            <h5 class="fw-800 mb-4">Ders Bilgileri</h5>
            <ul class="list-unstyled mb-0">
                <li class="mb-3"><i class="fas fa-calendar text-primary me-2"></i> Hafta: <?php echo $lesson['week_title']; ?></li>
                <?php if ($lesson['skill_area']): ?>
                    <li class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Alan Becerisi</small>
                        <i class="fas fa-bullseye text-indigo me-2"></i> <?php echo htmlspecialchars($lesson['skill_area']); ?>
                    </li>
                <?php endif; ?>
                <?php if ($lesson['conceptual_skill']): ?>
                    <li class="mb-3">
                        <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Kavramsal Beceri</small>
                        <i class="fas fa-brain text-success me-2"></i> <?php echo htmlspecialchars($lesson['conceptual_skill']); ?>
                    </li>
                <?php endif; ?>
                <?php if ($lesson['disposition']): ?>
                    <li class="mb-0">
                        <small class="text-muted d-block text-uppercase fw-bold mb-1" style="font-size: 0.7rem;">Eğilim</small>
                        <i class="fas fa-heart text-danger me-2"></i> <?php echo htmlspecialchars($lesson['disposition']); ?>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
