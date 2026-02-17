<?php

namespace App\Models;

use PDO;

class Lesson extends Database {
    private $db;

    public function __construct() {
        parent::__construct();
        $this->db = $this->getConnection();
    }

    public function getByWeek($weekId) {
        $stmt = $this->db->prepare("SELECT * FROM lessons WHERE week_id = :week_id ORDER BY order_number ASC");
        $stmt->execute(['week_id' => $weekId]);
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT l.*, w.title as week_title, w.level_id FROM lessons l JOIN weeks w ON l.week_id = w.id WHERE l.id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT l.*, w.title as week_title, lv.name as level_name 
                                    FROM lessons l 
                                    JOIN weeks w ON l.week_id = w.id 
                                    JOIN levels lv ON w.level_id = lv.id 
                                    ORDER BY lv.id, w.week_number, l.order_number");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create($data) {
        $sql = "INSERT INTO lessons (week_id, title, type, content_text, video_url, audio_url, image_url, order_number, skill_area, conceptual_skill, disposition) 
                VALUES (:week_id, :title, :type, :content_text, :video_url, :audio_url, :image_url, :order_number, :skill_area, :conceptual_skill, :disposition)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function update($id, $data) {
        $data['id'] = $id;
        $sql = "UPDATE lessons SET week_id = :week_id, title = :title, type = :type, 
                content_text = :content_text, video_url = :video_url, audio_url = :audio_url, 
                image_url = :image_url, order_number = :order_number,
                skill_area = :skill_area, conceptual_skill = :conceptual_skill, disposition = :disposition
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM lessons WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function getLevels() {
        $stmt = $this->db->prepare("SELECT * FROM levels ORDER BY id");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getWeeksByLevel($levelId) {
        $stmt = $this->db->prepare("SELECT * FROM weeks WHERE level_id = :level_id ORDER BY week_number");
        $stmt->execute(['level_id' => $levelId]);
        return $stmt->fetchAll();
    }

    public function getQuizQuestions($lessonId) {
        $stmt = $this->db->prepare("SELECT * FROM quiz_questions WHERE lesson_id = :lesson_id ORDER BY id ASC");
        $stmt->execute(['lesson_id' => $lessonId]);
        $questions = $stmt->fetchAll();

        foreach ($questions as &$question) {
            $stmt = $this->db->prepare("SELECT * FROM quiz_options WHERE question_id = :question_id ORDER BY id ASC");
            $stmt->execute(['question_id' => $question['id']]);
            $question['options'] = $stmt->fetchAll();
        }

        return $questions;
    }

    public function createQuestion($data) {
        $stmt = $this->db->prepare("INSERT INTO quiz_questions (lesson_id, type, question_text, audio_url, extra_data) 
                                    VALUES (:lesson_id, :type, :question_text, :audio_url, :extra_data)");
        $stmt->execute([
            'lesson_id' => $data['lesson_id'],
            'type' => $data['type'] ?? 'multiple_choice',
            'question_text' => $data['question_text'],
            'audio_url' => $data['audio_url'] ?? null,
            'extra_data' => $data['extra_data'] ?? null
        ]);
        return $this->db->lastInsertId();
    }

    public function updateQuestion($id, $data) {
        $stmt = $this->db->prepare("UPDATE quiz_questions 
                                    SET type = :type, question_text = :question_text, 
                                        audio_url = :audio_url, extra_data = :extra_data 
                                    WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'type' => $data['type'] ?? 'multiple_choice',
            'question_text' => $data['question_text'],
            'audio_url' => $data['audio_url'] ?? null,
            'extra_data' => $data['extra_data'] ?? null
        ]);
    }

    public function deleteQuestion($id) {
        $stmt = $this->db->prepare("DELETE FROM quiz_questions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function addOption($questionId, $text, $isCorrect, $matchKey = null) {
        $stmt = $this->db->prepare("INSERT INTO quiz_options (question_id, option_text, is_correct, match_key) 
                                    VALUES (:question_id, :text, :is_correct, :match_key)");
        return $stmt->execute([
            'question_id' => $questionId,
            'text' => $text,
            'is_correct' => $isCorrect ? 1 : 0,
            'match_key' => $matchKey
        ]);
    }

    public function clearOptions($questionId) {
        $stmt = $this->db->prepare("DELETE FROM quiz_options WHERE question_id = :question_id");
        return $stmt->execute(['question_id' => $questionId]);
    }

    public function getQuestion($id) {
        $stmt = $this->db->prepare("SELECT * FROM quiz_questions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $question = $stmt->fetch();
        
        if ($question) {
            $stmt = $this->db->prepare("SELECT * FROM quiz_options WHERE question_id = :question_id ORDER BY id ASC");
            $stmt->execute(['question_id' => $id]);
            $question['options'] = $stmt->fetchAll();
        }
        
        return $question;
    }

    public function getProgress($userId, $lessonId) {
        $stmt = $this->db->prepare("SELECT * FROM user_progress WHERE user_id = :user_id AND lesson_id = :lesson_id");
        $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
        return $stmt->fetch();
    }

    public function markCompleted($userId, $lessonId) {
        $sql = "INSERT INTO user_progress (user_id, lesson_id, is_completed, completed_at) 
                VALUES (:user_id, :lesson_id, 1, NOW()) 
                ON DUPLICATE KEY UPDATE is_completed = 1, completed_at = NOW()";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['user_id' => $userId, 'lesson_id' => $lessonId]);
    }
}
