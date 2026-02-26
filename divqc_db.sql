-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Feb 2026 pada 09.47
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `laporancacat`
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
-- Dumping data untuk tabel `laporancacat`
--

INSERT INTO `laporancacat` (`id`, `id_user`, `batch_number`, `jenis_udang`, `tanggal`, `kuantitas`, `kriteria_cacat`, `keparahan`, `deskripsi`, `kategori`, `status`, `catatan_kepala`, `created_at`) VALUES
(1, 3, 'BTC-2025-001', 'Udang Vaname', '2025-05-25', 15, 'Kulit Lunak', 'Ringan', 'Ditemukan beberapa udang dengan kulit yang belum keras sempurna.', 'cacat', 'ditolak', NULL, '2026-02-26 01:58:09'),
(2, 4, 'BTC-2025-002', 'Udang Windu', '2025-05-25', 45, 'Perubahan Warna', 'Berat', 'Warna udang kemerahan pucat, indikasi suhu penyimpanan tidak stabil.', 'cacat', 'menunggu', NULL, '2026-02-26 01:58:09'),
(3, 3, 'BTC-2025-003', 'Udang Vaname', '2025-05-25', 28, 'Rusak Fisik', 'Sedang', 'Ekor dan kaki banyak yang patah saat proses sortir mesin.', 'cacat', 'diterima', 'maap ditolak tp boonk', '2026-02-26 01:58:09'),
(4, 5, 'BTC-2025-004', 'Udang Windu', '2025-05-25', 8, 'Ukuran Tidak Seragam', 'Ringan', 'Hanya sedikit variasi ukuran, masih dalam batas toleransi.', 'cacat', 'diterima', 'terima deh', '2026-02-26 01:58:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporannoncacat`
--

CREATE TABLE `laporannoncacat` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `batch_number` varchar(50) NOT NULL,
  `jenis_udang` varchar(50) NOT NULL,
  `tanggal` date NOT NULL,
  `kuantitas` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporannoncacat`
--

INSERT INTO `laporannoncacat` (`id`, `id_user`, `batch_number`, `jenis_udang`, `tanggal`, `kuantitas`, `deskripsi`, `created_at`) VALUES
(1, 3, 'BTC-NC-001', 'Udang Vaname', '2025-05-25', 5000, 'Kualitas panen sangat prima, ukuran seragam size 30.', '2026-02-26 02:02:23'),
(2, 4, 'BTC-NC-002', 'Udang Windu', '2025-05-24', 2500, 'Warna cerah, tekstur daging padat. Lulus uji organoleptik.', '2026-02-26 02:02:23'),
(3, 5, 'BTC-NC-003', 'Udang Vaname', '2025-05-26', 4000, 'Terdapat sedikit bau lumpur pada sampel.', '2026-02-26 02:02:23'),
(4, 3, 'BTC-NC-004', 'Udang Windu', '2025-05-25', 1500, 'Kondisi fresh, langsung masuk cold storage.', '2026-02-26 02:02:23');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
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
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nip`, `password`, `nama_lengkap`, `jabatan`, `email`, `no_telp`, `alamat`) VALUES
(1, 'A001', 'admin123', 'Admin Utama', 'admin', 'admin1@misajamitra.com', '08120000001', 'Jl. Merdeka No. 1, Jakarta'),
(2, 'A002', 'admin123', 'Admin Support', 'admin', 'admin2@misajamitra.com', '08120000002', 'Jl. Sudirman No. 45, Jakarta'),
(3, 'ST001', 'staff123', 'Andi Saputra', 'staff', 'andi.st@misajamitra.com', '08210000001', 'Jl. Kebon Jeruk No. 10'),
(4, 'ST002', 'staff123', 'Budi Santoso', 'staff', 'budi.st@misajamitra.com', '08210000002', 'Jl. Mangga Besar No. 22'),
(5, 'ST003', 'staff123', 'Citra Lestari', 'staff', 'citra.st@misajamitra.com', '08210000003', 'Jl. Anggrek Rosliana No. 5'),
(6, 'ST004', 'staff123', 'Dedi Mulyadi', 'staff', 'dedi.st@misajamitra.com', '08210000004', 'Jl. Melati Putih No. 8'),
(7, 'ST005', 'staff123', 'Eka Pratiwi', 'staff', 'eka.st@misajamitra.com', '08210000005', 'Jl. Mawar Merah No. 12'),
(8, 'K001', 'kepala123', 'Fajar Hidayat', 'kepala', 'fajar.k@misajamitra.com', '08110000001', 'Jl. Diponegoro No. 100, Menteng'),
(9, 'M001', 'manajer123', 'Gilang Pratama', 'manajer', 'gilang.m@misajamitra.com', '08150000001', 'Jl. Thamrin Boulevard No. 88'),
(10, 'SP001', 'spv123', 'Hartono', 'supervisor', 'hartono.sp@misajamitra.com', '08160000001', 'Jl. Gatot Subroto Kav. 5');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `laporancacat`
--
ALTER TABLE `laporancacat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `laporannoncacat`
--
ALTER TABLE `laporannoncacat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `laporancacat`
--
ALTER TABLE `laporancacat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `laporannoncacat`
--
ALTER TABLE `laporannoncacat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `laporancacat`
--
ALTER TABLE `laporancacat`
  ADD CONSTRAINT `laporancacat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporannoncacat`
--
ALTER TABLE `laporannoncacat`
  ADD CONSTRAINT `laporannoncacat_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
