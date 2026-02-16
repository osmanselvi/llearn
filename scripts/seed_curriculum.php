<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Database;

class SeedCurriculum extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function run() {
        try {
            echo "Starting Seed Process...\n";

            // 1. Clear existing data
            $this->db->exec("SET FOREIGN_KEY_CHECKS = 0");
            $this->db->exec("TRUNCATE TABLE user_quiz_attempts");
            $this->db->exec("TRUNCATE TABLE quiz_options");
            $this->db->exec("TRUNCATE TABLE quiz_questions");
            $this->db->exec("TRUNCATE TABLE user_progress");
            $this->db->exec("TRUNCATE TABLE lessons");
            $this->db->exec("TRUNCATE TABLE weeks");
            $this->db->exec("TRUNCATE TABLE levels");
            $this->db->exec("SET FOREIGN_KEY_CHECKS = 1");

            // 2. Insert Levels
            $levels = [
                ['id' => 1, 'name' => 'A1', 'description' => 'Beginner - Temel İngilizce altyapısı.'],
                ['id' => 2, 'name' => 'A2', 'description' => 'Elementary - Günlük konuşma ve temel gramer.'],
                ['id' => 3, 'name' => 'B1', 'description' => 'Intermediate - Kendini ifade etme ve orta seviye gramer.'],
                ['id' => 4, 'name' => 'B2', 'description' => 'Upper Intermediate - Profesyonel ve akademik yetkinlik.'],
                ['id' => 5, 'name' => 'C1', 'description' => 'Advanced - Akıcı ve ileri düzey içerikler.']
            ];

            foreach ($levels as $level) {
                $stmt = $this->db->prepare("INSERT INTO levels (id, name, description) VALUES (:id, :name, :description)");
                $stmt->execute($level);
                echo "Added Level: {$level['name']}\n";
            }

            // 3. Define Curriculum
            $curriculumData = [
                1 => [ // A1
                    ['title' => 'Başlangıç Temelleri', 'lessons' => [
                        ['title' => 'Greetings & Alphabet', 'type' => 'video', 'video_url' => 'https://www.youtube.com/embed/S2p-5W_P00M', 'content' => 'Alfabe ve temel selamlama kalıpları.'],
                        ['title' => 'Personal Pronouns', 'type' => 'text', 'content' => 'I, You, He, She, It, We, They zamirlerinin kullanımı.'],
                        ['title' => 'A1 Intro Quiz', 'type' => 'quiz']
                    ]],
                    ['title' => 'Aile ve Çevre', 'lessons' => [
                        ['title' => 'Family Members', 'type' => 'image', 'image_url' => 'https://images.unsplash.com/photo-1511895426328-dc8714191300?q=80&w=2070', 'content' => 'Aile bireylerini tanıtan kelime listesi.'],
                        ['title' => 'Possessive Adjectives', 'type' => 'text', 'content' => 'My, your, his, her... iyelik sıfatları.']
                    ]]
                ],
                2 => [ // A2
                    ['title' => 'Günlük Yaşam', 'lessons' => [
                        ['title' => 'Daily Routines', 'type' => 'podcast', 'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', 'content' => 'Günlük rutinler üzerine kısa bir dinleme dersi.'],
                        ['title' => 'Present Simple', 'type' => 'text', 'content' => 'Geniş zaman kuralları ve örnekler.']
                    ]],
                    ['title' => 'Geçmiş Zaman', 'lessons' => [
                        ['title' => 'Past Simple Tense', 'type' => 'video', 'video_url' => 'https://www.youtube.com/embed/0AnZp6pU9y0', 'content' => 'Geçmiş zamanda düzenli ve düzensiz fiiller.'],
                        ['title' => 'Past Memories Quiz', 'type' => 'quiz']
                    ]]
                ],
                3 => [ // B1
                    ['title' => 'Sağlık ve Spor', 'lessons' => [
                        ['title' => 'Healthy Habits', 'type' => 'infographic', 'image_url' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=2070', 'content' => 'Sağlıklı yaşam üzerine infografik çalışması.'],
                        ['title' => 'Giving Advice (Should)', 'type' => 'text', 'content' => 'Should ve Shouldn\'t kullanımı.']
                    ]],
                    ['title' => 'Gelecek Planları', 'lessons' => [
                        ['title' => 'Future with Will', 'type' => 'video', 'video_url' => 'https://www.youtube.com/embed/Lnd0Wz7sP9Q', 'content' => 'Gelecek zaman ve tahminler.'],
                        ['title' => 'B1 Progress Quiz', 'type' => 'quiz']
                    ]]
                ],
                4 => [ // B2
                    ['title' => 'İş Dünyası', 'lessons' => [
                        ['title' => 'Job Interviews', 'type' => 'podcast', 'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3', 'content' => 'Mülakatlarda kullanılan profesyonel kalıplar.'],
                        ['title' => 'Business English Vocab', 'type' => 'text', 'content' => 'Toplantı ve raporlama terimleri.']
                    ]],
                    ['title' => 'Sosyal Medya', 'lessons' => [
                        ['title' => 'Impact of AI', 'type' => 'video', 'video_url' => 'https://www.youtube.com/embed/5dZ_lvDgevk', 'content' => 'Yapay zeka ve teknoloji üzerine ileri düzey okuma.'],
                        ['title' => 'B2 Advanced Quiz', 'type' => 'quiz']
                    ]]
                ],
                5 => [ // C1
                    ['title' => 'Akademik İngilizce', 'lessons' => [
                        ['title' => 'Writing an Essay', 'type' => 'text', 'content' => 'Akademik makale yazım kuralları ve yapısı.'],
                        ['title' => 'Academic Podcast', 'type' => 'podcast', 'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3', 'content' => 'Bilimsel bir konu üzerine tartışma.']
                    ]],
                    ['title' => 'Kültür ve Sanat', 'lessons' => [
                        ['title' => 'English Idioms', 'type' => 'text', 'content' => 'Deyimler ve atasözleri ile derinlemesine İngilizce.'],
                        ['title' => 'C1 Proficiency Quiz', 'type' => 'quiz']
                    ]]
                ]
            ];

            // 4. Populate Weeks & Lessons
            foreach ($curriculumData as $levelId => $weeks) {
                foreach ($weeks as $index => $weekData) {
                    // Add Week
                    $stmt = $this->db->prepare("INSERT INTO weeks (level_id, week_number, title) VALUES (:level_id, :week_number, :title)");
                    $stmt->execute([
                        'level_id' => $levelId,
                        'week_number' => $index + 1,
                        'title' => $weekData['title']
                    ]);
                    $weekId = $this->db->lastInsertId();

                    // Add Lessons
                    foreach ($weekData['lessons'] as $lesson) {
                        echo "Inserting Lesson: {$lesson['title']} (Type: {$lesson['type']})\n";
                        $stmt = $this->db->prepare("INSERT INTO lessons (week_id, title, type, video_url, audio_url, image_url, content_text) VALUES (:week_id, :title, :type, :video_url, :audio_url, :image_url, :content_text)");
                        $stmt->execute([
                            'week_id' => $weekId,
                            'title' => $lesson['title'],
                            'type' => $lesson['type'],
                            'video_url' => $lesson['video_url'] ?? null,
                            'audio_url' => $lesson['audio_url'] ?? null,
                            'image_url' => $lesson['image_url'] ?? null,
                            'content_text' => $lesson['content'] ?? ''
                        ]);
                        $lessonId = $this->db->lastInsertId();

                        // If lesson is quiz, add sample questions
                        if ($lesson['type'] === 'quiz') {
                            $this->seedQuiz($lessonId);
                        }
                    }
                }
            }

            echo "All levels, weeks, and lessons seeded successfully!\n";

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }

    private function seedQuiz($lessonId) {
        $questions = [
            [
                'text' => 'Bu dersin ana konusu nedir?',
                'options' => [
                    ['text' => 'Gramer Kuralları', 'is_correct' => 1],
                    ['text' => 'Yeni Kelimeler', 'is_correct' => 0],
                    ['text' => 'Konuşma Pratiği', 'is_correct' => 0]
                ]
            ],
            [
                'text' => 'Hangisi bir selamlama kalıbıdır?',
                'options' => [
                    ['text' => 'Goodbye', 'is_correct' => 0],
                    ['text' => 'Hello', 'is_correct' => 1],
                    ['text' => 'Please', 'is_correct' => 0]
                ]
            ]
        ];

        foreach ($questions as $q) {
            $stmt = $this->db->prepare("INSERT INTO quiz_questions (lesson_id, question_text) VALUES (:lesson_id, :text)");
            $stmt->execute(['lesson_id' => $lessonId, 'text' => $q['text']]);
            $questionId = $this->db->lastInsertId();

            foreach ($q['options'] as $opt) {
                $stmt = $this->db->prepare("INSERT INTO quiz_options (question_id, option_text, is_correct) VALUES (:question_id, :text, :is_correct)");
                $stmt->execute([
                    'question_id' => $questionId,
                    'text' => $opt['text'],
                    'is_correct' => $opt['is_correct']
                ]);
            }
        }
    }
}

$seeder = new SeedCurriculum();
$seeder->run();
