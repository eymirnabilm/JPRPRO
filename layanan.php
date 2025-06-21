<?php
require_once 'config/database.php';

// Get all services
$stmt = $pdo->query('SELECT * FROM layanan ORDER BY jenis_layanan DESC, id ASC');
$layanan = $stmt->fetchAll();

// Group services by type
$layananByType = [];
foreach ($layanan as $item) {
    $layananByType[$item['jenis_layanan']][] = $item;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan - JPRPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        .service-card {
            transition: transform 0.3s;
        }
        .service-card:hover {
            transform: translateY(-5px);
        }
        .service-image {
            height: 200px;
            object-fit: cover;
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
                        <a class="nav-link active" href="layanan.php">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pesan.php">Pesan Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cek-pesanan.php">Cek Pesanan</a>
                    </li>
                </ul>
                <a href="admin/login.php" class="btn btn-light">Login</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <h1 class="text-center mb-5">Layanan Kami</h1>

        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <div class="btn-group w-100" role="group">
                    <button type="button" class="btn btn-outline-primary active" data-filter="all">Semua</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="premium">Premium</button>
                    <button type="button" class="btn btn-outline-primary" data-filter="reguler">Reguler</button>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <?php foreach ($layanan as $item): ?>
            <div class="col-md-6 col-lg-4 service-item" data-type="<?php echo $item['jenis_layanan']; ?>">
                <div class="card service-card h-100">
                    <?php if ($item['gambar']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($item['gambar']); ?>" 
                         class="card-img-top service-image" 
                         alt="<?php echo htmlspecialchars($item['nama_layanan']); ?>">
                    <?php else: ?>
                    <div class="card-img-top service-image bg-light d-flex align-items-center justify-content-center">
                        <i class="bi bi-image text-muted" style="font-size: 4rem;"></i>
                    </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['nama_layanan']); ?></h5>
                            <span class="badge bg-<?php echo $item['jenis_layanan'] === 'premium' ? 'warning' : 'info'; ?>">
                                <?php echo ucfirst($item['jenis_layanan']); ?>
                            </span>
                        </div>
                        <p class="card-text"><?php echo htmlspecialchars($item['deskripsi']); ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></span>
                            <a href="pesan.php?layanan=<?php echo $item['id']; ?>" class="btn btn-primary">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('[data-filter]');
            const serviceItems = document.querySelectorAll('.service-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const filter = button.getAttribute('data-filter');

                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    button.classList.add('active');

                    // Filter services
                    serviceItems.forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-type') === filter) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>