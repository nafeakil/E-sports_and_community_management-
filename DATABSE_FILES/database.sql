CREATE DATABASE IF NOT EXISTS games_showcase;
USE games_showcase;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (username, password) 
SELECT 'player1', 'pass123' WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'player1');

INSERT INTO users (username, password) 
SELECT 'admin', 'supersecret123' WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'admin');

CREATE TABLE IF NOT EXISTS login_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS game_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    player_name VARCHAR(100) NOT NULL,
    selected_game VARCHAR(50) NOT NULL
);

SELECT * FROM users;

SELECT * FROM login_logs;

SELECT * FROM game_registrations;