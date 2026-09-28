<?php
/**
 * index.php
 * -----------------------------------------
 * Halaman portofolio utama (sebelumnya index.html).
 * Sekarang mengambil daftar project dari DATABASE (tabel projects)
 * menggunakan mysqli, sehingga bagian "Project" bersifat dinamis.
 *
 * session_start() dipanggil di sini hanya untuk mengecek apakah
 * admin sedang login, supaya navbar bisa menampilkan menu yang sesuai.
 */

session_start();
require "config.php";

$isLogin = isset($_SESSION['is_login']) && $_SESSION['is_login'] === true;

// Ambil semua project dari database, terbaru di atas
$projects = [];
$result = $koneksi->query("SELECT * FROM projects ORDER BY id DESC");
if ($result) {
    $projects = $result->fetch_all(MYSQLI_ASSOC);
}
$koneksi->close();

// Gambar default jika project tidak diisi URL gambar
$defaultImage = "https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=800";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Personal - Muhammad Naufal Darmawan</title>

    <!-- Bootstrap untuk beberapa elemen -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS sendiri -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div class="container-header">
            <h1>Muhammad Naufal Darmawan</h1>
            <p>Sistem Informasi | HTML | CSS | PHP</p>
        </div>
    </header>


    <!-- NAVIGASI -->
    <nav class="navbar-custom">
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#tentang">Tentang</a></li>
            <li><a href="#project">Project</a></li>
            <li><a href="#kontak">Kontak</a></li>
            <?php if ($isLogin): ?>
                <li><a href="form_input.php">Tambah Project</a></li>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>


    <!-- TEKS BERJALAN -->
    <div class="running-text">
        <p>Selamat datang di halaman profil saya. Terima kasih sudah berkunjung!</p>
    </div>


    <!-- LAYOUT UTAMA -->
    <div class="layout" id="home">

        <!-- MAIN CONTENT -->
        <main class="main-content">

            <!-- KONTEN 1 -->
            <article class="content-card" id="tentang">

                <img
                    src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=800"
                    alt="Laptop untuk pengembangan web"
                    class="thumbnail"
                >

                <div class="content-text">
                    <span class="badge text-bg-primary">Tentang Saya</span>

                    <h2>Belajar dan Mengembangkan Diri di Bidang Teknologi</h2>

                    <p>
                        Saya adalah mahasiswa Sistem Informasi yang memiliki ketertarikan pada dunia teknologi, khususnya pengembangan web, data, dan pemrograman. Saya senang mempelajari bagaimana teknologi dapat digunakan untuk menciptakan solusi yang bermanfaat dan mempermudah berbagai aktivitas.
                    </p>

                    <p>
                        Saat ini saya sedang mempelajari HTML, CSS, JavaScript,
                        serta berbagai konsep dasar dalam pengembangan aplikasi
                        berbasis web.
                    </p>

                    <a href="#kontak" class="btn btn-primary">
                        Hubungi Saya
                    </a>
                </div>

            </article>


            <!-- KONTEN PROJECT (DINAMIS DARI DATABASE) -->
            <?php if (count($projects) === 0): ?>

                <article class="content-card" id="project">
                    <div class="content-text">
                        <span class="badge text-bg-success">Project</span>
                        <h2>Belum Ada Project</h2>
                        <p>Project yang ditambahkan lewat form admin akan muncul di sini.</p>
                        <?php if ($isLogin): ?>
                            <a href="form_input.php" class="btn btn-success">Tambah Project</a>
                        <?php endif; ?>
                    </div>
                </article>

            <?php else: ?>

                <?php foreach ($projects as $index => $p): ?>
                    <article class="content-card" <?= $index === 0 ? 'id="project"' : '' ?>>

                        <img
                            src="<?= htmlspecialchars($p['gambar'] ?: $defaultImage) ?>"
                            alt="<?= htmlspecialchars($p['judul']) ?>"
                            class="thumbnail"
                        >

                        <div class="content-text">
                            <span class="badge text-bg-success">Project</span>

                            <h2><?= htmlspecialchars($p['judul']) ?></h2>

                            <p><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></p>

                            <?php if (!empty($p['link'])): ?>
                                <a href="<?= htmlspecialchars($p['link']) ?>" class="btn btn-success" target="_blank">
                                    Lihat Project
                                </a>
                            <?php endif; ?>
                        </div>

                    </article>
                <?php endforeach; ?>

            <?php endif; ?>

        </main>


        <!-- SIDEBAR -->
        <aside class="sidebar">

            <section class="sidebar-box">
                <h3>Profil Singkat</h3>

                <p>
                    Mahasiswa yang sedang belajar pengembangan web dan
                    tertarik dengan teknologi digital.
                </p>
            </section>


            <section class="sidebar-box">
                <h3>Keahlian</h3>

                <ul class="skill-list">
                    <li>HTML</li>
                    <li>CSS</li>
                    <li>JavaScript</li>
                    <li>PHP</li>
                    <li>SQL</li>
                    <li>Database</li>
                </ul>
            </section>


            <section class="sidebar-box" id="kontak">
                <h3>Kontak</h3>

                <p>Email:</p>
                <p class="email">naufal@gmail.com</p>

                <p>Instagram:</p>
                <p>@naufal</p>
            </section>

        </aside>

    </div>


    <!-- FOOTER -->
    <footer class="footer">
        <p>&copy; 2026 Muhammad Naufal Darmawan. Dibuat untuk Praktikum PHP.</p>
    </footer>

</body>
</html>
