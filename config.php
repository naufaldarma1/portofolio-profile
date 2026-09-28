<?php
/**
 * config.php
 * -----------------------------------------
 * File koneksi ke database menggunakan mysqli (gaya Object Oriented).
 * File ini di-"require" di halaman-halaman yang butuh akses database.
 *
 * Sesuaikan $host, $username, $password, $database
 * dengan pengaturan XAMPP / Laragon di komputer masing-masing.
 * (Default XAMPP biasanya: user = root, password = kosong)
 */

$host     = "localhost";
$username = "root";
$password = "";
$database = "praktikum_portofolio";

$koneksi = new mysqli($host, $username, $password, $database);

// Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error
if ($koneksi->connect_error) {
    die("Koneksi database gagal: " . $koneksi->connect_error);
}

// Set charset agar karakter (termasuk emoji/simbol) tersimpan dengan benar
$koneksi->set_charset("utf8mb4");
