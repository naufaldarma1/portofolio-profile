<?php
/**
 * logout.php
 * -----------------------------------------
 * Menghapus SESSION (status login di server)
 * dan COOKIE (data yang tersimpan di browser).
 */

session_start();

// Hapus semua data session dan hancurkan session-nya
$_SESSION = [];
session_destroy();

// Hapus cookie dengan mengatur waktu kedaluwarsa ke masa lalu
setcookie("remembered_user", "", time() - 3600, "/");
setcookie("last_login", "", time() - 3600, "/");

header("Location: login.php");
exit;
