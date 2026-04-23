-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 07:46 AM
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
-- Database: `divqc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `action`, `details`, `timestamp`) VALUES
(1, 1, 'Hapus User', 'Menghapus user: Ikke Surya (ID: 11)', '2026-04-22 23:13:44'),
(2, 1, 'Tambah User', 'Menambahkan user baru: Diandra Mayliza (NIP: M002)', '2026-04-22 23:14:56'),
(3, 3, 'Input Laporan Cacat', 'Staff QC menginput laporan cacat untuk Batch: BTC-2025-004', '2026-04-22 23:26:24'),
(4, 8, 'Keputusan QC', 'Kepala QC telah mengubah status laporan Batch: BTC-2025-002 menjadi DITOLAK', '2026-04-22 23:42:43'),
(5, 1, 'Backup Data', 'Admin melakukan pencadangan database sistem.', '2026-04-22 23:54:16'),
(6, 1, 'Backup Data', 'Admin melakukan pencadangan database sistem.', '2026-04-23 01:03:32'),
(7, 1, 'Tambah User', 'Menambahkan user baru: Takata Mashiho (NIP: K003)', '2026-04-23 01:04:52'),
(8, 1, 'Tambah User', 'Menambahkan user baru: Najla Huwaida (NIP: ST006)', '2026-04-23 12:45:24');

-- --------------------------------------------------------

--
-- Table structure for table `laporancacat`
--

CREATE TABLE `laporancacat` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `jenis_udang` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `kriteria_cacat` varchar(100) DEFAULT NULL,
  `keparahan` enum('Ringan','Sedang','Berat') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `kategori` enum('cacat','non-cacat') DEFAULT 'cacat',
  `status` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `catatan_kepala` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporancacat`
--

INSERT INTO `laporancacat` (`id`, `id_user`, `batch_number`, `jenis_udang`, `tanggal`, `kuantitas`, `kriteria_cacat`, `keparahan`, `deskripsi`, `kategori`, `status`, `catatan_kepala`, `created_at`) VALUES
(1, 3, 'BTC-2025-001', 'Udang Vaname', '2025-05-25', 15, 'Kulit Lunak', 'Ringan', 'Ditemukan beberapa udang dengan kulit yang belum keras sempurna.', 'cacat', 'menunggu', NULL, '2026-02-26 01:58:09'),
(2, 4, 'BTC-2025-002', 'Udang Windu', '2025-05-24', 45, 'Perubahan Warna', 'Berat', 'Warna udang kemerahan pucat, indikasi suhu penyimpanan tidak stabil.', 'cacat', 'ditolak', '', '2026-02-26 01:58:09'),
(3, 3, 'BTC-2025-003', 'Udang Vaname', '2025-05-23', 28, 'Rusak Fisik', 'Sedang', 'Ekor dan kaki banyak yang patah saat proses sortir mesin.', 'cacat', 'diterima', NULL, '2026-02-26 01:58:09'),
(5, 3, 'BTC-2025-004', 'windu', '2026-04-22', 10, 'Perubahan Warna', 'Sedang', 'udang berubah warna menjadi biru terduga tercemar limbah', 'cacat', 'diterima', '', '2026-04-22 16:26:24');

-- --------------------------------------------------------

--
-- Table structure for table `laporannoncacat`
--

CREATE TABLE `laporannoncacat` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `jenis_udang` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `ukuran_sampel` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `catatan_kepala` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `laporannoncacat`
--

INSERT INTO `laporannoncacat` (`id`, `id_user`, `batch_number`, `jenis_udang`, `tanggal`, `kuantitas`, `ukuran_sampel`, `deskripsi`, `status`, `catatan_kepala`, `created_at`) VALUES
(1, 3, 'BTC-NC-001', 'Udang Vaname', '2025-05-25', 5000, 100, 'Kualitas panen sangat prima, ukuran seragam size 30.', 'diterima', NULL, '2026-02-26 02:02:23'),
(2, 4, 'BTC-NC-002', 'Udang Windu', '2025-05-24', 2500, 50, 'Warna cerah, tekstur daging padat. Lulus uji organoleptik.', 'menunggu', NULL, '2026-02-26 02:02:23'),
(4, 3, 'BTC-NC-004', 'Udang Windu', '2025-05-25', 1500, 40, 'Kondisi fresh, langsung masuk cold storage.', 'menunggu', NULL, '2026-02-26 02:02:23'),
(5, 3, 'BTC-NC-005', 'vaname', '2026-04-22', 1500, 0, 'udang fresh siap kirim', 'menunggu', NULL, '2026-04-22 16:20:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `jabatan` enum('admin','staff','kepala','manajer','supervisor') NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nip`, `password`, `nama_lengkap`, `jabatan`, `email`, `no_telp`, `alamat`) VALUES
(1, 'A001', 'admin123', 'Admin Utama', 'admin', 'admin1@misajamitra.com', '08120000001', 'Jl. Merdeka No. 1, Jakarta'),
(2, 'A002', 'admin123', 'Admin Support', 'admin', 'admin2@misajamitra.com', '08120000002', 'Jl. Sudirman No. 45, Jakarta'),
(3, 'ST001', 'staff123', 'Andi Saputra', 'staff', 'andi.st@misajamitra.com', '08210000001', 'Jl. Kebon Jeruk No. 10'),
(4, 'ST002', 'staff123', 'Budi Santoso', 'staff', 'budi.st@misajamitra.com', '08210000002', 'Jl. Mangga Besar No. 22'),
(6, 'ST004', 'staff123', 'Dedi Mulyadi', 'staff', 'dedi.st@misajamitra.com', '08210000004', 'Jl. Melati Putih No. 8'),
(7, 'ST005', 'staff123', 'Eka Pratiwi', 'staff', 'eka.st@misajamitra.com', '08210000005', 'Jl. Mawar Merah No. 12'),
(8, 'K001', 'kepala123', 'Fajar Hidayat', 'kepala', 'fajar.k@misajamitra.com', '08110000001', 'Jl. Diponegoro No. 100, Menteng'),
(9, 'M001', 'manajer123', 'Gilang Pratama', 'manajer', 'gilang.m@misajamitra.com', '08150000001', 'Jl. Thamrin Boulevard No. 88'),
(10, 'SP001', 'spv123', 'Hartono', 'supervisor', 'hartono.sp@misajamitra.com', '08160000001', 'Jl. Gatot Subroto Kav. 5'),
(12, 'M002', 'manajer45', 'Diandra Mayliza', 'manajer', 'dianm22@gmail.com', '081234567890', 'jl perumnas no 21'),
(13, 'K003', 'kepala456', 'Takata Mashiho', 'kepala', 'mashiho25@gmail.com', '082731931797', 'jl ringroad utara'),
(14, 'ST006', 'staff123', 'Najla Huwaida', '', 'najlahwd@gmail.com', '086278331923', 'jl seturan no 54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporancacat`
--
ALTER TABLE `laporancacat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `laporannoncacat`
--
ALTER TABLE `laporannoncacat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `laporancacat`
--
ALTER TABLE `laporancacat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `laporannoncacat`
--
ALTER TABLE `laporannoncacat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `laporancacat`
--
ALTER TABLE `laporancacat`
  ADD CONSTRAINT `laporancacat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporannoncacat`
--
ALTER TABLE `laporannoncacat`
  ADD CONSTRAINT `laporannoncacat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
