-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2021 at 12:20 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skm_formkerjasama`
--

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_authority`
--

CREATE TABLE `formkerjasama_authority` (
  `idAdmin` int(11) NOT NULL,
  `V_email` varchar(64) NOT NULL,
  `N_statusAdmin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formkerjasama_authority`
--

INSERT INTO `formkerjasama_authority` (`idAdmin`, `V_email`, `N_statusAdmin`) VALUES
(1, '2017730022@student.unpar.ac.id', 0);

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_benefit_campushiring`
--

CREATE TABLE `formkerjasama_benefit_campushiring` (
  `idBenefit` int(11) NOT NULL,
  `idPerusahaan` int(11) NOT NULL,
  `V_jurusanTerlibat` text NOT NULL,
  `V_linkMateri` varchar(512) DEFAULT NULL,
  `V_tglPelaksaan` date NOT NULL,
  `N_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_benefit_companybranding`
--

CREATE TABLE `formkerjasama_benefit_companybranding` (
  `idBenefit` int(11) NOT NULL,
  `idPerusahaan` int(11) NOT NULL,
  `V_jurusanTerlibat` text NOT NULL,
  `V_linkMateri` varchar(512) DEFAULT NULL,
  `V_tglPelaksaan` date NOT NULL,
  `N_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_benefit_datawisuda`
--

CREATE TABLE `formkerjasama_benefit_datawisuda` (
  `idBenefit` int(11) NOT NULL,
  `idPerusahaan` int(11) NOT NULL,
  `V_jurusanTerlibat` text NOT NULL,
  `V_tglPelaksaan` date NOT NULL,
  `N_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_benefit_vjf`
--

CREATE TABLE `formkerjasama_benefit_vjf` (
  `idBenefit` int(11) NOT NULL,
  `idPerusahaan` int(11) NOT NULL,
  `V_tglPelaksaan` date NOT NULL,
  `N_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_jurusan`
--

CREATE TABLE `formkerjasama_jurusan` (
  `idJurusan` int(11) NOT NULL,
  `V_namaJurusan` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formkerjasama_jurusan`
--

INSERT INTO `formkerjasama_jurusan` (`idJurusan`, `V_namaJurusan`) VALUES
(1, 'D3 Manajemen Perusahaan'),
(2, 'Ekonomi Pembangunan'),
(3, 'Manajemen'),
(4, 'Akuntansi'),
(5, 'Ilmu Hukum'),
(6, 'Ilmu Administrasi Publik'),
(7, 'Ilmu Administrasi Bisnis'),
(8, 'Ilmu Hubungan Internasional'),
(9, 'Teknik Sipil'),
(10, 'Teknik Arsitektur'),
(11, 'Ilmu Filsafat'),
(12, 'Teknik Kimia'),
(13, 'Teknik Elektro (Mekatronika)'),
(14, 'Matematika'),
(15, 'Fisika'),
(16, 'Teknik Informatika'),
(17, 'Magister Manajemen'),
(18, 'Magister Ilmu Hukum'),
(19, 'Magister Teknik Sipil'),
(20, 'Magister Arsitektur'),
(21, 'Magister Hubungan Internasional'),
(22, 'Magister Administrasi bisnis'),
(23, 'Magister Ilmu Sosial'),
(24, 'Magister Teknik Industri'),
(25, 'Magister Teknik Kimia');

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_log`
--

CREATE TABLE `formkerjasama_log` (
  `V_log` varchar(1024) NOT NULL,
  `T_waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formkerjasama_log`
--

INSERT INTO `formkerjasama_log` (`V_log`, `T_waktu`) VALUES
(' () Mengupload bukti pembayaran perusahaan dengan nama Basic _Bukti Pembayaran', '2021-04-20 07:02:04'),
(' () Mengupdate data perusahaan dengan nama Basic ', '2021-04-20 07:02:04'),
(' () Mengupload bukti pembayaran perusahaan dengan nama Bronze_Bukti Pembayaran', '2021-04-20 07:37:08'),
(' () Mengupdate data perusahaan dengan nama Bronze', '2021-04-20 07:37:08'),
(' () Mengupload bukti pembayaran perusahaan dengan nama Silver_Bukti Pembayaran', '2021-04-20 07:37:22'),
(' () Mengupdate data perusahaan dengan nama Silver', '2021-04-20 07:37:22'),
(' () Mengupload bukti pembayaran perusahaan dengan nama Goldie_Bukti Pembayaran', '2021-04-20 07:37:34'),
(' () Mengupdate data perusahaan dengan nama Goldie', '2021-04-20 07:37:34'),
(' () Mengupload bukti pembayaran perusahaan dengan nama Platinums_Bukti Pembayaran', '2021-04-20 07:37:46'),
(' () Mengupdate data perusahaan dengan nama Platinums', '2021-04-20 07:37:46'),
(' () Mengupdate data perusahaan dengan nama Basic ', '2021-04-20 08:07:53'),
('2017730022@student.unpar.ac.id (superadmin) Mengupdate data perusahaan dengan nama Basic ', '2021-04-26 06:23:05');

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_perusahaan_dt`
--

CREATE TABLE `formkerjasama_perusahaan_dt` (
  `idPerusahaan` int(11) NOT NULL,
  `V_namaPerusahaan` varchar(512) DEFAULT NULL,
  `V_paket` varchar(64) NOT NULL,
  `V_logoPerusahaan` varchar(512) DEFAULT NULL,
  `V_bidangUsaha` varchar(512) DEFAULT NULL,
  `V_alamatPerusahaan` varchar(512) DEFAULT NULL,
  `V_kontakPerusahaan` varchar(64) DEFAULT NULL,
  `V_websitePerusahaan` varchar(512) DEFAULT NULL,
  `V_jumlahKaryawan` int(11) DEFAULT NULL,
  `V_jumlahLulusanUnpar` varchar(32) DEFAULT NULL,
  `V_namaPic` varchar(128) DEFAULT NULL,
  `V_emailPic` varchar(256) DEFAULT NULL,
  `V_noTelpPic` varchar(64) DEFAULT NULL,
  `V_masaBerlaku` date DEFAULT NULL,
  `V_masaSelesai` date DEFAULT NULL,
  `V_buktiPembayaran` varchar(512) DEFAULT NULL,
  `V_mouNo` varchar(512) DEFAULT NULL,
  `V_mou` varchar(512) DEFAULT NULL,
  `N_status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formkerjasama_perusahaan_dt`
--

INSERT INTO `formkerjasama_perusahaan_dt` (`idPerusahaan`, `V_namaPerusahaan`, `V_paket`, `V_logoPerusahaan`, `V_bidangUsaha`, `V_alamatPerusahaan`, `V_kontakPerusahaan`, `V_websitePerusahaan`, `V_jumlahKaryawan`, `V_jumlahLulusanUnpar`, `V_namaPic`, `V_emailPic`, `V_noTelpPic`, `V_masaBerlaku`, `V_masaSelesai`, `V_buktiPembayaran`, `V_mouNo`, `V_mou`, `N_status`) VALUES
(48, 'Basic ', 'basic', 'Basic__logo.png', 'Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya', 'basic', '123123123', 'www.google.com', 123, '1-25', 'basic', 'kelvin.drv@gmail.com', '12312321321', '2021-04-19', '2020-04-19', 'Basic__Bukti_Pembayaran.jpg', 'III/2021/MOU', NULL, 0),
(49, 'Bronze', 'bronze', 'Bronze_logo.png', 'Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya', 'Jl Marga Asri II A-14', '1231231321', 'test.com', 123, '26-50', 'wer', 'kelvin.drv@gmail.com', '12312321321', '2021-04-21', '2022-04-20', 'Bronze_Bukti_Pembayaran.jpg', 'III/2021/MOU', NULL, 0),
(50, 'Silver', 'silver', 'Silver_logo.png', 'Kerohanian', 'Jl Marga Asri II A-14', '1231231321', 'honda.co.id', 123, '26-50', 'wer', 'kelvin.drv@gmail.com', '12312321321', '2021-04-20', '2022-04-20', 'Silver_Bukti_Pembayaran.jpg', 'III/2021/MOU', NULL, 0),
(51, 'Goldie', 'gold', 'Goldie_logo.jpg', 'Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga', 'Jl Marga Asri II A-14', '1231231321', 'honda.co.id', 123, '26-50', 'change', 'kelvin.drv@gmail.com', '43214321', '2021-04-20', '2022-04-20', 'Goldie_Bukti_Pembayaran.jpg', 'III/2021/MOU', NULL, 0),
(52, 'Platinums', 'platinum', 'Platinums_logo.jpg', 'Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga', 'Jl Marga Asri II A-14', '1231231321', 'test.com', 123, '1-25', 'wer', 'kelvin.drv@gmail.com', '12312321321', '2021-04-20', '2022-04-20', 'Platinums_Bukti_Pembayaran.jpg', 'III/2021/MOU', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_publikasi`
--

CREATE TABLE `formkerjasama_publikasi` (
  `idPublikasi` int(11) NOT NULL,
  `idPerusahaan` int(11) NOT NULL,
  `V_judul` varchar(512) NOT NULL,
  `V_tglMulai` date NOT NULL,
  `V_tglSelesai` date NOT NULL,
  `V_arsipMateri` varchar(512) NOT NULL,
  `N_website` int(11) DEFAULT NULL,
  `N_medsos` int(11) DEFAULT NULL,
  `N_bem` int(11) DEFAULT NULL,
  `N_fakulUnpar` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formkerjasama_statusbenefit`
--

CREATE TABLE `formkerjasama_statusbenefit` (
  `idPerusahaan` int(11) NOT NULL,
  `V_website` varchar(32) NOT NULL,
  `V_medsos` varchar(32) NOT NULL,
  `V_bem` varchar(32) NOT NULL,
  `V_fakulUnpar` varchar(32) NOT NULL,
  `V_campusHiring` varchar(32) NOT NULL,
  `V_companyBranding` varchar(32) NOT NULL,
  `V_vjf` varchar(32) NOT NULL,
  `V_dataWisuda` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `formkerjasama_statusbenefit`
--

INSERT INTO `formkerjasama_statusbenefit` (`idPerusahaan`, `V_website`, `V_medsos`, `V_bem`, `V_fakulUnpar`, `V_campusHiring`, `V_companyBranding`, `V_vjf`, `V_dataWisuda`) VALUES
(48, '1', '-', '-', '-', '-', '-', '-', '-'),
(49, '3', '3', '-', '-', '1', '1', '-', '-'),
(50, '6', '6', '3', '3', '2', '2', '-', '-'),
(51, '10', '10', '6', '6', '3', '3', '1', '1'),
(52, 'Unlimited', 'Unlimited', 'Unlimited', 'Unlimited', '4', '4', '2', '2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `formkerjasama_authority`
--
ALTER TABLE `formkerjasama_authority`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indexes for table `formkerjasama_benefit_campushiring`
--
ALTER TABLE `formkerjasama_benefit_campushiring`
  ADD PRIMARY KEY (`idBenefit`),
  ADD KEY `idPerusahaan` (`idPerusahaan`);

--
-- Indexes for table `formkerjasama_benefit_companybranding`
--
ALTER TABLE `formkerjasama_benefit_companybranding`
  ADD PRIMARY KEY (`idBenefit`),
  ADD KEY `idPerusahaan` (`idPerusahaan`);

--
-- Indexes for table `formkerjasama_benefit_datawisuda`
--
ALTER TABLE `formkerjasama_benefit_datawisuda`
  ADD PRIMARY KEY (`idBenefit`),
  ADD KEY `idPerusahaan` (`idPerusahaan`);

--
-- Indexes for table `formkerjasama_benefit_vjf`
--
ALTER TABLE `formkerjasama_benefit_vjf`
  ADD PRIMARY KEY (`idBenefit`),
  ADD KEY `idPerusahaan` (`idPerusahaan`);

--
-- Indexes for table `formkerjasama_jurusan`
--
ALTER TABLE `formkerjasama_jurusan`
  ADD PRIMARY KEY (`idJurusan`);

--
-- Indexes for table `formkerjasama_perusahaan_dt`
--
ALTER TABLE `formkerjasama_perusahaan_dt`
  ADD PRIMARY KEY (`idPerusahaan`);

--
-- Indexes for table `formkerjasama_publikasi`
--
ALTER TABLE `formkerjasama_publikasi`
  ADD PRIMARY KEY (`idPublikasi`),
  ADD KEY `idPerusahaan` (`idPerusahaan`);

--
-- Indexes for table `formkerjasama_statusbenefit`
--
ALTER TABLE `formkerjasama_statusbenefit`
  ADD KEY `idPerusahaan` (`idPerusahaan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `formkerjasama_authority`
--
ALTER TABLE `formkerjasama_authority`
  MODIFY `idAdmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `formkerjasama_benefit_campushiring`
--
ALTER TABLE `formkerjasama_benefit_campushiring`
  MODIFY `idBenefit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formkerjasama_benefit_companybranding`
--
ALTER TABLE `formkerjasama_benefit_companybranding`
  MODIFY `idBenefit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formkerjasama_benefit_datawisuda`
--
ALTER TABLE `formkerjasama_benefit_datawisuda`
  MODIFY `idBenefit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formkerjasama_benefit_vjf`
--
ALTER TABLE `formkerjasama_benefit_vjf`
  MODIFY `idBenefit` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `formkerjasama_jurusan`
--
ALTER TABLE `formkerjasama_jurusan`
  MODIFY `idJurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `formkerjasama_perusahaan_dt`
--
ALTER TABLE `formkerjasama_perusahaan_dt`
  MODIFY `idPerusahaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `formkerjasama_publikasi`
--
ALTER TABLE `formkerjasama_publikasi`
  MODIFY `idPublikasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `formkerjasama_benefit_campushiring`
--
ALTER TABLE `formkerjasama_benefit_campushiring`
  ADD CONSTRAINT `formkerjasama_benefit_campushiring_ibfk_1` FOREIGN KEY (`idPerusahaan`) REFERENCES `formkerjasama_perusahaan_dt` (`idPerusahaan`);

--
-- Constraints for table `formkerjasama_benefit_companybranding`
--
ALTER TABLE `formkerjasama_benefit_companybranding`
  ADD CONSTRAINT `formkerjasama_benefit_companybranding_ibfk_1` FOREIGN KEY (`idPerusahaan`) REFERENCES `formkerjasama_perusahaan_dt` (`idPerusahaan`);

--
-- Constraints for table `formkerjasama_benefit_datawisuda`
--
ALTER TABLE `formkerjasama_benefit_datawisuda`
  ADD CONSTRAINT `formkerjasama_benefit_datawisuda_ibfk_1` FOREIGN KEY (`idPerusahaan`) REFERENCES `formkerjasama_perusahaan_dt` (`idPerusahaan`);

--
-- Constraints for table `formkerjasama_benefit_vjf`
--
ALTER TABLE `formkerjasama_benefit_vjf`
  ADD CONSTRAINT `formkerjasama_benefit_vjf_ibfk_1` FOREIGN KEY (`idPerusahaan`) REFERENCES `formkerjasama_perusahaan_dt` (`idPerusahaan`);

--
-- Constraints for table `formkerjasama_publikasi`
--
ALTER TABLE `formkerjasama_publikasi`
  ADD CONSTRAINT `idPerusahaan` FOREIGN KEY (`idPerusahaan`) REFERENCES `formkerjasama_perusahaan_dt` (`idPerusahaan`);

--
-- Constraints for table `formkerjasama_statusbenefit`
--
ALTER TABLE `formkerjasama_statusbenefit`
  ADD CONSTRAINT `formkerjasama_statusbenefit_ibfk_1` FOREIGN KEY (`idPerusahaan`) REFERENCES `formkerjasama_perusahaan_dt` (`idPerusahaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
