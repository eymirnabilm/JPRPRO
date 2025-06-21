-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2025 at 07:57 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jprpro_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(100) NOT NULL,
  `jenis_layanan` enum('reguler','premium') NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `layanan`
--

INSERT INTO `layanan` (`id`, `nama_layanan`, `jenis_layanan`, `harga`, `deskripsi`, `gambar`) VALUES
(1, 'Pembersihan Rumah Reguler', 'reguler', 150000.00, 'Layanan pembersihan rumah standar termasuk menyapu, mengepel, dan membersihkan debu', '684ba5535119a.jpg'),
(2, 'Pembersihan Rumah Premium', 'premium', 300000.00, 'Layanan pembersihan rumah menyeluruh termasuk pembersihan mendalam untuk semua area', '684ba51c10571.jpg'),
(3, 'Pembersihan Dapur Reguler', 'reguler', 100000.00, 'Pembersihan dapur standar termasuk membersihkan peralatan dapur dan permukaan', '684ba4bab7844.jpg'),
(4, 'Pembersihan Dapur Premium', 'premium', 200000.00, 'Pembersihan dapur menyeluruh termasuk pembersihan lemari dan peralatan spesifik', '684ba4545d28f.jpg'),
(5, 'Pembersihan Plafon Reguler', 'reguler', 200000.00, 'Jasa Pembersihan Plafon agar terhindar dari jamur!', '684ba5b91e3d7.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `telepon` varchar(20) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `nama_perusahaan`, `alamat`, `email`, `telepon`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'JPRPRO - Jasa Pembersih Rumah Profesional', 'Jl. Juragan Angklek No. 62E RT.04/RW.02', 'info.jprpro@gmail.com', '+6281111111111', 'Jasa Pembersih Rumah Profesional yang handal dibanding perusahaan lain!', '2025-06-21 17:55:15', '2025-06-21 17:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `nomor_hp` varchar(15) NOT NULL,
  `layanan_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `catatan` text DEFAULT NULL,
  `status` enum('requested','approved','rejected') DEFAULT 'requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id`, `nama`, `alamat`, `nomor_hp`, `layanan_id`, `tanggal`, `catatan`, `status`) VALUES
(1, 'Eymir Nabil Makarim', 'Jl. Tenggiri 4 No. 5, Bekasi', '081219747767', 4, '2025-06-13', 'Mohon datangnya secepat mungkin!', 'approved'),
(2, 'Andi Muh Farhan', 'Jl. Anggrek raya No. 11, Bekasi', '081219111111', 2, '2025-06-13', 'tolong dipercepat di hari ini?', 'rejected'),
(3, 'David Ananda Putra', 'Jl. Kesemek No. 5, Jakarta Utara', '08139768543', 2, '2025-06-18', 'Mungkin bisa ditambahkan diskonnya', 'requested');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `layanan_id` (`layanan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
