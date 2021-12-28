-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2020 at 04:29 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `satu`
--

-- --------------------------------------------------------

--
-- Table structure for table `ckp`
--

CREATE TABLE IF NOT EXISTS `ckp` (
  `id_ckp` int(10) NOT NULL,
  `date` int(2) DEFAULT NULL,
  `id_pegawai` int(11) NOT NULL,
  `id_tugas` int(10) DEFAULT NULL,
  `satuan` text,
  `target` int(4) DEFAULT NULL,
  `realisasi` int(4) DEFAULT NULL,
  `kualitas` decimal(3,0) DEFAULT NULL,
  `kd_butir` varchar(5) DEFAULT NULL,
  `angka_kredit` varchar(5) DEFAULT NULL,
  `keterangan` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL,
  `satker` text NOT NULL,
  `kodesatker` varchar(4) NOT NULL,
  `alamat` text NOT NULL,
  `alamatlengkap` text NOT NULL,
  `kabupaten` text NOT NULL,
  `provinsi` text NOT NULL,
  `transport` int(11) NOT NULL,
  `uangharian` text NOT NULL,
  `ppk` text NOT NULL,
  `ip_mesinabsen` text NOT NULL,
  `is_plh` int(11) NOT NULL,
  `plh_kepala` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `satker`, `kodesatker`, `alamat`, `alamatlengkap`, `kabupaten`, `provinsi`, `transport`, `uangharian`, `ppk`, `ip_mesinabsen`, `is_plh`, `plh_kepala`) VALUES
