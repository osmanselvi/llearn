-- Migration V3: MEB Curriculum Metadata
-- Tarih: 2026-02-16

ALTER TABLE levels MODIFY COLUMN name VARCHAR(50);

ALTER TABLE lessons 
ADD COLUMN skill_area VARCHAR(255) DEFAULT NULL COMMENT 'Alan Becerileri',
ADD COLUMN conceptual_skill VARCHAR(255) DEFAULT NULL COMMENT 'Kavramsal Beceriler',
ADD COLUMN disposition VARCHAR(255) DEFAULT NULL COMMENT 'Eğilimler';
