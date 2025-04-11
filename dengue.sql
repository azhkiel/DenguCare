-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2025 at 02:48 PM
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
-- Database: `dengue`
--

-- --------------------------------------------------------

--
-- Table structure for table `daerah_rawan`
--

CREATE TABLE `daerah_rawan` (
  `id` int(11) NOT NULL,
  `nama_daerah` varchar(255) NOT NULL,
  `tingkat_risiko` enum('Rendah','Sedang','Tinggi') NOT NULL,
  `jumlah_kasus` int(11) NOT NULL DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daerah_rawan`
--

INSERT INTO `daerah_rawan` (`id`, `nama_daerah`, `tingkat_risiko`, `jumlah_kasus`, `keterangan`, `dibuat_pada`) VALUES
(1, 'Surabaya Utara', 'Tinggi', 150, 'Banyak kasus DBD dalam 3 bulan terakhir', '2025-03-26 17:22:27'),
(2, 'Surabaya Selatan', 'Sedang', 75, 'Kasus masih terkendali', '2025-03-26 17:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `edukasi`
--

CREATE TABLE `edukasi` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `tipe` enum('Video','Artikel') NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edukasi`
--

INSERT INTO `edukasi` (`id`, `judul`, `isi`, `tipe`, `dibuat_pada`) VALUES
(1, 'Cara Mencegah DBD', 'Gunakan kelambu dan bersihkan genangan air.', 'Artikel', '2025-03-26 17:22:27'),
(2, 'Video Pencegahan DBD', 'Link ke video edukasi', 'Video', '2025-03-26 17:22:27');

-- --------------------------------------------------------

--
-- Table structure for table `event_warga`
--

CREATE TABLE `event_warga` (
  `id` int(11) NOT NULL,
  `id_warga` int(11) DEFAULT NULL,
  `id_event` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) NOT NULL,
  `topik` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kader`
--

CREATE TABLE `kader` (
  `id` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rt_id` int(11) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kader`
--

INSERT INTO `kader` (`id`, `nama_lengkap`, `telepon`, `password`, `rt_id`, `dibuat_pada`) VALUES
(3, 'Budi Santoso', '08123456789', 'password123', 24, '2025-03-26 17:29:15'),
(4, 'Siti Aminah', '08234567890', 'password456', 24, '2025-03-26 17:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id`, `nama_kecamatan`) VALUES
(1, 'Asemrowo'),
(2, 'Benowo'),
(3, 'Bubutan'),
(4, 'Bulak'),
(5, 'Dukuh Pakis'),
(6, 'Gayungan'),
(7, 'Genteng'),
(8, 'Gubeng'),
(9, 'Gunung Anyar'),
(10, 'Jambangan'),
(11, 'Karang Pilang'),
(12, 'Kenjeran'),
(13, 'Krembangan'),
(14, 'Lakarsantri'),
(15, 'Mulyorejo'),
(16, 'Pabean Cantikan'),
(17, 'Pakal'),
(18, 'Rungkut'),
(19, 'Sambikerep'),
(20, 'Sawahan'),
(21, 'Semampir'),
(22, 'Simokerto'),
(23, 'Sukolilo'),
(24, 'Sukomanunggal'),
(25, 'Tambaksari'),
(26, 'Tandes'),
(27, 'Tegalsari'),
(28, 'Tenggilis Mejoyo'),
(29, 'Wiyung'),
(30, 'Wonocolo'),
(31, 'Wonokromo');

-- --------------------------------------------------------

--
-- Table structure for table `keluhan_harian`
--

