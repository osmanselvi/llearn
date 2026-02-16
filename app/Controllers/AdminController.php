<?php

namespace App\Controllers;

use App\Models\Lesson;

class AdminController extends Controller {
    private $lessonModel;

    public function __construct() {
        $this->requireLogin();
        $this->requireAdmin();
        $this->lessonModel = new Lesson();
    }

    public function index() {
        $data['title'] = 'Admin Panel - LLEARN';
        $data['lessons'] = $this->lessonModel->getAll();
        $this->render('admin/index', $data);
    }

    public function createLesson() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'week_id' => $_POST['week_id'],
                'title' => htmlspecialchars($_POST['title']),
                'type' => $_POST['type'],
                'content_text' => $_POST['content_text'],
                'video_url' => $_POST['video_url'] ?: null,
                'audio_url' => $_POST['audio_url'] ?: null,
                'image_url' => $_POST['image_url'] ?: null,
                'order_number' => (int)$_POST['order_number'],
                'skill_area' => $_POST['skill_area'] ?: null,
                'conceptual_skill' => $_POST['conceptual_skill'] ?: null,
                'disposition' => $_POST['disposition'] ?: null
            ];

            if ($this->lessonModel->create($data)) {
                header('Location: /admin?success=created');
                exit;
            }
        }

        $data['title'] = 'Yeni Ders Ekle - LLEARN';
        $data['levels'] = $this->lessonModel->getLevels();
        $this->render('admin/lesson_form', $data);
    }

    public function editLesson($id) {
        $lesson = $this->lessonModel->find($id);
        if (!$lesson) {
            header('Location: /admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'week_id' => $_POST['week_id'],
                'title' => htmlspecialchars($_POST['title']),
                'type' => $_POST['type'],
                'content_text' => $_POST['content_text'],
                'video_url' => $_POST['video_url'] ?: null,
                'audio_url' => $_POST['audio_url'] ?: null,
                'image_url' => $_POST['image_url'] ?: null,
                'order_number' => (int)$_POST['order_number'],
                'skill_area' => $_POST['skill_area'] ?: null,
                'conceptual_skill' => $_POST['conceptual_skill'] ?: null,
                'disposition' => $_POST['disposition'] ?: null
            ];

            if ($this->lessonModel->update($id, $data)) {
                header('Location: /admin?success=updated');
                exit;
            }
        }

        $data['title'] = 'Dersi Düzenle - LLEARN';
        $data['lesson'] = $lesson;
        $data['levels'] = $this->lessonModel->getLevels();
        $this->render('admin/lesson_form', $data);
    }

    public function deleteLesson($id) {
        if ($this->lessonModel->delete($id)) {
            header('Location: /admin?success=deleted');
            exit;
        }
    }

    public function getWeeks($levelId) {
        $weeks = $this->lessonModel->getWeeksByLevel($levelId);
        echo json_encode($weeks);
        exit;
    }

    public function manageQuiz($lessonId) {
        $lesson = $this->lessonModel->find($lessonId);
        if (!$lesson || $lesson['type'] !== 'quiz') {
            header('Location: /admin');
            exit;
        }

        $data['title'] = 'Sınav Yönetimi - ' . $lesson['title'];
        $data['lesson'] = $lesson;
        $data['questions'] = $this->lessonModel->getQuizQuestions($lessonId);
        $this->render('admin/quiz/index', $data);
    }

    public function createQuestion($lessonId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $questionText = $_POST['question_text'];
            $questionId = $this->lessonModel->createQuestion([
                'lesson_id' => $lessonId,
                'question_text' => $questionText
            ]);

            if ($questionId) {
                // Add Options
                $options = $_POST['options'];
                $correctIndex = $_POST['correct_option'];
                foreach ($options as $index => $optionText) {
                    if (!empty($optionText)) {
                        $this->lessonModel->addOption($questionId, $optionText, ($index == $correctIndex));
                    }
                }
                header('Location: /admin/manageQuiz/' . $lessonId . '?success=q_created');
                exit;
            }
        }

        $data['title'] = 'Yeni Soru Ekle';
        $data['lesson_id'] = $lessonId;
        $this->render('admin/quiz/question_form', $data);
    }

    public function editQuestion($questionId) {
        $question = $this->lessonModel->getQuestion($questionId);
        if (!$question) {
            header('Location: /admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->lessonModel->updateQuestion($questionId, $_POST['question_text']);
            $this->lessonModel->clearOptions($questionId);

            $options = $_POST['options'];
            $correctIndex = $_POST['correct_option'];
            foreach ($options as $index => $optionText) {
                if (!empty($optionText)) {
                    $this->lessonModel->addOption($questionId, $optionText, ($index == $correctIndex));
                }
            }
            header('Location: /admin/manageQuiz/' . $question['lesson_id'] . '?success=q_updated');
            exit;
        }

        $data['title'] = 'Soruyu Düzenle';
        $data['question'] = $question;
        $this->render('admin/quiz/question_form', $data);
    }

    public function deleteQuestion($questionId) {
        $question = $this->lessonModel->getQuestion($questionId);
        if ($question && $this->lessonModel->deleteQuestion($questionId)) {
            header('Location: /admin/manageQuiz/' . $question['lesson_id'] . '?success=q_deleted');
            exit;
        }
        header('Location: /admin');
        exit;
    }
}