(1, 'BPS Kabupaten Jeneponto', '7304', 'Jeneponto', 'Jl Sultan Hasanuddin', 'Kabupaten Jeneponto', 'Sulawesi Selatan', 150000, '170000,430000', '4', '10.173.17.121', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE IF NOT EXISTS `holiday` (
  `hari` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `id` int(11) NOT NULL,
  `keterangan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ijincuti`
--

CREATE TABLE IF NOT EXISTS `ijincuti` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `iscuti` int(11) NOT NULL,
  `keperluan` text,
  `alamat` text NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `tanggal_surat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE IF NOT EXISTS `jabatan` (
  `id_jabatan` int(2) NOT NULL,
  `jabatan` text NOT NULL,
  `kode_seksi` varchar(5) NOT NULL,
  `id_seksi` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jabatan`
--

INSERT INTO `jabatan` (`id_jabatan`, `jabatan`, `kode_seksi`, `id_seksi`) VALUES
(1, 'admin', '73040', 0),
(2, 'Kepala Kantor', '73040', 0),
(3, 'Kepala Sub Bagian Tata Usaha', '73041', 0),
(4, 'Kepala Seksi IPDS', '73046', 0),
(5, 'Staf Seksi IPDS', '73046', 0),
(6, 'Kepala Seksi Statistik Produksi ', '73043', 0),
(7, 'Staf Seksi Statistik Produksi', '73043', 0),
(8, 'Bendahara Pengeluaran', '73041', 0),
(9, 'Bendahara Penerimaan', '73041', 0),
(10, 'Kepala Seksi Neraca Wilayah dan Analisis Statistik', '73045', 0),
(11, 'Staf Seksi Neraca Wilayah dan Analisis Statistik', '73045', 0),
(12, 'Kepala Seksi Statistik Distribusi', '73044', 0),
(13, 'Staf Seksi Statistik Distribusi', '73044', 0),
(14, 'Kepala Seksi Statistik Sosial', '73042', 0),
(15, 'Staf Seksi Statistik Sosial', '73042', 0),
(16, 'KSK Binamu', '73040', 0),
(17, 'KSK Bangkala', '73040', 0),
(18, 'KSK Sumalata', '73040', 0),
(19, 'KSK Sumalata Timur', '73040', 0),
(20, 'KSK Tolinggula', '73040', 0),
(21, 'Staf Sub Bagian Tata Usaha', '73041', 0),
(22, 'Koordinator Seksi IPDS', '73046', 0),
(23, 'Koordinator Seksi Neraca Wilayah dan Analisis Statistik', '73045', 0);

-- --------------------------------------------------------

--
-- Table structure for table `memo`
--

CREATE TABLE IF NOT EXISTS `memo` (
  `id` int(11) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `keperluan` text NOT NULL,
  `id_seksi` tinyint(1) NOT NULL,
  `jam_keluar` datetime DEFAULT NULL,
  `jam_pulang` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE IF NOT EXISTS `pegawai` (
  `id` int(11) NOT NULL,
  `nip` text NOT NULL,
  `nip_lama` text NOT NULL,
  `nama` text NOT NULL,
  `id_jabatan` int(2) NOT NULL,
  `pangkat` text NOT NULL,
  `golongan` text NOT NULL,
  `is_motordinas` tinyint(1) NOT NULL,
  `username` varchar(50) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `is_plh` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nip_lama`, `nama`, `id_jabatan`, `pangkat`, `golongan`, `is_motordinas`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `created_at`, `updated_at`, `is_plh`) VALUES
(1, '0', '', 'admin', 1, 'admin', 'admin', 0, 'admin', 'QBy4pNNZct2lNtjc57mVtc6hrD1mpnoq', '$2y$13$qXMhFNLHvZkh6NuUZta2q.8iQIhE8WPwE5j7POcHBqdNAHgPjrrza', '', 0, 1579058509, 0),
(3, '111', '111', 'kepala BPS', 2, 'Pembina Tk1', 'IV/b', 1, 'kepala', '0d8E5iHelCZ3zqpctgEzO8vUnZvIivWZ', '$2y$13$nQfD8uMkvC95U2kow1oEA.CAE4qmU3aZKeleAM6mBg2vcVvA5SMpC', '', 1495724432, 1503069978, 0),
(4, '222', '222', 'Ranmi HIjriati Asri', 4, 'Penata', 'III/c', 1, 'rahmi', '2X2WZFyBEWjrNk4VPmC3wMhFEtm8h0Xq', '$2y$13$Yl3FS18nSAN.WHV5nj6lceprut.lQcZiu5YSIJ0Boo/QSiCwXbW5O', '', 1495727157, 1578970174, 0),
(5, '333', '33333', 'bendaharapengeluaran', 8, 'Penata Muda', 'III/a', 1, 'bendaharapengeluaran', '-HNcIAHA8-KYQl6LU1GllfHEiREAzO44', '$2y$13$ccKUh3WBxFvOZ7JNON/cxuz9eJoQ0QDbz9dKqbIQBTviZajWm7ppy', '', 1495727268, 1503070063, 0),
(26, '197810222006041003', '18155', 'Andi Cakra Atmajaya', 3, 'Penata', 'III/c', 1, 'Cakra', 'dDorOE9gUWpxZ36UIwaXWAod53caoeTG', '$2y$13$6TofhEjfp/BwKdNLfRmAP.5AkvH5/DYQrPKL3TOhRZjuPqmixZD/2', '', 1578992722, 1578992722, 0);

-- --------------------------------------------------------

--
-- Table structure for table `seksi`
--

CREATE TABLE IF NOT EXISTS `seksi` (
  `id` tinyint(1) NOT NULL,
  `seksi` text NOT NULL,
  `kode` varchar(5) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seksi`
--

INSERT INTO `seksi` (`id`, `seksi`, `kode`) VALUES
(1, 'Integrasi Pengolahan dan Diseminasi Statistik (IPDS)', '73046'),
(2, 'Neraca Wilayah dan Analisis Statistik', '73045'),
(3, 'Statistik Produksi', '73043'),
(4, 'Tata Usaha', '73041'),
(5, 'Statistik Sosial', '73042'),
(6, 'Statistik Distribusi', '73044'),
(7, 'Umum', '73040');

-- --------------------------------------------------------

--
-- Table structure for table `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `id` int(2) NOT NULL,
  `nama_shift` text NOT NULL,
  `hari1` text NOT NULL,
  `hari2` text NOT NULL,
  `hari3` text NOT NULL,
  `hari4` text NOT NULL,
  `hari5` text NOT NULL,
  `hari6` text NOT NULL,
  `hari0` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shift`
--

INSERT INTO `shift` (`id`, `nama_shift`, `hari1`, `hari2`, `hari3`, `hari4`, `hari5`, `hari6`, `hari0`) VALUES
(1, 'Regular', '07:30-16:00', '07:30-16:00', '07:30-16:00', '07:30-16:00', '07:30-16:30', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tugas`
--

CREATE TABLE IF NOT EXISTS `tugas` (
  `id` int(10) NOT NULL,
  `id_pegawai` int(11) NOT NULL,
  `suratdasar` text NOT NULL,
  `nosurat` text NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `kegiatan` text NOT NULL,
  `destinasi` text NOT NULL,
  `assignee` tinyint(1) NOT NULL,
  `created_date` date NOT NULL,
  `sppd` tinyint(1) NOT NULL DEFAULT '0',
  `is_luar_kota` tinyint(4) NOT NULL,
  `id_group` int(11) NOT NULL DEFAULT '0',
  `blok_absen` int(11) NOT NULL,
  `ckp` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ckp`
--
ALTER TABLE `ckp`
  ADD PRIMARY KEY (`id_ckp`), ADD KEY `id_pegawai` (`id_pegawai`), ADD KEY `id_tugas` (`id_tugas`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ijincuti`
--
ALTER TABLE `ijincuti`
  ADD PRIMARY KEY (`id`), ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id_jabatan`), ADD KEY `id_jabatan_2` (`id_jabatan`), ADD KEY `id_jabatan_3` (`id_jabatan`), ADD KEY `id_jabatan_4` (`id_jabatan`), ADD KEY `kode_seksi` (`kode_seksi`);

--
-- Indexes for table `memo`
--
ALTER TABLE `memo`
  ADD PRIMARY KEY (`id`), ADD KEY `id_pegawai` (`id_pegawai`), ADD KEY `id_kasi` (`id_seksi`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `seksi`
--
ALTER TABLE `seksi`
  ADD PRIMARY KEY (`id`), ADD KEY `kode` (`kode`);

--
-- Indexes for table `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas`
--
ALTER TABLE `tugas`
  ADD PRIMARY KEY (`id`), ADD KEY `id_pegawai` (`id_pegawai`), ADD KEY `assignee` (`assignee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ckp`
--
ALTER TABLE `ckp`
  MODIFY `id_ckp` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ijincuti`
--
ALTER TABLE `ijincuti`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id_jabatan` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `memo`
--
ALTER TABLE `memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `seksi`
--
ALTER TABLE `seksi`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `shift`
--
ALTER TABLE `shift`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tugas`
--
ALTER TABLE `tugas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `ckp`
--
ALTER TABLE `ckp`
ADD CONSTRAINT `ckp_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `jabatan`
--
ALTER TABLE `jabatan`
ADD CONSTRAINT `jabatan_ibfk_1` FOREIGN KEY (`kode_seksi`) REFERENCES `seksi` (`kode`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
