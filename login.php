<?php
/**
 * login.php
 * -----------------------------------------
 * Poin 1 Praktikum: Halaman login dengan konsep COOKIE & SESSION.
 *
 * - SESSION dipakai untuk menyimpan STATUS LOGIN (di server).
 *   Ini yang akan dicek di halaman form_input.php untuk membatasi akses.
 *
 * - COOKIE dipakai untuk MENGINGAT username terakhir yang login
 *   (tersimpan di browser), supaya field username otomatis terisi
 *   saat user login lagi di lain waktu.
 */

session_start();

// Jika user sudah login, langsung arahkan ke form input (tidak perlu login lagi)
if (isset($_SESSION['is_login']) && $_SESSION['is_login'] === true) {
    header("Location: form_input.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Kredensial sederhana untuk keperluan praktikum
    $valid_username = "admin";
    $valid_password = "admin123";

    if ($username === $valid_username && $password === $valid_password) {

        // ===== SESSION: status login disimpan di server =====
        $_SESSION['is_login']  = true;
        $_SESSION['username']  = $username;
        $_SESSION['login_time'] = date("d-m-Y H:i:s");

        // ===== COOKIE: disimpan di browser selama 7 hari =====
        setcookie("remembered_user", $username, time() + (86400 * 7), "/");
        setcookie("last_login", date("d-m-Y H:i:s"), time() + (86400 * 7), "/");

        // Setelah login berhasil -> arahkan ke halaman input form
        header("Location: form_input.php");
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}

// Ambil username yang tersimpan di cookie (jika ada) untuk mengisi otomatis field username
$rememberedUser = $_COOKIE['remembered_user'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Muhammad Naufal Darmawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="header">
        <div class="container-header">
            <h1>Muhammad Naufal Darmawan</h1>
            <p>Sistem Informasi | HTML | CSS | PHP</p>
        </div>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card">
            <h2 class="mb-3">Login Admin</h2>
            <p class="text-muted mb-4">Masuk untuk menambahkan project ke portofolio.</p>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if (!empty($_COOKIE['last_login'])): ?>
                <div class="alert alert-info">
                    Terakhir login: <?= htmlspecialchars($_COOKIE['last_login']) ?>
                    (data ini dibaca dari <strong>cookie</strong>)
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="<?= htmlspecialchars($rememberedUser) ?>" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>

            <p class="mt-3 text-muted" style="font-size:14px;">
                Kredensial contoh: <code>admin</code> / <code>admin123</code>
            </p>

            <a href="index.php" class="d-block mt-2">&larr; Kembali ke Portofolio</a>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Muhammad Naufal Darmawan. Dibuat untuk Praktikum PHP.</p>
    </footer>

</body>
</html>
