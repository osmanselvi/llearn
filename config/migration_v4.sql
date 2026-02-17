-- Migration V4: Interactive Exercises Expansion
ALTER TABLE quiz_questions 
ADD COLUMN type ENUM('multiple_choice', 'matching', 'gap_fill', 'listening', 'writing', 'dialogue') DEFAULT 'multiple_choice' AFTER lesson_id,
ADD COLUMN audio_url VARCHAR(255) NULL AFTER question_text,
ADD COLUMN extra_data TEXT NULL AFTER audio_url;

ALTER TABLE quiz_options 
ADD COLUMN match_key VARCHAR(255) NULL AFTER is_correct;
