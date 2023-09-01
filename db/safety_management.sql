-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 01, 2023 at 07:31 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `safety_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `management`
--

CREATE TABLE `management` (
  `id_management` int(11) NOT NULL,
  `id_organization` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `management`
--

INSERT INTO `management` (`id_management`, `id_organization`, `id_role`, `nik`, `fullname`, `password`) VALUES
(3, 1, 1, '714220005', 'M Fachriza Farhan', '$2y$10$QgQ/lBQuAQCUSBFrcAjiNe01ArOhTm7zIy6SHYC65Lr3BhYuxWpvO'),
(4, 3, 2, '714220031', 'Ghaida Fasya Yuthika Afifah', '$2y$10$05T/NG6zGYncjRO8/LUCXOIk/YPPwg53aRSzaCpR6x3XHeXo1WcCS'),
(5, 2, 3, '714220011', 'Gaizka Wisnu Prawira', '$2y$10$YB91eVQRks737f/rTpH0i.a.sKmoASMkQjrFCr4Hf.dhFuv.pNarO'),
(6, 4, 4, '714220008', 'M Rafli Alfarisi', '$2y$10$7lUdQMpsF7mdNAzPXyvMKe8emeT7C9r5mdyhviNz8qtlT9zKxVPYC'),
(7, 1, 1, '714220028', 'Ahmad Rifki Ayala', '$2y$10$bumuYm/h/m0j6q47FsmEYuwlmxiGxYR8.ySDO9vIURUJbdLxv7KYq'),
(9, 3, 1, '714230033', 'Rizqi Iqmal Fauzan', '$2y$10$mtMgURzZJxAATXIeAJj6qOYZ/yTKrKHJRJuKZFZ.rVLbYiMPxqaxm');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `id_organization` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`id_organization`, `name`) VALUES
(1, 'Bid. Sistem Manajemen Keselamatan'),
(2, 'Dep. Enterprise Aplikasi & Solusi Migrasi'),
(3, 'Bid. Sistem Pemeliharaan'),
(4, 'Bid. Keamanan Informasi & Infrastuktur'),
(5, 'Bi.  Sistem Informasi Korporasi'),
(6, 'Bid.  Sistem Informasi Korporasi');

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id_report` int(11) NOT NULL,
  `classification` varchar(10) NOT NULL,
  `date_of_submission` varchar(100) NOT NULL,
  `date_of_hazard` date NOT NULL,
  `location` varchar(50) NOT NULL,
  `type_operation` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `file_reporter` varchar(100) NOT NULL,
  `file_response` varchar(100) NOT NULL,
  `respon_hazard` varchar(100) NOT NULL,
  `status` varchar(30) NOT NULL,
  `post_mitigation` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`id_report`, `classification`, `date_of_submission`, `date_of_hazard`, `location`, `type_operation`, `description`, `file_reporter`, `file_response`, `respon_hazard`, `status`, `post_mitigation`) VALUES
(1, 'SMS', '2023-09-01', '2023-10-07', 'Dep IT', 'Dismantling', 'Test', '64f15fe5b3bd7.png', '', 'Done', 'accept', 'Acc Segera Perbaiki'),
(2, 'SMS', '2023-09-01', '2023-10-07', 'Dep IT', 'Aircraft Component/Interior Maintenance', 'Halo', '64f16430bf2f4.jpeg', '64f16485ab941.png', 'Done', 'accept', 'Acc Segera Perbaiki');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role`) VALUES
(1, 'Admin'),
(2, 'Departemen Safety'),
(3, 'Responsible'),
(4, 'Reporter');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `management`
--
ALTER TABLE `management`
  ADD PRIMARY KEY (`id_management`),
  ADD KEY `id_organization` (`id_organization`),
  ADD KEY `id_role` (`id_role`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`id_organization`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id_report`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `management`
--
ALTER TABLE `management`
  MODIFY `id_management` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `organization`
--
ALTER TABLE `organization`
  MODIFY `id_organization` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `management`
--
ALTER TABLE `management`
  ADD CONSTRAINT `management_ibfk_1` FOREIGN KEY (`id_organization`) REFERENCES `organization` (`id_organization`),
  ADD CONSTRAINT `management_ibfk_2` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