CREATE TABLE `keluhan_harian` (
  `id` int(11) NOT NULL,
  `id_warga` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `suhu` varchar(10) DEFAULT NULL,
  `ruam` varchar(20) DEFAULT NULL,
  `nyeri_otot` tinyint(1) DEFAULT NULL,
  `mual` tinyint(1) DEFAULT NULL,
  `nyeri_belakang_mata` tinyint(1) DEFAULT NULL,
  `pendarahan` tinyint(1) DEFAULT NULL,
  `gejala_lain` text DEFAULT NULL,
  `akurasi_dbd` float DEFAULT NULL,
  `anjuran` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id` int(11) NOT NULL,
  `kecamatan_id` int(11) NOT NULL,
  `nama_kelurahan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id`, `kecamatan_id`, `nama_kelurahan`) VALUES
(1, 1, 'Asemrowo'),
(2, 1, 'Genting Kalianak'),
(3, 1, 'Tambak Sarioso'),
(4, 2, 'Kandangan'),
(5, 2, 'Romokalisari'),
(6, 2, 'Sememi'),
(7, 2, 'Tambak Oso Wilangun'),
(8, 3, 'Alun-alun Contong'),
(9, 3, 'Bubutan'),
(10, 3, 'Gundih'),
(11, 3, 'Jepara'),
(12, 3, 'Tembok Dukuh'),
(13, 4, 'Bulak'),
(14, 4, 'Kedung Cowek'),
(15, 4, 'Kenjeran'),
(16, 4, 'Sukolilo Baru'),
(17, 5, 'Dukuh Kupang'),
(18, 5, 'Dukuh Pakis'),
(19, 5, 'Gunung Sari'),
(20, 5, 'Pradah Kalikendal'),
(21, 6, 'Dukuh Menanggal'),
(22, 6, 'Gayungan'),
(23, 7, 'Embong Kaliasin'),
(24, 7, 'Genteng'),
(25, 7, 'Kapasari'),
(26, 7, 'Ketabang'),
(27, 7, 'Peneleh'),
(28, 8, 'Airlangga'),
(29, 8, 'Baratajaya'),
(30, 8, 'Gubeng'),
(31, 8, 'Kertajaya'),
(32, 8, 'Mojo'),
(33, 8, 'Pucang Sewu'),
(34, 9, 'Gunung Anyar'),
(35, 9, 'Gunung Anyar Tambak'),
(36, 9, 'Rungkut Menanggal'),
(37, 9, 'Rungkut Tengah'),
(38, 10, 'Jambangan'),
(39, 10, 'Karah'),
(40, 10, 'Kebonsari'),
(41, 10, 'Pagesangan'),
(43, 11, 'Karang Pilang'),
(42, 11, 'Kebraon'),
(44, 11, 'Waru Gunung'),
(45, 12, 'Bulak Banteng'),
(46, 12, 'Sidotopo Wetan'),
(47, 12, 'Tambak Wedi'),
(48, 12, 'Tanah Kali Kedinding'),
(49, 13, 'Dupak'),
(50, 13, 'Krembangan Selatan'),
(51, 13, 'Krembangan Utara'),
(52, 13, 'Morokrembangan'),
(53, 13, 'Perak Barat'),
(54, 13, 'Perak Timur'),
(55, 14, 'Bangkingan'),
(56, 14, 'Jeruk'),
(57, 14, 'Lakarsantri'),
(58, 14, 'Lidah Kulon'),
(59, 14, 'Lidah Wetan'),
(60, 14, 'Sumur Welut'),
(61, 15, 'Dukuh Sutorejo'),
(62, 15, 'Kalijudan'),
(63, 15, 'Kalisari'),
(64, 15, 'Kejawan Putih Tambak'),
(65, 15, 'Manyar Sabrangan'),
(66, 15, 'Mulyorejo'),
(67, 16, 'Bongkaran'),
(68, 16, 'Krembangan Selatan'),
(69, 16, 'Nyamplungan'),
(70, 16, 'Perak Barat'),
(71, 16, 'Perak Timur'),
(72, 17, 'Babat Jerawat'),
(73, 17, 'Benowo'),
(74, 17, 'Pakal'),
(75, 17, 'Sumber Rejo'),
(76, 18, 'Kali Rungkut'),
(77, 18, 'Kebonagung'),
(78, 18, 'Medokan Ayu'),
(79, 18, 'Penjaringansari'),
(80, 18, 'Rungkut Kidul'),
(81, 18, 'Wonorejo'),
(82, 19, 'Beringin'),
(83, 19, 'Lontar'),
(84, 19, 'Made'),
(85, 19, 'Sambikerep'),
(86, 20, 'Banyu Urip'),
(88, 20, 'Kupang Gunung'),
(87, 20, 'Kupang Krajan'),
(89, 20, 'Pakis'),
(90, 20, 'Patemon'),
(91, 20, 'Petemon'),
(92, 20, 'Putat Jaya'),
(93, 20, 'Sawahan'),
(94, 21, 'Ampel'),
(95, 21, 'Pegirian'),
(96, 21, 'Sidotopo'),
(97, 21, 'Ujung'),
(98, 21, 'Wonokusumo'),
(99, 22, 'Kapasan'),
(100, 22, 'Sidodadi'),
(101, 22, 'Simokerto'),
(102, 22, 'Simolawang'),
(103, 22, 'Tambakrejo'),
(104, 23, 'Gebang Putih'),
(105, 23, 'Keputih'),
(106, 23, 'Klampis Ngasem'),
(107, 23, 'Medokan Semampir'),
(108, 23, 'Menur Pumpungan'),
(109, 23, 'Nginden Jangkungan'),
(110, 23, 'Semolowaru'),
(111, 24, 'Dukuh Setro'),
(112, 24, 'Gading'),
(113, 24, 'Kapasan'),
(114, 24, 'Kenjeran'),
(115, 24, 'Pacarkeling'),
(116, 24, 'Pacarkembang'),
(117, 24, 'Ploso'),
(118, 24, 'Rangkah'),
(119, 24, 'Sidotopo'),
(120, 24, 'Tambaksari'),
(121, 25, 'Balongsari'),
(122, 25, 'Banjar Sugihan'),
(123, 25, 'Karang Poh'),
(124, 25, 'Manukan Kulon'),
(125, 25, 'Manukan Wetan'),
(126, 25, 'Tandes'),
(127, 26, 'Dr. Soetomo'),
(128, 26, 'Kedungdoro'),
(129, 26, 'Keputran'),
(130, 26, 'Tegalsari'),
(131, 26, 'Wonorejo'),
(132, 27, 'Kendangsari'),
(133, 27, 'Kutisari'),
(134, 27, 'Margorejo'),
(135, 27, 'Tenggilis Mejoyo'),
(136, 28, 'Babatan'),
(137, 28, 'Balas Klumprik'),
(138, 28, 'Jajar Tunggal'),
(139, 28, 'Wiyung'),
(140, 29, 'Bendul Merisi'),
(141, 29, 'Jagir'),
(142, 29, 'Sidosermo'),
(143, 29, 'Wonocolo'),
(144, 30, 'Darmo'),
(145, 30, 'Jagir'),
(146, 30, 'Ngagel'),
(147, 30, 'Ngagelrejo'),
(148, 30, 'Sawunggaling'),
(149, 30, 'Wonokromo'),
(150, 31, 'Gunung Anyar'),
(151, 31, 'Gunung Anyar Tambak'),
(152, 31, 'Kali Rungkut'),
(153, 31, 'Kedung Baruk'),
(154, 31, 'Medokan Ayu'),
(155, 31, 'Penjaringansari'),
(156, 31, 'Rungkut Kidul'),
(157, 31, 'Wonorejo');

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) NOT NULL,
  `daerah_id` int(11) NOT NULL,
  `jenis_laporan` enum('Jentik Nyamuk','Kasus DBD','Lingkungan Kotor') NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Pending','Terverifikasi','Selesai') DEFAULT 'Pending',
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `list_event`
--

CREATE TABLE `list_event` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(100) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `biaya` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `list_event`
--

INSERT INTO `list_event` (`id`, `nama_event`, `tanggal`, `lokasi`, `waktu`, `biaya`) VALUES
(1, 'Seminar DBD Internasional 2025', '2025-11-02', 'Online - Zoom Meeting', '08:00 - Selesai', 'Gratis'),
(2, 'Sosialisasi Pencegahan DBD 2025', '2025-11-05', 'Balai RW 03, Surabaya', '09:00 - 11:00', 'Gratis'),
(3, 'Seminar DBD Kec.Gn. Anyar', '2025-11-07', 'Kecamatan Gunung Anyar', '10:00 - 12:00', 'Gratis'),
(4, 'Seminar Pencegahan DBD', '2025-05-15', 'RSUD Dr. Soetomo, Surabaya', '09:00', 'Gratis'),
(5, 'Workshop Fogging Mandiri', '2025-06-01', 'Puskesmas Wonokromo, Surabaya', '08:30', '50000'),
(6, 'Kampanye Bersih Lingkungan', '2025-05-20', 'Lapangan THOR, Surabaya', '07:00', 'Gratis'),
(7, 'Pemeriksaan Darah Gratis', '2025-06-10', 'Klinik Sehat Rungkut, Surabaya', '10:00', 'Gratis'),
(8, 'Pelatihan Kader Jumantik', '2025-06-15', 'Balai RW Ketintang, Surabaya', '13:00', '30000'),
(9, 'Penyuluhan Bahaya DBD', '2025-05-25', 'SDN Wonokromo 1, Surabaya', '09:00', 'Gratis'),
(10, 'Lomba Poster Anti DBD', '2025-07-05', 'Gelanggang Remaja Surabaya', '08:00', '20000'),
(11, 'Aksi Fogging Massal', '2025-06-20', 'Perumahan Darmo Indah, Surabaya', '06:30', 'Gratis'),
(12, 'Bakti Sosial Lawan DBD', '2025-07-10', 'Kelurahan Rungkut Menanggal, Surabaya', '07:30', 'Gratis'),
(13, 'Webinar DBD Nasional', '2025-06-25', 'Online (diadakan oleh Dinkes Surabaya)', '19:00', 'Gratis'),
(14, 'Pelatihan Penanganan Pasien DBD', '2025-07-15', 'RS Royal Surabaya', '08:00', '75000'),
(15, 'Gerakan 3M Plus', '2025-08-01', 'Taman Bungkul Surabaya', '07:00', 'Gratis');

-- --------------------------------------------------------

--
-- Table structure for table `panduan`
--

CREATE TABLE `panduan` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `panduan`
--

INSERT INTO `panduan` (`id`, `judul`, `isi`, `dibuat_pada`) VALUES
(1, 'Langkah Pencegahan DBD', 'Bersihkan lingkungan dan gunakan anti nyamuk.', '2025-03-26 17:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) NOT NULL,
  `daerah_id` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Pending','Terverifikasi','Selesai') DEFAULT 'Pending',
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rt`
--

CREATE TABLE `rt` (
  `id` int(11) NOT NULL,
  `rw_id` int(11) NOT NULL,
  `kelurahan_id` int(11) NOT NULL,
  `nomor_rt` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rt`
--

INSERT INTO `rt` (`id`, `rw_id`, `kelurahan_id`, `nomor_rt`) VALUES
(24, 3, 1, '01'),
(25, 3, 1, '02'),
(26, 3, 1, '03'),
(27, 3, 1, '04'),
(19, 1, 2, '01'),
(20, 1, 2, '02'),
(21, 1, 2, '03'),
(22, 2, 2, '01'),
(23, 2, 2, '02'),
(28, 10, 3, '01'),
(29, 10, 3, '02'),
(33, 11, 3, '01'),
(34, 11, 3, '02'),
(35, 11, 3, '03'),
(30, 12, 3, '01'),
(31, 12, 3, '02'),
(32, 12, 3, '03');

-- --------------------------------------------------------

--
-- Table structure for table `rw`
--

CREATE TABLE `rw` (
  `id` int(11) NOT NULL,
  `kelurahan_id` int(11) NOT NULL,
  `nomor_rw` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rw`
--

INSERT INTO `rw` (`id`, `kelurahan_id`, `nomor_rw`) VALUES
(1, 1, '01'),
(2, 1, '02'),
(3, 1, '03'),
(10, 2, '01'),
(11, 2, '02'),
(12, 3, '01');

-- --------------------------------------------------------

--
-- Table structure for table `survei`
--

CREATE TABLE `survei` (
  `id` int(11) NOT NULL,
  `kader_id` int(11) NOT NULL,
  `daerah_id` int(11) NOT NULL,
  `temuan` text NOT NULL,
  `status` enum('Selesai','Belum Selesai') DEFAULT 'Belum Selesai',
  `tanggal_survei` date NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `survei`
--

INSERT INTO `survei` (`id`, `kader_id`, `daerah_id`, `temuan`, `status`, `tanggal_survei`, `dibuat_pada`) VALUES
(2, 3, 1, 'Ditemukan jentik nyamuk di 3 lokasi', 'Belum Selesai', '2024-03-25', '2025-03-26 17:30:33');

-- --------------------------------------------------------

--
-- Table structure for table `tracking`
--

CREATE TABLE `tracking` (
  `id` int(11) NOT NULL,
  `warga_id` int(11) NOT NULL,
  `status_kesehatan` enum('Sehat','Gejala Ringan','Terkena DBD') NOT NULL,
  `status_lingkungan` enum('Bersih','Kurang Bersih','Kotor') NOT NULL,
  `tanggal_pantau` date NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `warga`
--

CREATE TABLE `warga` (
  `id` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `tempat_lahir` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat_lengkap` text NOT NULL,
  `rt_id` int(11) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_ktp` varchar(255) NOT NULL,
  `foto_diri_ktp` varchar(255) NOT NULL,
  `dibuat_pada` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_rt` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `warga`
--

INSERT INTO `warga` (`id`, `nik`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `alamat_lengkap`, `rt_id`, `telepon`, `password`, `foto_ktp`, `foto_diri_ktp`, `dibuat_pada`, `id_rt`) VALUES
(1, '4088261992937', 'Linsayri', 'Surabaya', '2020-06-09', 'Perempuan', 'Jl. kulienr', 19, '0895395149770', '$2y$10$Hc5wEXpeRjUU54R2Yrh4OO0sp31TAg0r7rcMY3ZJCPdpR/9mJzpwu', 'ktp_67f4e3e7da18b.jpeg', 'diri_67f4e3e7da6b8.jpeg', '2025-04-08 08:52:55', NULL),
(2, '4088261992994', 'Lisa Dwi Anggraini', 'Surabaya', '2004-07-07', 'Perempuan', 'JL. Medokan Sawah Baru no.37', 22, '0895395149771', '$2y$10$Cx3KJYOqjhA.sQbJC8BQn.a0G6AhsMD.wB3WWEu3UumI5YCVqKuuK', 'ktp_67f679d8c71f7.jpg', 'diri_67f679d8c7777.png', '2025-04-09 13:44:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daerah_rawan`
--
ALTER TABLE `daerah_rawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edukasi`
--
ALTER TABLE `edukasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_warga`
--
ALTER TABLE `event_warga`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_warga` (`id_warga`),
  ADD KEY `id_event` (`id_event`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warga_id` (`warga_id`);

--
-- Indexes for table `kader`
--
ALTER TABLE `kader`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rt_id` (`rt_id`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kecamatan` (`nama_kecamatan`);

--
-- Indexes for table `keluhan_harian`
--
ALTER TABLE `keluhan_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_warga` (`id_warga`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kecamatan_id` (`kecamatan_id`,`nama_kelurahan`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warga_id` (`warga_id`),
  ADD KEY `daerah_id` (`daerah_id`);

--
-- Indexes for table `list_event`
--
ALTER TABLE `list_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `panduan`
--
ALTER TABLE `panduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warga_id` (`warga_id`),
  ADD KEY `daerah_id` (`daerah_id`);

--
-- Indexes for table `rt`
--
ALTER TABLE `rt`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelurahan_id` (`kelurahan_id`,`rw_id`,`nomor_rt`),
  ADD KEY `rw_id` (`rw_id`);

--
-- Indexes for table `rw`
--
ALTER TABLE `rw`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kelurahan_id` (`kelurahan_id`,`nomor_rw`);

--
-- Indexes for table `survei`
--
ALTER TABLE `survei`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kader_id` (`kader_id`),
  ADD KEY `daerah_id` (`daerah_id`);

--
-- Indexes for table `tracking`
--
ALTER TABLE `tracking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warga_id` (`warga_id`);

--
-- Indexes for table `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `rt_id` (`rt_id`),
  ADD KEY `fk_warga_rt` (`id_rt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daerah_rawan`
--
ALTER TABLE `daerah_rawan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `edukasi`
--
ALTER TABLE `edukasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `event_warga`
--
ALTER TABLE `event_warga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kader`
--
ALTER TABLE `kader`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `kecamatan`
--
ALTER TABLE `kecamatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `keluhan_harian`
--
ALTER TABLE `keluhan_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kelurahan`
--
ALTER TABLE `kelurahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `list_event`
--
ALTER TABLE `list_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `panduan`
--
ALTER TABLE `panduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rt`
--
ALTER TABLE `rt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `rw`
--
ALTER TABLE `rw`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `survei`
--
ALTER TABLE `survei`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tracking`
--
ALTER TABLE `tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `warga`
--
ALTER TABLE `warga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_warga`
--
ALTER TABLE `event_warga`
  ADD CONSTRAINT `event_warga_ibfk_1` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id`),
  ADD CONSTRAINT `event_warga_ibfk_2` FOREIGN KEY (`id_event`) REFERENCES `list_event` (`id`);

--
-- Constraints for table `forum`
--
ALTER TABLE `forum`
  ADD CONSTRAINT `forum_ibfk_1` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kader`
--
ALTER TABLE `kader`
  ADD CONSTRAINT `kader_ibfk_1` FOREIGN KEY (`rt_id`) REFERENCES `rt` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `keluhan_harian`
--
ALTER TABLE `keluhan_harian`
  ADD CONSTRAINT `keluhan_harian_ibfk_1` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id`);

--
-- Constraints for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`kecamatan_id`) REFERENCES `kecamatan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `laporan_ibfk_1` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `laporan_ibfk_2` FOREIGN KEY (`daerah_id`) REFERENCES `daerah_rawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`daerah_id`) REFERENCES `daerah_rawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rt`
--
ALTER TABLE `rt`
  ADD CONSTRAINT `rt_ibfk_1` FOREIGN KEY (`rw_id`) REFERENCES `rw` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rt_ibfk_2` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rw`
--
ALTER TABLE `rw`
  ADD CONSTRAINT `rw_ibfk_1` FOREIGN KEY (`kelurahan_id`) REFERENCES `kelurahan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `survei`
--
ALTER TABLE `survei`
  ADD CONSTRAINT `survei_ibfk_1` FOREIGN KEY (`kader_id`) REFERENCES `kader` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `survei_ibfk_2` FOREIGN KEY (`daerah_id`) REFERENCES `daerah_rawan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracking`
--
ALTER TABLE `tracking`
  ADD CONSTRAINT `tracking_ibfk_1` FOREIGN KEY (`warga_id`) REFERENCES `warga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `fk_warga_rt` FOREIGN KEY (`id_rt`) REFERENCES `rt` (`id`),
  ADD CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`rt_id`) REFERENCES `rt` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
