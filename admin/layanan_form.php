<?php
require_once '../config/database.php';
require_once '../middleware/auth.php';

requireLogin();

$id = $_GET['id'] ?? null;
$layanan = null;
$isEdit = false;

if ($id) {
    $isEdit = true;
    $stmt = $pdo->prepare('SELECT * FROM layanan WHERE id = ?');
    $stmt->execute([$id]);
    $layanan = $stmt->fetch();

    if (!$layanan) {
        header('Location: layanan.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_layanan = $_POST['nama_layanan'];
    $jenis_layanan = $_POST['jenis_layanan'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $current_gambar = $layanan['gambar'] ?? '';
    $gambar = $current_gambar;

    // Handle image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = uniqid() . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $upload_path)) {
                $gambar = $new_filename;
                // Delete old image if exists
                if ($current_gambar && file_exists($upload_dir . $current_gambar)) {
                    unlink($upload_dir . $current_gambar);
                }
            }
        }
    }

    try {
        if ($isEdit) {
            $stmt = $pdo->prepare('UPDATE layanan SET nama_layanan = ?, jenis_layanan = ?, harga = ?, deskripsi = ?, gambar = ? WHERE id = ?');
            $stmt->execute([$nama_layanan, $jenis_layanan, $harga, $deskripsi, $gambar, $id]);
            $success = 'Layanan berhasil diperbarui';
        } else {
            $stmt = $pdo->prepare('INSERT INTO layanan (nama_layanan, jenis_layanan, harga, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$nama_layanan, $jenis_layanan, $harga, $deskripsi, $gambar]);
            $success = 'Layanan berhasil ditambahkan';
        }

        header('Location: layanan.php?success=' . urlencode($success));
        exit();
    } catch (PDOException $e) {
        $error = 'Terjadi kesalahan saat menyimpan data';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Layanan - JPRPRO</title>
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

                <div class="row justify-content-center">
                    <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><?php echo $isEdit ? 'Edit' : 'Tambah'; ?> Layanan</h5>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" 
                                       value="<?php echo htmlspecialchars($layanan['nama_layanan'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_layanan" class="form-label">Jenis Layanan</label>
                                <select class="form-select" id="jenis_layanan" name="jenis_layanan" required>
                                    <option value="reguler" <?php echo ($layanan['jenis_layanan'] ?? '') === 'reguler' ? 'selected' : ''; ?>>Reguler</option>
                                    <option value="premium" <?php echo ($layanan['jenis_layanan'] ?? '') === 'premium' ? 'selected' : ''; ?>>Premium</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control" id="harga" name="harga" 
                                           value="<?php echo $layanan['harga'] ?? ''; ?>" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required><?php echo htmlspecialchars($layanan['deskripsi'] ?? ''); ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <?php if (isset($layanan['gambar']) && $layanan['gambar']): ?>
                                    <div class="mb-2">
                                        <img src="../uploads/<?php echo htmlspecialchars($layanan['gambar']); ?>" 
                                             alt="Current image" class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                <?php endif; ?>
                                <input type="file" class="form-control" id="gambar" name="gambar" 
                                       accept=".jpg,.jpeg,.png,.gif" <?php echo $isEdit ? '' : 'required'; ?>>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="layanan.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" class="btn btn-primary">
                                    <?php echo $isEdit ? 'Update' : 'Simpan'; ?> Layanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>