-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2024 at 08:34 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sig_kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_kampus`
--

CREATE TABLE `tb_kampus` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `visi_misi` varchar(1000) NOT NULL,
  `prodi` varchar(200) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kampus`
--

INSERT INTO `tb_kampus` (`id`, `nama`, `alamat`, `visi_misi`, `prodi`, `foto`, `latitude`, `longitude`) VALUES
(10, 'UNIVERSITAS LAMAPPAPOLEONRO', 'Jl. Ksatria', 'Visi Universitas Lamappapoleonro\r\nMenjadi Perguruan Tinggi yang unggul dalam menghasilkan Sumber Daya Manusia Profesional dan berjiwa Enterpreneurship serta berwawasan global pada tahun 2031\r\n\r\n\r\nMisi Universitas Lamappapoleonro\r\n1. Menyelenggarakan Pendidikan secara kreatif dan inovatif dalam rangka pemutakhiran Ilmu Pengetahuan dengan dukungan sarana, prasarana, tenaga pendidik dan kependidikan yang memadai.\r\n2. Menyelenggarakan kegiatan penelitian secara kreatif dan inovatif untuk mengembangkan ilmu pengetahuan yang bermanfaat bagi kesejahteraan umat manusia.\r\n3. Menyelenggarakan kegiatan pemenuhan tanggung jawab sosial secara optimal melalui tindakan nyata berupa pelayanan dan pengabdian kepada masyarakat.\r\n4. Menyelenggarakan kerjasama dengan lembaga atau instansi lain untuk peningkatan kapasitas', '1. Program Studi Manajemen 2. Program Studi Teknik Informatika 3. Program Studi Sistem Informasi 4. Program Studi Akuntansi 5. Program Studi Teknik Sipil 6. Program Studi Pendidikan Guru Sekolah Dasar', 'WhatsApp Image 2023-11-27 at 20.52.21_94e3ee64.jpg', '-4.3540456', '119.878134');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `level` enum('admin','user') NOT NULL,
  `foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `nama`, `level`, `foto`) VALUES
(1, '123', '123', 'Akram', 'admin', 'Faisal.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_kampus`
--
ALTER TABLE `tb_kampus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_kampus`
--
ALTER TABLE `tb_kampus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
