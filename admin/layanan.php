<?php
require_once '../config/database.php';
require_once '../middleware/auth.php';

requireLogin();

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    try {
        $stmt = $pdo->prepare('DELETE FROM layanan WHERE id = ?');
        $stmt->execute([$id]);
        header('Location: layanan.php?success=Layanan berhasil dihapus');
        exit();
    } catch (PDOException $e) {
        $error = 'Gagal menghapus layanan. Pastikan tidak ada pesanan yang terkait.';
    }
}

// Get all services
$stmt = $pdo->query('SELECT * FROM layanan ORDER BY id DESC');
$layanan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Layanan - JPRPRO</title>
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
                            <a class="nav-link" href="dashboard.php">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                            <a class="nav-link active" href="layanan.php">
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

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Kelola Layanan</h1>
                    <a href="layanan_form.php" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Tambah Layanan
                    </a>
                </div>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($_GET['success']); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Gambar</th>
                                        <th>Nama Layanan</th>
                                        <th>Jenis</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($layanan as $item): ?>
                                    <tr>
                                        <td><?php echo $item['id']; ?></td>
                                        <td>
                                            <?php if ($item['gambar']): ?>
                                                <img src="../uploads/<?php echo htmlspecialchars($item['gambar']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['nama_layanan']); ?>" 
                                                     class="img-thumbnail" style="max-width: 100px;">
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($item['nama_layanan']); ?></td>
                                        <td><?php echo htmlspecialchars($item['jenis_layanan']); ?></td>
                                        <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars($item['deskripsi']); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="layanan_form.php?id=<?php echo $item['id']; ?>" 
                                                   class="btn btn-sm btn-info text-white">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                    <button type="submit" name="delete" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
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