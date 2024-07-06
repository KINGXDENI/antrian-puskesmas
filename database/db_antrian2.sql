-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2024 at 05:28 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_antrian2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nama` varchar(40) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `gambar` varchar(255) NOT NULL DEFAULT 'default.png',
  `theme` varchar(20) NOT NULL DEFAULT 'sb_admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `nama`, `status`, `gambar`, `theme`) VALUES
(2, 'admin@admin.com', 'admin', 'admin', 1, 'default.png', 'sb_admin');

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id_antrian` int(4) NOT NULL,
  `tgl_antrian` date NOT NULL,
  `no_antrian` varchar(10) NOT NULL,
  `jam` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `antrian_poli`
--

CREATE TABLE `antrian_poli` (
  `id_antrian_poli` int(4) NOT NULL,
  `id_antrian` int(4) NOT NULL,
  `id_pasien` int(4) NOT NULL,
  `id_poli` int(2) NOT NULL,
  `no_antrian_poli` varchar(10) NOT NULL,
  `tgl_antrian_poli` date NOT NULL,
  `jam` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dokter`
--

CREATE TABLE `dokter` (
  `id` int(11) NOT NULL,
  `id_poli` int(11) NOT NULL,
  `nama_dokter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dokter`
--

INSERT INTO `dokter` (`id`, `id_poli`, `nama_dokter`) VALUES
(1, 1, 'Dokter Umum'),
(2, 2, 'Dokter Gigi'),
(4, 3, 'Dokter Anak'),
(5, 4, 'Dokter Tubercolosis'),
(6, 5, 'Dokter Konseling'),
(7, 6, 'Dokter KIA'),
(8, 7, 'Dokter Gizi');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_poli`
--

CREATE TABLE `kategori_poli` (
  `id_poli` int(2) NOT NULL,
  `kode_poli` varchar(50) NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `jumlah_maksimal` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori_poli`
--

INSERT INTO `kategori_poli` (`id_poli`, `kode_poli`, `nama_poli`, `jumlah_maksimal`) VALUES
(1, 'Poli Umum', 'Poli Umum', '30'),
(2, 'Poli Gigi', 'Poli Gigi', '30'),
(3, 'Poli Anak', 'Poli Anak', '30'),
(4, 'Poli Tuberculosis', 'Poli Tuberculosis', '30'),
(5, 'Poli Konseling', 'Poli Konseling', '30'),
(6, 'Poli KIA', 'Poli KIA', '30'),
(7, 'Poli Gizi', 'Poli Gizi', '30');

-- --------------------------------------------------------

--
-- Table structure for table `pasien`
--

CREATE TABLE `pasien` (
  `id_pasien` int(4) NOT NULL,
  `no_identitas` varchar(25) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis_kelamin` varchar(255) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `alamat` text NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(35) NOT NULL,
  `pengguna_bpjs` varchar(255) DEFAULT NULL,
  `no_bpjs` varchar(255) DEFAULT NULL,
  `jenis_pendaftaran` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tjm_menu`
--

CREATE TABLE `tjm_menu` (
  `id` int(11) NOT NULL,
  `parent_menu` int(11) NOT NULL DEFAULT 1,
  `nama_menu` varchar(50) NOT NULL,
  `url_menu` varchar(50) NOT NULL,
  `icon` varchar(50) NOT NULL,
  `urutan` tinyint(3) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `type` enum('Admin') NOT NULL DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tjm_menu`
--

INSERT INTO `tjm_menu` (`id`, `parent_menu`, `nama_menu`, `url_menu`, `icon`, `urutan`, `status`, `type`) VALUES
(1, 1, 'root', '/', '', 0, 0, 'Admin'),
(2, 1, 'dashboard', 'admin/dashboard', 'fa fa-fw fa-dashboard', 1, 1, 'Admin'),
(3, 1, 'User Admin', 'admin/useradmin', 'fa fa-users', 99, 0, 'Admin'),
(4, 1, 'Menu', 'admin/menu', 'fa fa-gear', 100, 1, 'Admin'),
(25, 1, 'Master', 'admin/master', 'fa fa-ticket', 2, 0, 'Admin'),
(31, 1, 'Data Pasien', 'admin/pasien', 'glyphicon glyphicon-user', 2, 1, 'Admin'),
(32, 1, 'Poli', 'admin/poli', 'glyphicon glyphicon-list-alt', 3, 1, 'Admin'),
(34, 1, 'Dokter', 'admin/dokter', 'glyphicon glyphicon-list', 5, 1, 'Admin'),
(35, 1, 'Laporan Semua Poli', 'admin/LaporanPoliUmum', 'glyphicon glyphicon-list', 5, 1, 'Admin'),
(36, 1, 'List Antrian', 'admin/Antrian_poli', 'glyphicon glyphicon-list', 7, 1, 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id_antrian`);

--
-- Indexes for table `antrian_poli`
--
ALTER TABLE `antrian_poli`
  ADD PRIMARY KEY (`id_antrian_poli`);

--
-- Indexes for table `dokter`
--
ALTER TABLE `dokter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_poli`
--
ALTER TABLE `kategori_poli`
  ADD PRIMARY KEY (`id_poli`);

--
-- Indexes for table `pasien`
--
ALTER TABLE `pasien`
  ADD PRIMARY KEY (`id_pasien`);

--
-- Indexes for table `tjm_menu`
--
ALTER TABLE `tjm_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id_antrian` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `antrian_poli`
--
ALTER TABLE `antrian_poli`
  MODIFY `id_antrian_poli` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `dokter`
--
ALTER TABLE `dokter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kategori_poli`
--
ALTER TABLE `kategori_poli`
  MODIFY `id_poli` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pasien`
--
ALTER TABLE `pasien`
  MODIFY `id_pasien` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `tjm_menu`
--
ALTER TABLE `tjm_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
