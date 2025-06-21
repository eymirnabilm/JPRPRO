<?php
require_once 'config/database.php';

$pesanan_id = $_GET['id'] ?? null;
$pesanan = null;

if ($pesanan_id) {
    $stmt = $pdo->prepare('SELECT p.*, l.nama_layanan, l.harga FROM pesanan p JOIN layanan l ON p.layanan_id = l.id WHERE p.id = ?');
    $stmt->execute([$pesanan_id]);
    $pesanan = $stmt->fetch();
}

if (!$pesanan) {
    header('Location: pesan.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - JPRPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .success-icon {
            font-size: 5rem;
            color: #198754;
        }
        .order-info {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
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
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body text-center p-5">
                        <i class="bi bi-check-circle-fill success-icon mb-4"></i>
                        <h2 class="mb-4">Pesanan Berhasil Dibuat!</h2>
                        <p class="lead mb-4">Terima kasih telah memesan layanan pembersihan di JPRPRO.</p>
                        
                        <div class="order-info text-start mb-4">
                            <h5 class="mb-3">Detail Pesanan:</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>ID Pesanan:</strong><br>
                                    <?php echo $pesanan['id']; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Status:</strong><br>
                                    <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Nama:</strong><br>
                                    <?php echo htmlspecialchars($pesanan['nama']); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Layanan:</strong><br>
                                    <?php echo htmlspecialchars($pesanan['nama_layanan']); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Tanggal:</strong><br>
                                    <?php echo date('d/m/Y', strtotime($pesanan['tanggal'])); ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Total Biaya:</strong><br>
                                    Rp <?php echo number_format($pesanan['harga'], 0, ',', '.'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Simpan ID Pesanan Anda untuk mengecek status pesanan: <strong><?php echo $pesanan['id']; ?></strong>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mt-4">
                            <a href="cek-pesanan.php?id=<?php echo $pesanan['id']; ?>" class="btn btn-primary btn-lg me-md-2">
                                <i class="bi bi-search me-2"></i> Cek Status Pesanan
                            </a>
                            <a href="index.php" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-house me-2"></i> Kembali ke Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>JPRPRO</h5>
                    <p>Jasa Pembersihan Rumah Profesional yang siap melayani kebutuhan kebersihan rumah Anda.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-light">Home</a></li>
                        <li><a href="layanan.php" class="text-light">Layanan</a></li>
                        <li><a href="pesan.php" class="text-light">Pesan Layanan</a></li>
                        <li><a href="cek-pesanan.php" class="text-light">Cek Pesanan</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Kontak</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-telephone me-2"></i> +62 123 4567 890</li>
                        <li><i class="bi bi-envelope me-2"></i> info@jprpro.com</li>
                        <li><i class="bi bi-geo-alt me-2"></i> Jl. Contoh No. 123, Kota</li>
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