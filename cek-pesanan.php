<?php
require_once 'config/database.php';

$pesanan = null;
$error = null;

if (isset($_GET['id']) || isset($_POST['pesanan_id'])) {
    $pesanan_id = $_GET['id'] ?? $_POST['pesanan_id'];
    
    try {
        $stmt = $pdo->prepare('SELECT p.*, l.nama_layanan, l.jenis_layanan, l.harga 
                               FROM pesanan p 
                               JOIN layanan l ON p.layanan_id = l.id 
                               WHERE p.id = ?');
        $stmt->execute([$pesanan_id]);
        $pesanan = $stmt->fetch();
        
        if (!$pesanan) {
            $error = 'Pesanan tidak ditemukan';
        }
    } catch (PDOException $e) {
        $error = 'Terjadi kesalahan saat mencari pesanan';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Status Pesanan - JPRPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .order-status {
            font-size: 1.2rem;
            padding: 10px 20px;
            border-radius: 50px;
        }
        .status-timeline {
            position: relative;
            padding-left: 50px;
        }
        .status-timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #dee2e6;
        }
        .status-item {
            position: relative;
            margin-bottom: 30px;
        }
        .status-item::before {
            content: '';
            position: absolute;
            left: -50px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #fff;
            border: 2px solid #dee2e6;
        }
        .status-item.active::before {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .status-item.completed::before {
            background-color: #198754;
            border-color: #198754;
        }
        .status-item.rejected::before {
            background-color: #dc3545;
            border-color: #dc3545;
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
                        <a class="nav-link active" href="cek-pesanan.php">Cek Pesanan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if (!$pesanan): ?>
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Cek Status Pesanan</h2>
                            
                            <?php if ($error): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <form method="POST" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="pesanan_id" class="form-label">ID Pesanan</label>
                                    <input type="number" class="form-control form-control-lg" 
                                           id="pesanan_id" name="pesanan_id" required>
                                    <div class="invalid-feedback">Masukkan ID pesanan Anda</div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-search me-2"></i> Cek Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card shadow">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Detail Pesanan</h2>

                            <div class="text-center mb-4">
                                <span class="order-status badge bg-<?php 
                                    echo match($pesanan['status']) {
                                        'requested' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary'
                                    };
                                ?>">
                                    <?php 
                                        echo match($pesanan['status']) {
                                            'requested' => 'Menunggu Konfirmasi',
                                            'approved' => 'Pesanan Disetujui',
                                            'rejected' => 'Pesanan Ditolak',
                                            default => 'Status Tidak Diketahui'
                                        };
                                    ?>
                                </span>
                            </div>

                            <div class="status-timeline mb-4">
                                <div class="status-item <?php echo in_array($pesanan['status'], ['requested', 'approved', 'rejected']) ? 'active' : ''; ?>">
                                    <h5>Pesanan Dibuat</h5>
                                    <p class="text-muted">Pesanan Anda telah berhasil dibuat dan menunggu konfirmasi.</p>
                                </div>
                                
                                <?php if ($pesanan['status'] === 'approved'): ?>
                                <div class="status-item completed">
                                    <h5>Pesanan Disetujui</h5>
                                    <p class="text-muted">Tim kami akan datang sesuai jadwal yang telah ditentukan.</p>
                                </div>
                                <?php elseif ($pesanan['status'] === 'rejected'): ?>
                                <div class="status-item rejected">
                                    <h5>Pesanan Ditolak</h5>
                                    <p class="text-muted">Mohon maaf, pesanan Anda tidak dapat kami proses saat ini.</p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <h5>Detail Pemesan:</h5>
                                    <ul class="list-unstyled">
                                        <li><strong>Nama:</strong> <?php echo htmlspecialchars($pesanan['nama']); ?></li>
                                        <li><strong>No. HP:</strong> <?php echo htmlspecialchars($pesanan['nomor_hp']); ?></li>
                                        <li><strong>Alamat:</strong> <?php echo htmlspecialchars($pesanan['alamat']); ?></li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5>Detail Layanan:</h5>
                                    <ul class="list-unstyled">
                                        <li>
                                            <strong>Layanan:</strong> <?php echo htmlspecialchars($pesanan['nama_layanan']); ?>
                                            <span class="badge bg-<?php echo $pesanan['jenis_layanan'] === 'premium' ? 'warning' : 'info'; ?>">
                                                <?php echo ucfirst($pesanan['jenis_layanan']); ?>
                                            </span>
                                        </li>
                                        <li><strong>Tanggal:</strong> <?php echo date('d/m/Y', strtotime($pesanan['tanggal'])); ?></li>
                                        <li><strong>Biaya:</strong> Rp <?php echo number_format($pesanan['harga'], 0, ',', '.'); ?></li>
                                    </ul>
                                </div>
                                <?php if ($pesanan['catatan']): ?>
                                <div class="col-12">
                                    <h5>Catatan:</h5>
                                    <p class="mb-0"><?php echo nl2br(htmlspecialchars($pesanan['catatan'])); ?></p>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="cek-pesanan.php" class="btn btn-outline-primary">
                                    <i class="bi bi-arrow-left me-2"></i> Cek Pesanan Lain
                                </a>
                                <a href="index.php" class="btn btn-primary">
                                    <i class="bi bi-house me-2"></i> Kembali ke Home
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
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
    <script>
        // Form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                });
            }
        });
    </script>
</body>
</html>