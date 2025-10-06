-- init.sql for courses-platform

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('student','teacher') NOT NULL
);

-- Create courses table
CREATE TABLE IF NOT EXISTS courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    teacher_id INT NOT NULL,
    FOREIGN KEY (teacher_id) REFERENCES users(id)
);

-- Create enrollments table
CREATE TABLE IF NOT EXISTS enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users(id),
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Create materials table
CREATE TABLE IF NOT EXISTS materials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(255),
    type ENUM('video','document','link') DEFAULT 'document',
    content_url TEXT,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Create exercises table
CREATE TABLE IF NOT EXISTS exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    question TEXT,
    answer TEXT,
    points INT DEFAULT 0,
    FOREIGN KEY (course_id) REFERENCES courses(id)
);

-- Create forum table
CREATE TABLE IF NOT EXISTS forum (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    user_id INT NOT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Optional: add an initial teacher account
INSERT INTO users (name, email, password, role)
VALUES ('Admin Teacher', 'teacher@example.com', '$2y$10$6hN8F9nT2VYfKmz0XzPqeO/2zOd8Hk1kL6Z72Jo1XmTiWShhQxS3K', 'teacher');
-- Password is bcrypt hash for 'password123'
