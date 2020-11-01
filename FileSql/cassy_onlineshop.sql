-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2020 at 06:11 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cassy_onlineshop`
--
CREATE DATABASE IF NOT EXISTS `cassy_onlineshop` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `cassy_onlineshop`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins` (
  `id_admin` int(11) NOT NULL,
  `nama_admin` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` text NOT NULL,
  `no_hp` text NOT NULL,
  `level` int(11) NOT NULL,
  `last_login` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `d_baju`
--

DROP TABLE IF EXISTS `d_baju`;
CREATE TABLE `d_baju` (
  `ID_HBAJU` varchar(10) NOT NULL,
  `NAMA_BAJU` varchar(50) NOT NULL,
  `WARNA` text NOT NULL,
  `UKURAN` int(11) NOT NULL,
  `STOK` int(11) NOT NULL,
  `ID_KATEGORI` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `d_jual`
--

DROP TABLE IF EXISTS `d_jual`;
CREATE TABLE `d_jual` (
  `id_hjual` varchar(10) NOT NULL,
  `id_barang` varchar(10) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_baju`
--

DROP TABLE IF EXISTS `h_baju`;
CREATE TABLE `h_baju` (
  `ID_HBAJU` varchar(10) NOT NULL,
  `NAMA_BAJU` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` text NOT NULL,
  `time_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_jual`
--

DROP TABLE IF EXISTS `h_jual`;
CREATE TABLE `h_jual` (
  `id_hjual` varchar(10) NOT NULL,
  `tgl_jual` date NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
CREATE TABLE `kategori` (
  `ID_KATEGORI` int(11) NOT NULL,
  `NAMA_KATEGORI` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`ID_KATEGORI`, `NAMA_KATEGORI`) VALUES
(1, 'Man T-Shirt'),
(2, 'Woman T-Shirt'),
(3, 'Man Jacket & Sweater'),
(4, 'Woman Jacket & Sweater');

-- --------------------------------------------------------

--
-- Table structure for table `konfrimasi_email`
--

DROP TABLE IF EXISTS `konfrimasi_email`;
CREATE TABLE `konfrimasi_email` (
  `id_user` varchar(10) NOT NULL,
  `code_verify` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mutasi_stok`
--

DROP TABLE IF EXISTS `mutasi_stok`;
CREATE TABLE `mutasi_stok` (
  `id_hbaju` varchar(10) NOT NULL,
  `aktivitas` varchar(20) NOT NULL,
  `tgl_log` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `jumlah` int(11) NOT NULL,
  `sisa_stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

DROP TABLE IF EXISTS `pengaduan`;
CREATE TABLE `pengaduan` (
  `id_user` varchar(10) NOT NULL,
  `status_pesan` int(1) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_pengaduan` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `promo`
--

DROP TABLE IF EXISTS `promo`;
CREATE TABLE `promo` (
  `id_hbaju` varchar(10) NOT NULL,
  `diskon_persen` int(11) NOT NULL,
  `tgl_mulai` timestamp NULL DEFAULT NULL,
  `tgl_berakhir` timestamp NULL DEFAULT NULL,
  `max_diskon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` varchar(10) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text NOT NULL,
  `jk` varchar(1) NOT NULL,
  `no_telp` bigint(20) NOT NULL,
  `status` varchar(8) NOT NULL,
  `jabatan` varchar(20) NOT NULL,
  `Registered_Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Last_Login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama_user`, `username`, `email`, `password`, `alamat`, `jk`, `no_telp`, `status`, `jabatan`, `Registered_Date`, `Last_Login`) VALUES
('IS_001', 'Ignatius Steven Go', 'Gogo', 'steven@gmail.com', '$2y$10$/bFIXtTx2JAvW4UdMimlGuSv.d9yRkV4mAfOBCZNFjtNexeb1yMxy', 'Ketintang', 'L', 421586532, 'Aktif', 'Member', '2020-10-25 13:48:05', NULL),
('MT_001', 'Melvern Tamara', 'melvern', 'melvern.tamara88@gmail.com', '$2y$10$OcMx5aD5gQvBAU8h1/wMn.WbSYJ63p73KpaDzNvbd9q8FJtVqYrnq', 'Manyar jaya 7 no 9', 'L', 628510080888, 'Aktif', 'Member', '2020-10-25 12:41:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `d_baju`
--
ALTER TABLE `d_baju`
  ADD PRIMARY KEY (`ID_HBAJU`);

--
-- Indexes for table `d_jual`
--
ALTER TABLE `d_jual`
  ADD PRIMARY KEY (`id_hjual`);

--
-- Indexes for table `h_baju`
--
ALTER TABLE `h_baju`
  ADD PRIMARY KEY (`ID_HBAJU`);

--
-- Indexes for table `h_jual`
--
ALTER TABLE `h_jual`
  ADD PRIMARY KEY (`id_hjual`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`ID_KATEGORI`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `ID_KATEGORI` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
