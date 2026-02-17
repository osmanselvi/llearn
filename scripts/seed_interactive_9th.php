<?php
// scripts/seed_interactive_9th.php
require_once __DIR__ . '/../app/Models/Database.php';
require_once __DIR__ . '/../app/Models/Lesson.php';

use App\Models\Lesson;

class InteractiveSeeder {
    private $lessonModel;

    public function __construct() {
        $this->lessonModel = new Lesson();
    }

    public function seed() {
        echo "Seeding Interactive 9th Grade Theme 1 Content...\n";

        // Find Theme 1 (School Life) for MEB 9. Sınıf
        $levelId = null;
        $levels = $this->lessonModel->getLevels();
        foreach ($levels as $l) {
            if ($l['name'] === 'MEB 9. Sınıf') {
                $levelId = $l['id'];
                break;
            }
        }

        if (!$levelId) {
            die("Error: MEB 9. Sınıf level not found.\n");
        }

        $weeks = $this->lessonModel->getWeeksByLevel($levelId);
        $theme1Id = null;
        foreach ($weeks as $w) {
            if (strpos($w['title'], 'School Life') !== false || $w['week_number'] == 1) {
                $theme1Id = $w['id'];
                break;
            }
        }

        if (!$theme1Id) {
            die("Error: Theme 1 not found.\n");
        }

        // Create a new Interactive Lesson
        $lessonData = [
            'week_id' => $theme1Id,
            'title' => 'Interactive Workshop: School Life',
            'type' => 'quiz',
            'content_text' => 'This session focuses on interactive skills: listening comprehension, vocabulary matching, and self-introduction.',
            'video_url' => null,
            'audio_url' => null,
            'image_url' => null,
            'order_number' => 10, // Top of the list
            'skill_area' => 'Listening & Writing',
            'conceptual_skill' => 'Self-Regulation',
            'disposition' => 'Openness to Learning'
        ];

        if ($this->lessonModel->create($lessonData)) {
            $lessonId = $this->lessonModel->getConnection()->lastInsertId();
            echo "Lesson created with ID: $lessonId\n";
        } else {
            die("Error: Failed to create interactive lesson.\n");
        }

        // 1. Listening Question
        $q1 = $this->lessonModel->createQuestion([
            'lesson_id' => $lessonId,
            'type' => 'listening',
            'question_text' => 'Listen to the dialogue and choose the correct option: Why is Kerem excited?',
            'audio_url' => 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3', // Placeholder
            'extra_data' => 'Dialogue about the first day of school.'
        ]);
        $this->lessonModel->addOption($q1, 'He has new friends.', true);
        $this->lessonModel->addOption($q1, 'He hates school.', false);
        $this->lessonModel->addOption($q1, 'He is going on a holiday.', false);

        // 2. Matching Question
        $q2 = $this->lessonModel->createQuestion([
            'lesson_id' => $lessonId,
            'type' => 'matching',
            'question_text' => 'Match the school subjects with their descriptions.',
            'audio_url' => null,
            'extra_data' => null
        ]);
        $this->lessonModel->addOption($q2, 'Biology', false, 'The study of living organisms.');
        $this->lessonModel->addOption($q2, 'Literature', false, 'The study of written works.');
        $this->lessonModel->addOption($q2, 'Geometry', false, 'The study of shapes and sizes.');

        // 3. Gap Fill Question
        $q3 = $this->lessonModel->createQuestion([
            'lesson_id' => $lessonId,
            'type' => 'gap_fill',
            'question_text' => 'Complete the text with appropriate words.',
            'audio_url' => null,
            'extra_data' => 'Hi! My name [ ] Dr. Proton. I [ ] at the MEW University. I [ ] cat snacks very much!'
        ]);
        $this->lessonModel->addOption($q3, 'is', false);
        $this->lessonModel->addOption($q3, 'study', false);
        $this->lessonModel->addOption($q3, 'like', false);

        // 4. Writing Question
        $q4 = $this->lessonModel->createQuestion([
            'lesson_id' => $lessonId,
            'type' => 'writing',
            'question_text' => 'Describe your typical school day in at least 3 sentences.',
            'audio_url' => null,
            'extra_data' => 'Write about your morning routine, favorite classes, and after-school activities.'
        ]);

        echo "Interactive seeding completed successfully!\n";
    }
}

$seeder = new InteractiveSeeder();
$seeder->seed();
