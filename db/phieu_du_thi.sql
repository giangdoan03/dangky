-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 16, 2024 at 06:12 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dangky`
--

-- --------------------------------------------------------

--
-- Table structure for table `phieu_du_thi`
--

CREATE TABLE `phieu_du_thi` (
  `id` int NOT NULL,
  `hoten_hocsinh` varchar(150) NOT NULL,
  `ma_hoc_sinh` varchar(20) NOT NULL,
  `gioi_tinh` varchar(10) NOT NULL,
  `ngay_sinh` varchar(30) NOT NULL,
  `so_bao_danh` varchar(20) NOT NULL,
  `so_phong` varchar(10) NOT NULL,
  `thoi_gian` varchar(30) NOT NULL,
  `dia_diem` varchar(250) NOT NULL,
  `dia_chi` varchar(250) NOT NULL,
  `ten_anh` varchar(250) NOT NULL,
  `trang_thai` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `phieu_du_thi`
--

INSERT INTO `phieu_du_thi` (`id`, `hoten_hocsinh`, `ma_hoc_sinh`, `gioi_tinh`, `ngay_sinh`, `so_bao_danh`, `so_phong`, `thoi_gian`, `dia_diem`, `dia_chi`, `ten_anh`, `trang_thai`) VALUES
(1, 'Nguyễn văn an', '123456789', 'Nam', '16/05/2024', '123456789', '1', '8h30', 'thcs thanh xuân 1', 'nguyễn tuân', 'abc.jpg', 'active'),
(2, 'Nguyễn văn ban', '123456788', 'Nam', '16/05/2025', '123456789', '1', '8h31', 'thcs thanh xuân 2', 'nguyễn huy tưởng', 'abc.jpg', 'active'),
(3, 'Nguyễn văn can', '123456787', 'Nam', '16/05/2026', '123456789', '1', '8h32', 'thcs thanh xuân 3', 'nguyễn tuân', 'abc.jpg', 'active'),
(4, 'Nguyễn văn dan', '123456786', 'Nam', '16/05/2027', '123456789', '1', '8h33', 'thcs thanh xuân 4', 'nguyễn tuân', 'abc.jpg', 'active'),
(5, 'Nguyễn văn d', '123456785', 'Nam', '16/05/2028', '123456789', '1', '8h34', 'thcs thanh xuân 4', 'lê văn thiêm', 'abc.jpg', 'active'),
(6, 'Nguyễn văn e', '123456784', 'Nam', '16/05/2029', '123456789', '1', '8h35', 'thcs thanh xuân 4', 'nguyễn tuân', 'abc.jpg', 'active'),
(7, 'Nguyễn văn f', '123456783', 'Nam', '16/05/2030', '123456789', '1', '8h36', 'thcs thanh xuân 5', 'vũ trọng phụng', 'abc.jpg', 'active'),
(8, 'Nguyễn văn g', '123456782', 'Nam', '16/05/2031', '123456789', '1', '8h37', 'thcs thanh xuân 6', 'nguyễn tuân', 'abc.jpg', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `phieu_du_thi`
--
ALTER TABLE `phieu_du_thi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phieu_du_thi`
--
ALTER TABLE `phieu_du_thi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
