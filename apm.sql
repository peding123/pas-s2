-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2023 at 02:02 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apm`
--

-- --------------------------------------------------------

--
-- Table structure for table `masyarakat`
--

CREATE TABLE `masyarakat` (
  `nik` char(16) NOT NULL,
  `nama` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `telp` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masyarakat`
--

INSERT INTO `masyarakat` (`nik`, `nama`, `username`, `password`, `telp`) VALUES
('4121014550799550', 'Mohamad Ferdiansyah', 'ferdi', '1f2ef40e3ad6fa16b08b615217876b8a', '083851522259'),
('7448114331171120', 'Rafli Yusuf Aldani', 'rafli', '79ece3a5487d0945cd1cd28a2b483c84', '082260591451');

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `id_modul` int(11) NOT NULL,
  `nama_modul` varchar(50) NOT NULL,
  `link` varchar(100) NOT NULL,
  `static_content` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `publish` enum('Y','N') NOT NULL,
  `status` enum('Petugas','Admin') NOT NULL,
  `aktif` enum('Y','N') NOT NULL,
  `urutan` int(8) NOT NULL,
  `link_seo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`id_modul`, `nama_modul`, `link`, `static_content`, `gambar`, `publish`, `status`, `aktif`, `urutan`, `link_seo`) VALUES
(1, 'User', '?module=datauser', 'Hello', '', 'Y', 'Admin', 'Y', 3, ''),
(2, 'Petugas', '?module=datapetugas', 'Hello', '', 'Y', 'Admin', 'Y', 5, ''),
(3, 'Home', '?module=home', 'Hello', '', 'Y', 'Petugas', 'Y', 2, ''),
(4, 'Pengaduan', '?module=pengaduan', 'Hello', '', 'Y', 'Petugas', 'Y', 6, ''),
(5, 'Tanggapan', '?module=tanggapan', 'Hello', '', 'Y', 'Petugas', 'Y', 7, ''),
(6, 'Berita', '?module=berita', 'Hello', '', 'Y', 'Petugas', 'Y', 9, ''),
(7, 'Masyarakat', '?module=datamasyarakat', 'Hello', '', 'Y', 'Admin', 'Y', 4, ''),
(8, 'Menu', '?module=menu', 'Hello', '', 'Y', 'Petugas', 'Y', 8, ''),
(9, 'Dashboard', '?module=dashboard', 'Hello', '', 'Y', 'Admin', 'Y', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id_pengaduan` int(11) NOT NULL,
  `tgl_pengaduan` date NOT NULL,
  `nik` char(16) NOT NULL,
  `isi_laporan` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `status` enum('0','proses','selesai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id_petugas` int(11) NOT NULL,
  `nama_petugas` varchar(35) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(32) NOT NULL,
  `telp` varchar(13) NOT NULL,
  `level` enum('Admin','Petugas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id_petugas`, `nama_petugas`, `username`, `password`, `telp`, `level`) VALUES
(1, 'Mohamad Ferdiansyah', 'admin', '0192023a7bbd73250516f069df18b500', '083851522259', 'Admin'),
(2, 'Maftuh Romadhon', 'maftuh', '6ad14ba9986e3615423dfca256d04e3f', '088296142969', 'Petugas'),
(4, 'Angga Duwi Priyatna', 'angga123', '1fd5cd9766249f170035b7251e2c6b61', '085714798183', 'Petugas'),
(12, 'Wildan Satya Nugrahadi', 'wildan', 'af6b3aa8c3fcd651674359f500814679', '0895385909547', 'Petugas');

-- --------------------------------------------------------

--
-- Table structure for table `tanggapan`
--

CREATE TABLE `tanggapan` (
  `id_tanggapan` int(11) NOT NULL,
  `id_pengaduan` int(11) NOT NULL,
  `tgl_tanggapan` date NOT NULL,
  `tanggapan` text NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `masyarakat`
--
ALTER TABLE `masyarakat`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`id_modul`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id_pengaduan`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id_petugas`);

--
-- Indexes for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD PRIMARY KEY (`id_tanggapan`),
  ADD KEY `id_pengaduan` (`id_pengaduan`,`id_petugas`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `id_modul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id_pengaduan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id_petugas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tanggapan`
--
ALTER TABLE `tanggapan`
  MODIFY `id_tanggapan` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`nik`) REFERENCES `masyarakat` (`nik`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tanggapan`
--
ALTER TABLE `tanggapan`
  ADD CONSTRAINT `tanggapan_ibfk_1` FOREIGN KEY (`id_pengaduan`) REFERENCES `pengaduan` (`id_pengaduan`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tanggapan_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `petugas` (`id_petugas`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
