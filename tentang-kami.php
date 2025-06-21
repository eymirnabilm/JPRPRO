<?php
require_once 'config/database.php';

// Ambil data pengaturan perusahaan
$stmt = $pdo->query('SELECT * FROM pengaturan LIMIT 1');
$pengaturan = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang Kami - JPRPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .about-section {
            background: linear-gradient(rgba(0, 123, 255, 0.9), rgba(0, 123, 255, 0.7)), url('assets/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 80px 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">JPRPRO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="layanan.php">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesan.php">Pesan Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cek-pesanan.php">Cek Pesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="tentang-kami.php">Tentang Kami</a>
                    </li>
                </ul>
                <a href="admin/login.php" class="btn btn-light">Login</a>
            </div>
        </div>
    </nav>

    <section class="about-section text-center">
        <div class="container">
            <h1 class="display-4 mb-4"><?php echo htmlspecialchars($pengaturan['nama_perusahaan'] ?? 'JPRPRO'); ?></h1>
            <p class="lead"><?php echo htmlspecialchars($pengaturan['deskripsi'] ?? 'Jasa Pembersihan Rumah Profesional'); ?></p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="mb-4">Profil Perusahaan</h2>
                    <p class="lead mb-4"><?php echo nl2br(htmlspecialchars($pengaturan['deskripsi'] ?? '')); ?></p>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title mb-4">Informasi Kontak</h3>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                                    <?php echo htmlspecialchars($pengaturan['alamat'] ?? 'Alamat belum tersedia'); ?>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-telephone-fill text-primary me-2"></i>
                                    <?php echo htmlspecialchars($pengaturan['telepon'] ?? 'Telepon belum tersedia'); ?>
                                </li>
                                <li class="mb-3">
                                    <i class="bi bi-envelope-fill text-primary me-2"></i>
                                    <?php echo htmlspecialchars($pengaturan['email'] ?? 'Email belum tersedia'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo htmlspecialchars($pengaturan['nama_perusahaan'] ?? 'JPRPRO'); ?></h5>
                    <p><?php echo htmlspecialchars($pengaturan['deskripsi'] ?? 'Jasa Pembersihan Rumah Profesional'); ?></p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-light">Home</a></li>
                        <li><a href="layanan.php" class="text-light">Layanan</a></li>
                        <li><a href="pesan.php" class="text-light">Pesan Layanan</a></li>
                        <li><a href="cek-pesanan.php" class="text-light">Cek Pesanan</a></li>
                        <li><a href="tentang-kami.php" class="text-light">Tentang Kami</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-telephone me-2"></i> <?php echo htmlspecialchars($pengaturan['telepon'] ?? '+62 123 4567 890'); ?></li>
                        <li><i class="bi bi-envelope me-2"></i> <?php echo htmlspecialchars($pengaturan['email'] ?? 'info@jprpro.com'); ?></li>
                        <li><i class="bi bi-geo-alt me-2"></i> <?php echo htmlspecialchars($pengaturan['alamat'] ?? 'Alamat belum tersedia'); ?></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 <?php echo htmlspecialchars($pengaturan['nama_perusahaan'] ?? 'JPRPRO'); ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>