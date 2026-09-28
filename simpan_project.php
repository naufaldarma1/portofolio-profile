<?php
/**
 * simpan_project.php
 * -----------------------------------------
 * Poin 2 & 3 Praktikum:
 * - Mengambil data form menggunakan $_REQUEST (sesuai instruksi soal).
 *   Catatan: $_REQUEST bisa membaca data dari GET, POST, maupun COOKIE
 *   sekaligus. Ini bagus untuk latihan, tapi di project nyata sebaiknya
 *   pakai $_POST secara eksplisit agar lebih aman & terprediksi.
 * - Menyimpan data ke database sederhana menggunakan mysqli (prepared statement).
 */

session_start();

// Halaman proses ini juga harus dilindungi, bukan hanya form-nya
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("Location: login.php");
    exit;
}

require "config.php";

// ===== Mengambil data dari form menggunakan $_REQUEST =====
$judul     = trim($_REQUEST['judul'] ?? '');
$deskripsi = trim($_REQUEST['deskripsi'] ?? '');
$gambar    = trim($_REQUEST['gambar'] ?? '');
$link      = trim($_REQUEST['link'] ?? '');

// Validasi sederhana: judul wajib diisi
if ($judul === '') {
    header("Location: form_input.php?status=error");
    exit;
}

// ===== Simpan ke database menggunakan mysqli prepared statement =====
// Prepared statement dipakai supaya aman dari SQL Injection
$stmt = $koneksi->prepare(
    "INSERT INTO projects (judul, deskripsi, gambar, link) VALUES (?, ?, ?, ?)"
);
$stmt->bind_param("ssss", $judul, $deskripsi, $gambar, $link);

if ($stmt->execute()) {
    header("Location: form_input.php?status=success");
} else {
    header("Location: form_input.php?status=error");
}

$stmt->close();
$koneksi->close();
exit;
