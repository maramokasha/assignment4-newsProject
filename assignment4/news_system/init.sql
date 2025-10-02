-- إنشاء قاعدة البيانات والجداول
CREATE DATABASE IF NOT EXISTS news_system CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE news_system;


CREATE TABLE IF NOT EXISTS users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(100) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE IF NOT EXISTS news (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
category_id INT NOT NULL,
details TEXT NOT NULL,
image VARCHAR(255),
user_id INT NOT NULL,
deleted TINYINT(1) DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- مثال مستخدم تجريبي (الباسورد: test123)
INSERT INTO users (name, email, password) VALUES ('مرام عكاشة','maram@example.com', '$2y$10$3qYV1gkE0aWl9q7Y1b0J1uM3hHk3bCwR9Qh7TqC6k8QzN8f8z3XqK');


-- مثال فئات
INSERT INTO categories (name) VALUES ('أخبار رياضية'), ('أخبار سياسية'), ('ثقافة');