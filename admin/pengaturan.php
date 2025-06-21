<?php
require_once '../config/database.php';
require_once '../middleware/auth.php';

requireLogin();

// Ambil data pengaturan perusahaan
$stmt = $pdo->query('SELECT * FROM pengaturan LIMIT 1');
$pengaturan = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if ($pengaturan) {
            // Update pengaturan yang ada
            $stmt = $pdo->prepare('UPDATE pengaturan SET nama_perusahaan = ?, alamat = ?, email = ?, telepon = ?, deskripsi = ? WHERE id = ?');
            $stmt->execute([
                $_POST['nama_perusahaan'],
                $_POST['alamat'],
                $_POST['email'],
                $_POST['telepon'],
                $_POST['deskripsi'],
                $pengaturan['id']
            ]);
        } else {
            // Buat pengaturan baru
            $stmt = $pdo->prepare('INSERT INTO pengaturan (nama_perusahaan, alamat, email, telepon, deskripsi) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([
                $_POST['nama_perusahaan'],
                $_POST['alamat'],
                $_POST['email'],
                $_POST['telepon'],
                $_POST['deskripsi']
            ]);
        }
        header('Location: pengaturan.php?success=Pengaturan berhasil disimpan');
        exit();
    } catch (PDOException $e) {
        $error = 'Gagal menyimpan pengaturan.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Perusahaan - JPRPRO</title>
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
                            <a class="nav-link" href="pesanan.php">
                                <i class="bi bi-cart-check"></i> Kelola Pesanan
                            </a>
                            <a class="nav-link active" href="pengaturan.php">
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
                    <h1>Pengaturan Perusahaan</h1>
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
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" 
                                       value="<?php echo htmlspecialchars($pengaturan['nama_perusahaan'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($pengaturan['alamat'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($pengaturan['email'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="tel" class="form-control" id="telepon" name="telepon" 
                                       value="<?php echo htmlspecialchars($pengaturan['telepon'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Perusahaan</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5"><?php echo htmlspecialchars($pengaturan['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Pengaturan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>