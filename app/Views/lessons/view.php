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

                <form action="/lessons/submitQuiz/<?php echo $lesson['id']; ?>" method="POST">
                    <?php foreach ($questions as $qIndex => $question): ?>
                        <div class="mb-5 p-4 rounded-4 border border-white border-opacity-10" style="background: rgba(255,255,255,0.02);">
                            <h5 class="fw-bold mb-4"><?php echo ($qIndex + 1) . ". " . htmlspecialchars($question['question_text']); ?></h5>
                            <?php foreach ($question['options'] as $option): ?>
                                <div class="form-check custom-radio mb-3">
                                    <input class="form-check-input" type="radio" name="question_<?php echo $question['id']; ?>" id="opt_<?php echo $option['id']; ?>" value="<?php echo $option['id']; ?>" required>
                                    <label class="form-check-label fw-500 ps-2" for="opt_<?php echo $option['id']; ?>">
                                        <?php echo htmlspecialchars($option['option_text']); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                    <div class="d-grid mt-5">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold py-3 rounded-pill shadow-lg">Sınavı Tamamla ve Gönder</button>
                    </div>
                </form>
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
