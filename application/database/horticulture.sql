-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 09, 2018 at 08:19 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `horticulture`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(10) UNSIGNED NOT NULL,
  `nama_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_device`
--

CREATE TABLE `tb_device` (
  `id_device` int(10) UNSIGNED NOT NULL,
  `nomor_seri` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` int(5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_device`
--

INSERT INTO `tb_device` (`id_device`, `nomor_seri`, `keterangan`, `tahun`, `created_at`, `updated_at`) VALUES
(4, 12345, 'dua', 2018, NULL, NULL),
(5, 12345, 'dua', 2018, NULL, NULL),
(6, 1231, 'tiga', 2019, '2018-07-08 15:05:02', '2018-07-08 15:05:02'),
(7, 123451231, 'empat', 2012, '2018-07-08 15:07:38', '2018-07-08 15:07:38'),
(8, 12141, 'lima', 123142, '2018-07-08 15:11:40', '2018-07-08 15:11:40'),
(9, 14151, 'enem', 2019, '2018-07-08 15:12:26', '2018-07-08 15:12:26'),
(10, 876869, 'jjhlkj', 696876, '2018-07-08 15:12:54', '2018-07-08 15:12:54'),
(11, 86876, 'agskfakf', 5657, '2018-07-08 15:13:57', '2018-07-08 15:13:57'),
(12, 578587, 'kjahfa', 576576, '2018-07-08 15:15:19', '2018-07-08 15:15:19'),
(13, 123, 'jklasflhkla', 6575875, '2018-07-08 15:21:51', '2018-07-08 15:21:51'),
(14, 79879687, 'hasjkhfkas', 5675747, '2018-07-08 15:22:53', '2018-07-08 15:22:53'),
(15, 1237, 'alksflafanvmjkgsajkv', 124361, '2018-07-08 15:24:01', '2018-07-08 15:24:01'),
(16, 86896, 'ahskfhalfj;lasjflkav', 57658, '2018-07-08 15:24:49', '2018-07-08 15:24:49'),
(17, 1421, 'kaisfiahf', 14151, '2018-07-08 15:26:13', '2018-07-08 15:26:13'),
(18, 6868587, 'askjfalkgflav', 98798, '2018-07-08 15:27:19', '2018-07-08 15:27:19'),
(19, 12314, 'asfagafadfwa', 141441, '2018-07-08 15:28:08', '2018-07-08 15:28:08'),
(20, 1997, 'jaran', 1997, '2018-07-08 15:39:51', '2018-07-08 16:07:48'),
(21, 21314, 'hjahsfdafj', 1778, '2018-07-08 16:08:58', '2018-07-08 16:08:58');

-- --------------------------------------------------------

--
-- Table structure for table `tb_lahan`
--

CREATE TABLE `tb_lahan` (
  `id_lahan` int(10) UNSIGNED NOT NULL,
  `id_tanaman` int(10) UNSIGNED NOT NULL,
  `id_petani` int(10) UNSIGNED NOT NULL,
  `id_device` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_lahan`
--

INSERT INTO `tb_lahan` (`id_lahan`, `id_tanaman`, `id_petani`, `id_device`, `created_at`, `updated_at`) VALUES
(1, 10, 11, 4, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_petani`
--

CREATE TABLE `tb_petani` (
  `id_petani` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `nama_petani` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_petani`
--

INSERT INTO `tb_petani` (`id_petani`, `id_user`, `nama_petani`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(11, 17, 'admin', 'admin', '099709', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_status_lahan`
--

CREATE TABLE `tb_status_lahan` (
  `id_status_lahan` int(10) UNSIGNED NOT NULL,
  `id_lahan` int(10) UNSIGNED NOT NULL,
  `cahaya` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelembaban` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nutrisi` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `suhu` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tangki air` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `air_tanah` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_status_lahan`
--

INSERT INTO `tb_status_lahan` (`id_status_lahan`, `id_lahan`, `cahaya`, `kelembaban`, `nutrisi`, `suhu`, `tangki air`, `air_tanah`, `created_at`, `updated_at`) VALUES
(1, 1, '10', '20', '20', '20', '29', '12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tanaman`
--

CREATE TABLE `tb_tanaman` (
  `id_tanaman` int(10) UNSIGNED NOT NULL,
  `nama_tanaman` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tgl_tanam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `usia_tanaman` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_tanaman`
--

INSERT INTO `tb_tanaman` (`id_tanaman`, `nama_tanaman`, `tgl_tanam`, `usia_tanaman`, `created_at`, `updated_at`) VALUES
(10, 'bawang', '2018-07-12 07:00:00', '28', '2018-07-09 13:12:46', '2018-07-09 13:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(2) NOT NULL COMMENT '0=petani, 1=admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `email`, `password`, `level`, `remember_token`, `created_at`, `updated_at`) VALUES
(17, 'admin@local.host', '$2y$10$lICR2f.HRQ0Q0y5E9R/QCuxZrbDD0ROC8jS.y.mKHsE2apacmd4Ny', 1, NULL, '2018-07-02 01:28:30', '2018-07-02 01:28:30'),
(26, 'jaja@mjkj.aca', '$2y$10$MLXOydGTP6ofVsl2prTntOCDhCDJlfZ9SAHBy/I0dL2poSBcAAKm6', 0, NULL, '2018-07-09 12:33:17', '2018-07-09 12:33:17');

-- --------------------------------------------------------

--
-- Table structure for table `users11`
--

CREATE TABLE `users11` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL,
  `email` int(11) NOT NULL,
  `pass` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `tb_device`
--
ALTER TABLE `tb_device`
  ADD PRIMARY KEY (`id_device`),
  ADD KEY `id_device` (`id_device`);

--
-- Indexes for table `tb_lahan`
--
ALTER TABLE `tb_lahan`
  ADD PRIMARY KEY (`id_lahan`),
  ADD KEY `id_tanaman` (`id_tanaman`,`id_device`) USING BTREE,
  ADD KEY `id_device` (`id_device`),
  ADD KEY `id_petani` (`id_petani`);

--
-- Indexes for table `tb_petani`
--
ALTER TABLE `tb_petani`
  ADD PRIMARY KEY (`id_petani`),
  ADD UNIQUE KEY `id_petani_2` (`id_petani`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `tb_petani_id_user_index` (`id_user`) USING BTREE,
  ADD KEY `id_petani` (`id_petani`);

--
-- Indexes for table `tb_status_lahan`
--
ALTER TABLE `tb_status_lahan`
  ADD PRIMARY KEY (`id_status_lahan`),
  ADD KEY `id_lahan` (`id_lahan`);

--
-- Indexes for table `tb_tanaman`
--
ALTER TABLE `tb_tanaman`
  ADD PRIMARY KEY (`id_tanaman`),
  ADD KEY `id_tanaman` (`id_tanaman`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_device`
--
ALTER TABLE `tb_device`
  MODIFY `id_device` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_lahan`
--
ALTER TABLE `tb_lahan`
  MODIFY `id_lahan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_petani`
--
ALTER TABLE `tb_petani`
  MODIFY `id_petani` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_status_lahan`
--
ALTER TABLE `tb_status_lahan`
  MODIFY `id_status_lahan` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_tanaman`
--
ALTER TABLE `tb_tanaman`
  MODIFY `id_tanaman` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD CONSTRAINT `tb_admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`);

--
-- Constraints for table `tb_lahan`
--
ALTER TABLE `tb_lahan`
  ADD CONSTRAINT `tb_lahan_ibfk_1` FOREIGN KEY (`id_tanaman`) REFERENCES `tb_tanaman` (`id_tanaman`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_lahan_ibfk_2` FOREIGN KEY (`id_device`) REFERENCES `tb_device` (`id_device`),
  ADD CONSTRAINT `tb_lahan_ibfk_3` FOREIGN KEY (`id_petani`) REFERENCES `tb_petani` (`id_petani`);

--
-- Constraints for table `tb_petani`
--
ALTER TABLE `tb_petani`
  ADD CONSTRAINT `tb_petani_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_status_lahan`
--
ALTER TABLE `tb_status_lahan`
  ADD CONSTRAINT `tb_status_lahan_ibfk_1` FOREIGN KEY (`id_lahan`) REFERENCES `tb_lahan` (`id_lahan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
