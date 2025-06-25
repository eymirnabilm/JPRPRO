<?php
require_once 'config/database.php';

// Get all services for dropdown
$stmt = $pdo->query('SELECT * FROM layanan ORDER BY jenis_layanan DESC, nama_layanan ASC');
$layanan = $stmt->fetchAll();

// Get selected service if any
$selected_layanan_id = $_GET['layanan'] ?? null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $nomor_hp = $_POST['nomor_hp'] ?? '';
    $layanan_id = $_POST['layanan_id'] ?? '';
    $tanggal = $_POST['tanggal'] ?? '';
    $catatan = $_POST['catatan'] ?? '';
    $error = [];

    // Validation
    if (empty($nama)) $error[] = 'Nama harus diisi';
    if (empty($alamat)) $error[] = 'Alamat harus diisi';
    if (empty($nomor_hp)) $error[] = 'Nomor HP harus diisi';
    if (empty($layanan_id)) $error[] = 'Layanan harus dipilih';
    if (empty($tanggal)) $error[] = 'Tanggal harus diisi';
    if (!preg_match('/^[0-9]{10,15}$/', $nomor_hp)) $error[] = 'Format nomor HP tidak valid';
    
    // Check if date is in the future
    if (strtotime($tanggal) < strtotime(date('Y-m-d'))) {
        $error[] = 'Tanggal harus di masa depan';
    }

    if (empty($error)) {
        try {
            $stmt = $pdo->prepare('INSERT INTO pesanan (nama, alamat, nomor_hp, layanan_id, tanggal, catatan, status) VALUES (?, ?, ?, ?, ?, ?, "requested")');
            $stmt->execute([$nama, $alamat, $nomor_hp, $layanan_id, $tanggal, $catatan]);
            $pesanan_id = $pdo->lastInsertId();
            header('Location: pesan-sukses.php?id=' . $pesanan_id);
            exit();
        } catch (PDOException $e) {
            $error[] = 'Terjadi kesalahan saat menyimpan pesanan';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Layanan - JPRPRO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
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
                        <a class="nav-link active" href="pesan.php">Pesan Layanan</a>
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

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Form Pemesanan Layanan</h2>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($error as $err): ?>
                                        <li><?php echo htmlspecialchars($err); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form method="POST" id="pesanForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?php echo $_POST['nama'] ?? ''; ?>" required>
                                <div class="invalid-feedback">Nama harus diisi</div>
                            </div>

                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $_POST['alamat'] ?? ''; ?></textarea>
                                <div class="invalid-feedback">Alamat harus diisi</div>
                            </div>

                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label">Nomor HP</label>
                                <input type="tel" class="form-control" id="nomor_hp" name="nomor_hp" 
                                       value="<?php echo $_POST['nomor_hp'] ?? ''; ?>" 
                                       pattern="[0-9]{10,15}" required>
                                <div class="invalid-feedback">Nomor HP harus valid (10-15 digit)</div>
                            </div>

                            <div class="mb-3">
                                <label for="layanan_id" class="form-label">Pilih Layanan</label>
                                <select class="form-select" id="layanan_id" name="layanan_id" required>
                                    <option value="">Pilih layanan...</option>
                                    <?php foreach ($layanan as $item): ?>
                                        <option value="<?php echo $item['id']; ?>" 
                                                <?php echo ($selected_layanan_id == $item['id'] || ($_POST['layanan_id'] ?? '') == $item['id']) ? 'selected' : ''; ?>
                                                data-harga="<?php echo $item['harga']; ?>">
                                            <?php echo htmlspecialchars($item['nama_layanan']); ?> 
                                            (<?php echo ucfirst($item['jenis_layanan']); ?>) - 
                                            Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Pilih layanan yang diinginkan</div>
                            </div>

                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal Layanan</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                       value="<?php echo $_POST['tanggal'] ?? ''; ?>" 
                                       min="<?php echo date('Y-m-d'); ?>" required>
                                <div class="invalid-feedback">Pilih tanggal layanan (minimal hari ini)</div>
                            </div>

                            <div class="mb-3">
                                <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
                                <textarea class="form-control" id="catatan" name="catatan" rows="3"><?php echo $_POST['catatan'] ?? ''; ?></textarea>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Pesan Sekarang</button>
                                <a href="layanan.php" class="btn btn-light">Kembali ke Layanan</a>
                            </div>
                        </form>
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
                        <li><a href="tentang-kami.php" class="text-light">Tentang Kami</a></li>
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
            const form = document.getElementById('pesanForm');
            
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });

            // Set minimum date for tanggal input
            const tanggalInput = document.getElementById('tanggal');
            const today = new Date().toISOString().split('T')[0];
            tanggalInput.setAttribute('min', today);

            // Phone number validation
            const nomorHpInput = document.getElementById('nomor_hp');
            nomorHpInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length > 15) {
                    this.value = this.value.slice(0, 15);
                }
            });
        });
    </script>
</body>
</html>