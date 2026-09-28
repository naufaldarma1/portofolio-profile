<?php
/**
 * form_input.php
 * -----------------------------------------
 * Poin 2 Praktikum: Form untuk menginput project/karya baru.
 *
 * Halaman ini DILINDUNGI SESSION -> hanya bisa diakses
 * jika user sudah login (redirect ke login.php jika belum).
 */

session_start();

if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    header("Location: login.php");
    exit;
}

require "config.php";

// Ambil daftar project yang sudah tersimpan, untuk ditampilkan sebagai konfirmasi
$result = $koneksi->query("SELECT * FROM projects ORDER BY id DESC");

$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Project - Portofolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header class="header">
        <div class="container-header d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1>Muhammad Naufal Darmawan</h1>
                <p>Sistem Informasi | HTML | CSS | PHP</p>
            </div>
            <div>
                <span class="text-light me-3">
                    Halo, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong>
                </span>
                <a href="index.php" class="btn btn-outline-light btn-sm">Lihat Portofolio</a>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </header>

    <div class="auth-wrapper">
        <div class="auth-card" style="max-width:600px;">
            <h2 class="mb-3">Tambah Project Baru</h2>

            <?php if ($status === 'success'): ?>
                <div class="alert alert-success">Project berhasil disimpan ke database!</div>
            <?php elseif ($status === 'error'): ?>
                <div class="alert alert-danger">Gagal menyimpan. Pastikan judul project diisi.</div>
            <?php endif; ?>

            <!--
                Sesuai instruksi praktikum, form ini dapat dicoba
                dengan variabel $_REQUEST (bisa method GET ataupun POST).
                Di simpan_project.php, data diambil lewat $_REQUEST.
            -->
            <form method="POST" action="simpan_project.php">
                <div class="mb-3">
                    <label class="form-label">Judul Project</label>
                    <input type="text" name="judul" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL Gambar (opsional)</label>
                    <input type="text" name="gambar" class="form-control" placeholder="https://...">
                </div>
                <div class="mb-3">
                    <label class="form-label">Link Project (opsional)</label>
                    <input type="text" name="link" class="form-control" placeholder="https://...">
                </div>
                <button type="submit" class="btn btn-success w-100">Simpan Project</button>
            </form>
        </div>
    </div>

    <div class="layout" style="grid-template-columns: 1fr;">
        <section class="sidebar-box">
            <h3>Project Tersimpan di Database</h3>
            <?php if ($result && $result->num_rows > 0): ?>
                <ul class="skill-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <strong><?= htmlspecialchars($row['judul']) ?></strong>
                            <?php if (!empty($row['deskripsi'])): ?>
                                — <?= htmlspecialchars($row['deskripsi']) ?>
                            <?php endif; ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-muted">Belum ada project yang disimpan.</p>
            <?php endif; ?>
        </section>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Muhammad Naufal Darmawan. Dibuat untuk Praktikum PHP.</p>
    </footer>

</body>
</html>
<?php $koneksi->close(); ?>
