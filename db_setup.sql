-- SQL to create database and tables for the admin panel
CREATE DATABASE IF NOT EXISTS website_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE website_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_name VARCHAR(50) NOT NULL UNIQUE,
    content LONGTEXT
);

CREATE TABLE IF NOT EXISTS faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question TEXT,
    answer TEXT
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150),
    description TEXT,
    price DECIMAL(10,2) DEFAULT 0.00,
    image VARCHAR(255) DEFAULT NULL
);

-- Insert default admin (username: admin, password: admin123)
INSERT IGNORE INTO users (username, password) VALUES ('admin', '$2y$10$CwTycUXWue0Thq9StjUM0uJ8o2b6m1mZq6s7u2Z6Qb0K0x1Yx8/aa'); -- password_hash('admin123', PASSWORD_DEFAULT)
