<?php
require_once '../config/database.php';
require_once '../middleware/auth.php';

requireLogin();

// Get total services count
$stmt = $pdo->query('SELECT COUNT(*) as total_layanan FROM layanan');
$totalLayanan = $stmt->fetch()['total_layanan'];

// Get total orders count
$stmt = $pdo->query('SELECT COUNT(*) as total_pesanan FROM pesanan');
$totalPesanan = $stmt->fetch()['total_pesanan'];

// Get orders by status
$stmt = $pdo->query('SELECT status, COUNT(*) as jumlah FROM pesanan GROUP BY status');
$pesananByStatus = $stmt->fetchAll();

// Get recent orders
$stmt = $pdo->query('SELECT p.*, l.nama_layanan FROM pesanan p JOIN layanan l ON p.layanan_id = l.id ORDER BY p.id DESC LIMIT 5');
$recentPesanan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - JPRPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 bg-white sidebar">
                <div class="d-flex flex-column">
                    <div class="p-3 border-bottom">
                        <h5 class="mb-0">JPRPRO Admin</h5>
                    </div>
                    <div class="p-3">
                        <div class="nav flex-column">
                            <a class="nav-link active" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                            <a class="nav-link" href="layanan.php">
                                <i class="bi bi-box-seam"></i> Kelola Layanan
                            </a>
                            <a class="nav-link" href="pesanan.php">
                                <i class="bi bi-cart-check"></i> Kelola Pesanan
                            </a>
                            <a class="nav-link" href="pengaturan.php">
                                <i class="bi bi-gear"></i> Pengaturan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-auto main-content px-4">
                <!-- Top Bar -->
                <div class="row top-bar py-3 mb-4">
                    <div class="col d-flex justify-content-end align-items-center">
                        <span class="me-3">
                            <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        <a href="logout.php" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </div>
                </div>

                <h1 class="mb-4">Dashboard</h1>

                <div class="row">
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Total Layanan</h5>
                                <p class="card-text display-4"><?php echo $totalLayanan; ?></p>
                                <i class="bi bi-box-seam position-absolute bottom-0 end-0 mb-3 me-3" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Total Pesanan</h5>
                                <p class="card-text display-4"><?php echo $totalPesanan; ?></p>
                                <i class="bi bi-cart-check position-absolute bottom-0 end-0 mb-3 me-3" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>

                    <?php foreach ($pesananByStatus as $status): ?>
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">Pesanan <?php echo ucfirst($status['status']); ?></h5>
                                <p class="card-text display-4"><?php echo $status['jumlah']; ?></p>
                                <i class="bi bi-clipboard-check position-absolute bottom-0 end-0 mb-3 me-3" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pesanan Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Layanan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentPesanan as $pesanan): ?>
                                    <tr>
                                        <td><?php echo $pesanan['id']; ?></td>
                                        <td><?php echo htmlspecialchars($pesanan['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($pesanan['nama_layanan']); ?></td>
                                        <td><?php echo $pesanan['tanggal']; ?></td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo match($pesanan['status']) {
                                                    'requested' => 'warning',
                                                    'approved' => 'success',
                                                    'rejected' => 'danger',
                                                    default => 'secondary'
                                                };
                                            ?>">
                                                <?php echo ucfirst($pesanan['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>