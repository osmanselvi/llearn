<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Database;
use App\Models\Lesson;

class MEBCurriculumSeeder extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function seed() {
        echo "Starting MEB Curriculum Seed Process...\n";

        // Clear existing MEB data to avoid duplicates if re-running
        // $this->db->exec("DELETE FROM levels WHERE name LIKE 'MEB%'");

        $curriculum = [
            [
                'name' => 'MEB 9. Sınıf',
                'description' => 'Maarif Modeli 9. Sınıf İngilizce Müfredatı (CEFR B1.1)',
                'weeks' => [
                    ['number' => 1, 'title' => 'Unit 1: School Life', 'lessons' => [
                        ['title' => 'Meeting People', 'type' => 'video', 'skill_area' => 'Speaking', 'conceptual_skill' => 'Yorumlama', 'disposition' => 'Öz Güven', 'content_text' => 'Introduction and greeting in school context.']
                    ]],
                    ['number' => 2, 'title' => 'Unit 2: Classroom Life', 'lessons' => [['title' => 'Classroom Vocabulary', 'type' => 'vocabulary']]],
                    ['number' => 3, 'title' => 'Unit 3: Personal Life', 'lessons' => [['title' => 'Appearance & Personality', 'type' => 'grammar']]],
                    ['number' => 4, 'title' => 'Unit 4: Family Life', 'lessons' => [['title' => 'Family Members', 'type' => 'vocabulary']]],
                    ['number' => 5, 'title' => 'Unit 5: House & Neighbourhood', 'lessons' => [['title' => 'My House', 'type' => 'reading']]],
                    ['number' => 6, 'title' => 'Unit 6: City & Country', 'lessons' => [['title' => 'Urban vs Rural', 'type' => 'video']]],
                    ['number' => 7, 'title' => 'Unit 7: World & Nature', 'lessons' => [['title' => 'Environment', 'type' => 'vocabulary']]],
                    ['number' => 8, 'title' => 'Unit 8: Universe & Future', 'lessons' => [['title' => 'Space Quiz', 'type' => 'quiz', 'questions' => [['text' => 'Which planet is the closest to the sun?', 'options' => [['text' => 'Earth', 'correct' => 0], ['text' => 'Mercury', 'correct' => 1]]]]]]]
                ]
            ],
            [
                'name' => 'MEB 10. Sınıf',
                'description' => 'Maarif Modeli 10. Sınıf İngilizce Müfredatı (CEFR B1.2)',
                'weeks' => [
                    ['number' => 1, 'title' => 'Unit 1: School Life', 'lessons' => [['title' => 'Daily Routines', 'type' => 'grammar']]],
                    ['number' => 2, 'title' => 'Unit 2: Plans', 'lessons' => [['title' => 'Making Plans', 'type' => 'video']]],
                    ['number' => 3, 'title' => 'Unit 3: Legendary Figures', 'lessons' => [['title' => 'History Makers', 'type' => 'reading']]],
                    ['number' => 4, 'title' => 'Unit 4: Traditions', 'lessons' => [['title' => 'Cultural Heritage', 'type' => 'vocabulary']]],
                    ['number' => 5, 'title' => 'Unit 5: Travel', 'lessons' => [['title' => 'Booking a Trip', 'type' => 'reading']]],
                    ['number' => 6, 'title' => 'Unit 6: Helpful Tips', 'lessons' => [['title' => 'Health and Wellness', 'type' => 'video']]],
                    ['number' => 7, 'title' => 'Unit 7: Food and Festivals', 'lessons' => [['title' => 'Cultures through Food', 'type' => 'vocabulary']]],
                    ['number' => 8, 'title' => 'Unit 8: Digital Era', 'lessons' => [['title' => 'Social Media Impact', 'type' => 'text']]],
                    ['number' => 9, 'title' => 'Unit 9: Modern Heroes', 'lessons' => [['title' => 'Community Leaders', 'type' => 'video']]],
                    ['number' => 10, 'title' => 'Unit 10: Shopping', 'lessons' => [['title' => 'Shopping Quiz', 'type' => 'quiz', 'questions' => [['text' => 'Where can you buy bread?', 'options' => [['text' => 'Bakery', 'correct' => 1], ['text' => 'Pharmacy', 'correct' => 0]]]]]]]
                ]
            ],
            [
                'name' => 'MEB 11. Sınıf',
                'description' => 'Maarif Modeli 11. Sınıf İngilizce Müfredatı (CEFR B1.3)',
                'weeks' => [
                    ['number' => 1, 'title' => 'Unit 1: Future Jobs', 'lessons' => [
                        ['title' => 'Future Occupations & AI', 'type' => 'video', 'skill_area' => 'Listening & Speaking', 'conceptual_skill' => 'Çözümleme, Yorumlama', 'disposition' => 'Merak, Öz güven', 'video_url' => 'https://www.youtube.com/embed/f39cRRE2qig', 'content_text' => '<h3>AI and Future Careers</h3>', 'order_number' => 1],
                        ['title' => 'Grammar: Will vs Going to', 'type' => 'grammar', 'order_number' => 2],
                        ['title' => 'Future Jobs Quiz', 'type' => 'quiz', 'questions' => [['text' => 'Which is used for a future prediction based on present evidence?', 'options' => [['text' => 'Will', 'correct' => 0], ['text' => 'Going to', 'correct' => 1]]]]]
                    ]],
                    ['number' => 2, 'title' => 'Unit 2: Hobbies and Skills', 'lessons' => [['title' => 'Modal Verbs: Ability', 'type' => 'grammar']]],
                    ['number' => 3, 'title' => 'Unit 3: Hard Times', 'lessons' => [['title' => 'Overcoming Challenges', 'type' => 'reading']]],
                    ['number' => 4, 'title' => 'Unit 4: What a Life', 'lessons' => [['title' => 'Lifestyles', 'type' => 'vocabulary']]],
                    ['number' => 5, 'title' => 'Unit 5: Back to the Past', 'lessons' => [['title' => 'History and Memory', 'type' => 'video']]],
                    ['number' => 6, 'title' => 'Unit 6: Open Your Heart', 'lessons' => [['title' => 'Empathy', 'type' => 'text']]],
                    ['number' => 7, 'title' => 'Unit 7: Facts About Türkiye', 'lessons' => [['title' => 'Geography', 'type' => 'video']]],
                    ['number' => 8, 'title' => 'Unit 8: Sports', 'lessons' => [['title' => 'Athleticism', 'type' => 'vocabulary']]],
                    ['number' => 9, 'title' => 'Unit 9: My Friends', 'lessons' => [['title' => 'Social Circles', 'type' => 'video']]],
                    ['number' => 10, 'title' => 'Unit 10: Values and Norms', 'lessons' => [['title' => 'Ethics Quiz', 'type' => 'quiz', 'questions' => [['text' => 'Correct behavior is often called:', 'options' => [['text' => 'Ethics', 'correct' => 1], ['text' => 'Math', 'correct' => 0]]]]]]]
                ]
            ],
            [
                'name' => 'MEB 12. Sınıf',
                'description' => 'Maarif Modeli 12. Sınıf İngilizce Müfredatı (CEFR B2.4)',
                'weeks' => [
                    ['number' => 1, 'title' => 'Unit 1: Music', 'lessons' => [['title' => 'Rhythms of the World', 'type' => 'podcast']]],
                    ['number' => 2, 'title' => 'Unit 2: Friendship', 'lessons' => [['title' => 'Lifelong Bonds', 'type' => 'video']]],
                    ['number' => 3, 'title' => 'Unit 3: Human Rights', 'lessons' => [['title' => 'Global Equality', 'type' => 'text']]],
                    ['number' => 4, 'title' => 'Unit 4: Psychology', 'lessons' => [['title' => 'The Mind', 'type' => 'reading']]],
                    ['number' => 5, 'title' => 'Unit 5: Favors', 'lessons' => [['title' => 'Helping Others', 'type' => 'video']]],
                    ['number' => 6, 'title' => 'Unit 6: News Stories', 'lessons' => [['title' => 'Media Literacy', 'type' => 'vocabulary']]],
                    ['number' => 7, 'title' => 'Unit 7: Alternative Energy', 'lessons' => [['title' => 'Green Future', 'type' => 'infographic']]],
                    ['number' => 8, 'title' => 'Unit 8: Technology', 'lessons' => [['title' => 'Innovation', 'type' => 'video']]],
                    ['number' => 9, 'title' => 'Unit 9: Manners', 'lessons' => [['title' => 'Etiquette Quiz', 'type' => 'quiz', 'questions' => [['text' => 'You should say "Please" to be:', 'options' => [['text' => 'Rude', 'correct' => 0], ['text' => 'Polite', 'correct' => 1]]]]]]]
                ]
            ]
        ];

