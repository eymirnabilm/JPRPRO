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
    <title>JPRPRO - Jasa Pembersihan Rumah Profesional</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
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
                        <a class="nav-link active" href="index.php">Home</a>
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
                        <a class="nav-link" href="tentang-kami.php">Tentang Kami</a>
                    </li>
                </ul>
                <a href="admin/login.php" class="btn btn-light">Login</a>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <div class="fade-in">
                <h1 class="display-4 fw-bold mb-4">Jasa Pembersih Rumah Profesional</h1>
                <p class="lead mb-4">Kami menyediakan jasa pembersihan rumah profesional dengan kualitas terbaik. Tim kami terlatih dan berpengalaman untuk memberikan layanan terbaik bagi Anda.</p>
                <a href="pesan.php" class="btn btn-light btn-lg">Pesan Sekarang <i class="bi bi-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Mengapa Memilih JPRPRO?</h2>
            <div class="row g-4 slide-up">
                <div class="col-md-4 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h3>Terpercaya</h3>
                    <p>Tim profesional yang terlatih dan berpengalaman dalam memberikan layanan pembersihan berkualitas.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-clock"></i>
                    </div>
                    <h3>Tepat Waktu</h3>
                    <p>Layanan yang selalu tepat waktu sesuai dengan jadwal yang telah disepakati.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon">
                        <i class="bi bi-star"></i>
                    </div>
                    <h3>Hasil Maksimal</h3>
                    <p>Hasil pembersihan yang maksimal dengan menggunakan peralatan dan bahan pembersih berkualitas.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Layanan Kami</h2>
            <div class="row g-4 slide-up">
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-house feature-icon"></i>
                            <h4>Pembersihan Rumah</h4>
                            <p>Layanan pembersihan menyeluruh untuk seluruh area rumah Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-bucket feature-icon"></i>
                            <h4>Pembersihan Dapur</h4>
                            <p>Membersihkan area dapur hingga peralatan memasak.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-brush feature-icon"></i>
                            <h4>Pembersihan Kamar Mandi</h4>
                            <p>Membersihkan dan mensterilkan area kamar mandi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card service-card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-stars feature-icon"></i>
                            <h4>General Cleaning</h4>
                            <p>Pembersihan menyeluruh untuk semua area dan perabotan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center slide-up">
                <div class="col-md-6">
                    <h2 class="mb-4 fw-bold">Siap Memberikan Layanan Terbaik</h2>
                    <p class="lead mb-4">Kami berkomitmen untuk memberikan layanan pembersihan terbaik dengan:</p>
                    <ul class="list-unstyled">
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Tim profesional yang terlatih</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Peralatan modern dan berkualitas</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Bahan pembersih ramah lingkungan</li>
                        <li class="mb-3"><i class="bi bi-check-circle-fill text-primary me-2"></i> Jaminan kepuasan pelanggan</li>
                    </ul>
                    <a href="pesan.php" class="btn btn-primary btn-lg">Pesan Sekarang</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="assets/cleaning-service.svg" alt="Cleaning Service" class="img-fluid" style="max-width: 400px;">
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><?php echo htmlspecialchars($pengaturan['nama_perusahaan'] ?? 'JPRPRO'); ?></h5>
                    <p><?php echo htmlspecialchars($pengaturan['deskripsi'] ?? 'Jasa Pembersihan Rumah Profesional yang siap melayani kebutuhan kebersihan rumah Anda.'); ?></p>
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
                        <li><i class="bi bi-geo-alt me-2"></i> <?php echo htmlspecialchars($pengaturan['alamat'] ?? 'Jl. Contoh No. 123, Kota'); ?></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 JPRPRO. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>