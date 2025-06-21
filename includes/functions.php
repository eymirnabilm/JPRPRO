<?php
/**
 * File berisi fungsi-fungsi helper yang digunakan di seluruh aplikasi
 */

/**
 * Mengamankan output string dari XSS
 */
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format angka ke format rupiah
 */
function format_rupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Format tanggal ke format Indonesia
 */
function format_tanggal($date) {
    $bulan = array(
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $split = explode('-', $date);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}

/**
 * Mendapatkan status pesanan dalam bahasa Indonesia
 */
function get_status_pesanan($status) {
    return match($status) {
        'requested' => 'Menunggu Konfirmasi',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        default => 'Status Tidak Diketahui'
    };
}

/**
 * Mendapatkan warna badge untuk status pesanan
 */
function get_status_badge_color($status) {
    return match($status) {
        'requested' => 'warning',
        'approved' => 'success',
        'rejected' => 'danger',
        default => 'secondary'
    };
}

/**
 * Validasi nomor telepon
 */
function is_valid_phone($phone) {
    return preg_match('/^[0-9]{10,15}$/', $phone);
}

/**
 * Validasi tanggal
 */
function is_valid_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Upload file gambar
 */
function upload_image($file, $target_dir = 'uploads/') {
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_extension, $allowed_extensions)) {
        return false;
    }

    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;

    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return $new_filename;
    }

    return false;
}

/**
 * Delete file gambar
 */
function delete_image($filename, $target_dir = 'uploads/') {
    $file_path = $target_dir . $filename;
    if (file_exists($file_path)) {
        return unlink($file_path);
    }
    return false;
}

/**
 * Generate random string
 */
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $string;
}

/**
 * Redirect dengan pesan
 */
function redirect($url, $message = '', $type = 'success') {
    if ($message) {
        $url .= (strpos($url, '?') === false ? '?' : '&') . $type . '=' . urlencode($message);
    }
    header('Location: ' . $url);
    exit();
}