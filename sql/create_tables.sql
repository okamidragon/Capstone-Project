CREATE DATABASE IF NOT EXISTS mental_health;
USE mental_health;

-- USERS TABLE
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'therapist', 'admin') DEFAULT 'user',
    name VARCHAR(100),
    email VARCHAR(100)
);

-- ACTIVITIES TABLE
CREATE TABLE activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    NAME VARCHAR(100),
    description TEXT,
    created_by INT,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ENROLLMENTS TABLE
CREATE TABLE enrollments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    activity_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (activity_id) REFERENCES activities(id) ON DELETE CASCADE
);

-- RESOURCES TABLE
CREATE TABLE resources (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100),
    description TEXT,
    category VARCHAR(50)
);
