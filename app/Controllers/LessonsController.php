<?php

namespace App\Controllers;

use App\Models\Lesson;

class LessonsController extends Controller {
    private $lessonModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit;
        }
        $this->lessonModel = new Lesson();
    }

    public function week($weekId) {
        $lessons = $this->lessonModel->getByWeek($weekId);
        $data = [
            'title' => 'Ders Listesi - LLEARN',
            'lessons' => $lessons
        ];
        $this->render('lessons/index', $data);
    }

    public function view($id) {
        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            die("Ders bulunamadı.");
        }

        $data = [
            'title' => $lesson['title'] . ' - LLEARN',
            'lesson' => $lesson
        ];

        if ($lesson['type'] === 'quiz') {
            $data['questions'] = $this->lessonModel->getQuizQuestions($id);
        }

        $this->render('lessons/view', $data);
    }

    public function submitQuiz($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questions = $this->lessonModel->getQuizQuestions($id);
            $totalPossiblePoints = 0;
            $earnedPoints = 0;

            foreach ($questions as $question) {
                $totalPossiblePoints += 10; // Each question is worth 10 base points
                
                if ($question['type'] === 'matching') {
                    $submittedMatches = $_POST['question_' . $question['id'] . '_match'] ?? [];
                    $correctMatches = 0;
                    $totalPairs = count($question['options']);
                    
                    foreach ($question['options'] as $option) {
                        if (isset($submittedMatches[$option['id']]) && $submittedMatches[$option['id']] == $option['id']) {
                            $correctMatches++;
                        }
                    }
                    if ($totalPairs > 0) {
                        $earnedPoints += ($correctMatches / $totalPairs) * 10;
                    }
                } elseif ($question['type'] === 'gap_fill') {
                    $submittedGaps = $_POST['question_' . $question['id']] ?? [];
                    $correctGaps = 0;
                    $totalGaps = count($question['options']);

                    foreach ($question['options'] as $idx => $option) {
                        if (isset($submittedGaps[$idx]) && strtolower(trim($submittedGaps[$idx])) == strtolower(trim($option['option_text']))) {
                            $correctGaps++;
                        }
                    }
                    if ($totalGaps > 0) {
                        $earnedPoints += ($correctGaps / $totalGaps) * 10;
                    }
                } elseif ($question['type'] === 'writing') {
                    // Writing is subjective, for now we give points if it's not empty
                    $submittedText = $_POST['question_' . $question['id']] ?? '';
                    if (strlen(trim($submittedText)) > 5) {
                        $earnedPoints += 10;
                    }
                } else {
                    // MC, Listening, Dialogue
                    $submittedAnswer = $_POST['question_' . $question['id']] ?? null;
                    foreach ($question['options'] as $option) {
                        if ($option['is_correct'] && $option['id'] == $submittedAnswer) {
                            $earnedPoints += 10;
                        }
                    }
                }
            }

            $maxPoints = count($questions) * 10;
            $score = ($maxPoints > 0) ? ($earnedPoints / $maxPoints) * 100 : 0;
            
            $this->lessonModel->submitQuizAttempt($_SESSION['user_id'], $id, $score);
            
            if ($score >= 50) {
                $this->lessonModel->markCompleted($_SESSION['user_id'], $id);
            }

            header('Location: /lessons/view/' . $id . '?score=' . $score);
            exit;
        }
    }

    public function complete($id) {
        $userId = $_SESSION['user_id'];
        if ($this->lessonModel->markCompleted($userId, $id)) {
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?completed=1');
        } else {
            die("İşlem sırasında hata oluştu.");
        }
    }
}
