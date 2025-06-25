<?php
require_once '../config/database.php';
require_once '../middleware/auth.php';

requireLogin();

// Handle status update
if (isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    try {
        $stmt = $pdo->prepare('UPDATE pesanan SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
        header('Location: pesanan.php?success=Status pesanan berhasil diperbarui');
        exit();
    } catch (PDOException $e) {
        $error = 'Gagal memperbarui status pesanan.';
    }
}

// Get all orders with service details
$stmt = $pdo->query('SELECT p.*, l.nama_layanan, l.jenis_layanan FROM pesanan p JOIN layanan l ON p.layanan_id = l.id ORDER BY p.tanggal DESC');
$pesanan = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pesanan - JPRPRO</title>
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
                            <a class="nav-link" href="layanan.php">
                                <i class="bi bi-box-seam"></i> Kelola Layanan
                            </a>
                            <a class="nav-link active" href="pesanan.php">
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
                    <h1>Kelola Pesanan</h1>
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
                                        <th>Tanggal</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>No. HP</th>
                                        <th>Layanan</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($pesanan as $item): ?>
                                    <tr>
                                        <td><?php echo $item['id']; ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($item['tanggal'])); ?></td>
                                        <td><?php echo htmlspecialchars($item['nama']); ?></td>
                                        <td><?php echo htmlspecialchars($item['alamat']); ?></td>
                                        <td><?php echo htmlspecialchars($item['nomor_hp']); ?></td>
                                        <td><?php echo htmlspecialchars($item['nama_layanan']); ?></td>
                                        <td><?php echo htmlspecialchars($item['jenis_layanan']); ?></td>
                                        <td>
                                            <form method="POST" class="d-inline">
                                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                <select name="status" class="form-select form-select-sm" 
                                                        onchange="this.form.submit()" style="width: auto;">
                                                    <?php
                                                    $statuses = ['requested', 'approved', 'rejected'];
                                                    foreach ($statuses as $status) {
                                                        $selected = $status === $item['status'] ? 'selected' : '';
                                                        echo "<option value=\"$status\" $selected>" . 
                                                             ucfirst($status) . 
                                                             "</option>";
                                                    }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="update_status" value="1">
                                            </form>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info text-white"
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailModal<?php echo $item['id']; ?>">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Detail Modal -->
                                    <div class="modal fade" id="detailModal<?php echo $item['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Detail Pesanan #<?php echo $item['id']; ?></h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <dl class="row">
                                                        <dt class="col-sm-4">Nama</dt>
                                                        <dd class="col-sm-8"><?php echo htmlspecialchars($item['nama']); ?></dd>

                                                        <dt class="col-sm-4">Alamat</dt>
                                                        <dd class="col-sm-8"><?php echo htmlspecialchars($item['alamat']); ?></dd>

                                                        <dt class="col-sm-4">No. HP</dt>
                                                        <dd class="col-sm-8"><?php echo htmlspecialchars($item['nomor_hp']); ?></dd>

                                                        <dt class="col-sm-4">Layanan</dt>
                                                        <dd class="col-sm-8"><?php echo htmlspecialchars($item['nama_layanan']); ?></dd>

                                                        <dt class="col-sm-4">Jenis</dt>
                                                        <dd class="col-sm-8"><?php echo htmlspecialchars($item['jenis_layanan']); ?></dd>

                                                        <dt class="col-sm-4">Tanggal</dt>
                                                        <dd class="col-sm-8"><?php echo date('d/m/Y', strtotime($item['tanggal'])); ?></dd>

                                                        <dt class="col-sm-4">Status</dt>
                                                        <dd class="col-sm-8"><?php echo ucfirst($item['status']); ?></dd>

                                                        <dt class="col-sm-4">Catatan</dt>
                                                        <dd class="col-sm-8"><?php echo nl2br(htmlspecialchars($item['catatan'])); ?></dd>
                                                    </dl>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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