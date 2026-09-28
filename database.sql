-- =========================================
-- database.sql
-- Jalankan file ini melalui phpMyAdmin (tab SQL)
-- atau via terminal: mysql -u root -p < database.sql
-- =========================================

CREATE DATABASE IF NOT EXISTS praktikum_portofolio;
USE praktikum_portofolio;

-- Tabel untuk menyimpan project/karya yang diinput lewat form_input.php
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255),
    link VARCHAR(255),
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Catatan:
-- Login admin pada praktikum ini sengaja dibuat sederhana (hardcode
-- di login.php: admin / admin123) karena fokus Praktikum 3 adalah
-- konsep cookie & session, bukan manajemen user di database.
