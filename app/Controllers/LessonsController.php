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
            $totalQuestions = count($questions);
            $correctAnswers = 0;

            foreach ($questions as $question) {
                $submittedAnswer = $_POST['question_' . $question['id']] ?? null;
                foreach ($question['options'] as $option) {
                    if ($option['is_correct'] && $option['id'] == $submittedAnswer) {
                        $correctAnswers++;
                    }
                }
            }

            $score = ($totalQuestions > 0) ? ($correctAnswers / $totalQuestions) * 100 : 0;
            $this->lessonModel->submitQuizAttempt($_SESSION['user_id'], $id, $score);
            
            // Also mark as completed if score is high enough (e.g., > 50)
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