        try {
            foreach ($curriculum as $levelData) {
                // Add Level
                $stmt = $this->db->prepare("SELECT id FROM levels WHERE name = :name");
                $stmt->execute(['name' => $levelData['name']]);
                $levelId = $stmt->fetchColumn();

                if (!$levelId) {
                    $stmt = $this->db->prepare("INSERT INTO levels (name, description) VALUES (:name, :description)");
                    $stmt->execute(['name' => $levelData['name'], 'description' => $levelData['description']]);
                    $levelId = $this->db->lastInsertId();
                }

                echo "Processing Level: {$levelData['name']}\n";

                foreach ($levelData['weeks'] as $weekData) {
                    // Add/Get Week
                    $stmt = $this->db->prepare("SELECT id FROM weeks WHERE level_id = :level_id AND week_number = :number");
                    $stmt->execute(['level_id' => $levelId, 'number' => $weekData['number']]);
                    $weekId = $stmt->fetchColumn();

                    if (!$weekId) {
                        $stmt = $this->db->prepare("INSERT INTO weeks (level_id, week_number, title) VALUES (:level_id, :number, :title)");
                        $stmt->execute(['level_id' => $levelId, 'number' => $weekData['number'], 'title' => $weekData['title']]);
                        $weekId = $this->db->lastInsertId();
                    }

                    if (isset($weekData['lessons'])) {
                        foreach ($weekData['lessons'] as $lesson) {
                            // Check if lesson already exists to avoid duplicates
                            $stmt = $this->db->prepare("SELECT id FROM lessons WHERE week_id = :week_id AND title = :title");
                            $stmt->execute(['week_id' => $weekId, 'title' => $lesson['title']]);
                            if ($stmt->fetch()) continue;

                            $stmt = $this->db->prepare("INSERT INTO lessons (week_id, title, type, skill_area, conceptual_skill, disposition, content_text, video_url, order_number) VALUES (:week_id, :title, :type, :skill_area, :conceptual_skill, :disposition, :content_text, :video_url, :order_number)");
                            $stmt->execute([
                                'week_id' => $weekId,
                                'title' => $lesson['title'],
                                'type' => $lesson['type'],
                                'skill_area' => $lesson['skill_area'] ?? null,
                                'conceptual_skill' => $lesson['conceptual_skill'] ?? null,
                                'disposition' => $lesson['disposition'] ?? null,
                                'content_text' => $lesson['content_text'] ?? null,
                                'video_url' => $lesson['video_url'] ?? null,
                                'order_number' => $lesson['order_number'] ?? 0
                            ]);
                            
                            $lessonId = $this->db->lastInsertId();

                            if (isset($lesson['questions'])) {
                                foreach ($lesson['questions'] as $qData) {
                                    $stmt = $this->db->prepare("INSERT INTO quiz_questions (lesson_id, question_text) VALUES (:lesson_id, :text)");
                                    $stmt->execute(['lesson_id' => $lessonId, 'text' => $qData['text']]);
                                    $qId = $this->db->lastInsertId();

                                    foreach ($qData['options'] as $oData) {
                                        $stmt = $this->db->prepare("INSERT INTO quiz_options (question_id, option_text, is_correct) VALUES (:q_id, :text, :correct)");
                                        $stmt->execute(['q_id' => $qId, 'text' => $oData['text'], 'correct' => $oData['correct']]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            echo "MEB Curriculum expansion successful!\n";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
        }
    }
}

$seeder = new MEBCurriculumSeeder();
$seeder->seed();
