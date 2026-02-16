ALTER TABLE lessons 
MODIFY COLUMN type ENUM('grammar', 'vocabulary', 'reading', 'podcast', 'infographic', 'quiz', 'video', 'text', 'image') DEFAULT 'grammar';
