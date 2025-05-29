-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Bulan Mei 2025 pada 17.17
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
-- Database: `sepedalistrik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artikel`
--

CREATE TABLE `artikel` (
  `id` int(3) NOT NULL,
  `Judul` varchar(1000) NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `isi_artikel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artikel`
--

INSERT INTO `artikel` (`id`, `Judul`, `gambar`, `isi_artikel`) VALUES
(17, 'kjljhlkhjlkjhll;l\';', 'logo unmer.png', 'dgnhngngh');

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_diagnosa`
--

CREATE TABLE `hasil_diagnosa` (
  `id` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `kontak` varchar(20) NOT NULL,
  `id_kerusakan` varchar(11) NOT NULL,
  `jawaban` text NOT NULL,
  `solusi` text NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `hasil_diagnosa`
--

INSERT INTO `hasil_diagnosa` (`id`, `nama_user`, `kontak`, `id_kerusakan`, `jawaban`, `solusi`, `tanggal`) VALUES
(4, 'ahmad', '242314', 'K1', '', '', '2025-05-23 00:07:42'),
(5, 'ahmad', '1321356', 'K1', '', '', '2025-05-29 12:41:51'),
(6, 'jhkh', 'jkhh', 'K1', '[]', 'sadasda', '2025-05-29 13:11:50'),
(7, 'jhkh', 'jkhh', 'K1', '{}', 'sadasda', '2025-05-29 13:21:22'),
(8, 'jhkh', 'jkhh', 'K1', '{}', 'sadasda', '2025-05-29 13:23:03'),
(9, 'jhkh', 'jkhh', 'K1', '{\"P1\":\"Tidak\"}', 'Seeprtinya sepeda anda memiliki kerusakan bagian lain', '2025-05-29 14:34:14'),
(10, 'dasda', '214', 'K2', '{\"P2\":\"Tidak\"}', 'iop', '2025-05-29 17:10:43'),
(11, 'dasda', '214', 'K4', '{\"P4\":\"Ya\"}', 'Maaf, sistem belum memiliki data diagnosa untuk kerusakan ini. Silakan hubungi teknisi.', '2025-05-29 17:15:36'),
(12, 'dasda', '214', 'K1', '{\"P1\":\"Tidak\"}', 'beli lagi', '2025-05-29 22:16:55'),
(13, 'dasda', '214', 'K1', '{\"P1\":\"Ya\"}', 'P6', '2025-05-29 22:17:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kerusakan`
--

CREATE TABLE `kerusakan` (
  `id` varchar(11) NOT NULL,
  `nama_kerusakan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kerusakan`
--

INSERT INTO `kerusakan` (`id`, `nama_kerusakan`) VALUES
('K1', 'Baterai Rusak'),
('K10', 'Motor tidak tersuplai listrik '),
('K11', 'Regulator daya rusak '),
('K2', 'Motor rusak'),
('K3', 'Kabel putus atau longgar '),
('K4', 'Aliran listrik terhambat '),
('K5', 'Komponen mekanik aus '),
('K6', 'Baterai tidak menyuplai daya '),
('K7', 'Koneksi baterai buruk '),
('K8', 'Gangguan aliran listrik'),
('K9', 'Baterai aus ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id` varchar(11) NOT NULL,
  `id_kerusakan` varchar(11) NOT NULL,
  `teks_pertanyaan` text NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pertanyaan`
--

INSERT INTO `pertanyaan` (`id`, `id_kerusakan`, `teks_pertanyaan`, `urutan`) VALUES
('P1', 'K1', 'Apakah Sepeda tidak nyata ?', 1),
('P2', 'K2', 'Apakah tidak sepeda tidak berjalan?', 2),
('P3', 'K3', 'Apakah lampu indikator tidak bisa menyala', 1),
('P4', 'K4', 'Apakah sepeda mati mendadak saat digunakan ', 1),
('P5', 'K5', 'apakah komponen mekanik aus?', 1),
('P6', 'K1', 'Apakah sepeda hancur', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `solusi`
--

CREATE TABLE `solusi` (
  `id` int(11) NOT NULL,
  `id_pertanyaan` varchar(11) NOT NULL,
  `jawaban` enum('Ya','Tidak') NOT NULL,
  `solusi` text NOT NULL,
  `langkah_selanjutnya` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `solusi`
--

INSERT INTO `solusi` (`id`, `id_pertanyaan`, `jawaban`, `solusi`, `langkah_selanjutnya`) VALUES
(3, 'P5', 'Ya', 'hubungi teknisi', NULL),
(4, 'P2', 'Ya', 'tyu', NULL),
(5, 'P2', 'Tidak', 'iop', NULL),
(6, 'P6', 'Ya', 'Beli Lagi', NULL),
(7, 'P1', 'Ya', 'P6', 2),
(8, 'P1', 'Tidak', 'beli lagi', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `useradmin`
--

CREATE TABLE `useradmin` (
  `id` int(4) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `useradmin`
--

INSERT INTO `useradmin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kerusakan` (`id_kerusakan`);

--
-- Indeks untuk tabel `kerusakan`
--
ALTER TABLE `kerusakan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kerusakan` (`id_kerusakan`);

--
-- Indeks untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`);

--
-- Indeks untuk tabel `useradmin`
--
ALTER TABLE `useradmin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `solusi`
--
ALTER TABLE `solusi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `useradmin`
--
ALTER TABLE `useradmin`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `hasil_diagnosa`
--
ALTER TABLE `hasil_diagnosa`
  ADD CONSTRAINT `hasil_diagnosa_ibfk_1` FOREIGN KEY (`id_kerusakan`) REFERENCES `kerusakan` (`id`);

--
-- Ketidakleluasaan untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `pertanyaan_ibfk_1` FOREIGN KEY (`id_kerusakan`) REFERENCES `kerusakan` (`id`);

--
-- Ketidakleluasaan untuk tabel `solusi`
--
ALTER TABLE `solusi`
  ADD CONSTRAINT `solusi_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
