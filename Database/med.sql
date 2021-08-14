-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2021 at 07:50 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `med`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dealer`
--

CREATE TABLE `tbl_dealer` (
  `DealerId` int(11) NOT NULL,
  `DealerName` varchar(255) NOT NULL,
  `DealerAddress` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_dealer`
--

INSERT INTO `tbl_dealer` (`DealerId`, `DealerName`, `DealerAddress`) VALUES
(9, 'eiei', '63/1 หมู่ 2'),
(11, 'test', '12345678910');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `DepartId` int(11) NOT NULL,
  `DepartName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`DepartId`, `DepartName`) VALUES
(1, 'test'),
(2, 'nurse ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_med`
--

CREATE TABLE `tbl_med` (
  `MedId` int(11) NOT NULL,
  `MedName` varchar(255) DEFAULT NULL,
  `MedCate` varchar(255) DEFAULT NULL,
  `MedVolumn` varchar(255) DEFAULT NULL,
  `MedUnit` varchar(255) DEFAULT NULL,
  `MedPack` varchar(255) DEFAULT NULL,
  `MedPrice` varchar(255) DEFAULT NULL,
  `MedStatus` varchar(255) DEFAULT NULL,
  `MedTotal` int(11) DEFAULT NULL,
  `MedPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_med`
--

INSERT INTO `tbl_med` (`MedId`, `MedName`, `MedCate`, `MedVolumn`, `MedUnit`, `MedPack`, `MedPrice`, `MedStatus`, `MedTotal`, `MedPath`) VALUES
(4, 'eiei', 'Vitamins', '100 CC', 'Capsule', '500', '300', 'Out of stock', 0, '114741041_2825308747703316_1182896439057558274_n.jpg'),
(6, 'test', 'Vitamins', '1000 CC', 'Capsule', '1000', '20', 'Out of stock', 0, '115405411_2825287537705437_3601519137065178295_n.jpg'),
(7, 'แก้ปวด', 'Vitamins', '500 CC', 'Capsule', '1000', '20', 'Out of stock', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `OrderId` int(11) NOT NULL,
  `OrderDate` varchar(255) DEFAULT NULL,
  `OrderStatus` varchar(255) DEFAULT NULL,
  `OrderPrice` int(11) DEFAULT NULL,
  `DealerId` int(11) DEFAULT NULL,
  `StaffName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`OrderId`, `OrderDate`, `OrderStatus`, `OrderPrice`, `DealerId`, `StaffName`) VALUES
(1, '2021-08-03 01:02:19pm', 'Ordering', 440, 9, 'admin'),
(2, '2021-08-03 01:03:30pm', 'Ordering', 440, 9, 'admin'),
(3, '2021-08-09 12:18:43pm', 'Ordering', 6000, 9, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `StaffId` int(11) NOT NULL,
  `StaffName` varchar(255) DEFAULT NULL,
  `StaffPassword` varchar(255) DEFAULT NULL,
  `StaffTel` varchar(255) DEFAULT NULL,
  `StaffEmail` varchar(255) DEFAULT NULL,
  `DepartId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`StaffId`, `StaffName`, `StaffPassword`, `StaffTel`, `StaffEmail`, `DepartId`) VALUES
(4, 'admin', 'admin', '0867526248', 'tao_2349@hotmail.com', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_dealer`
--
ALTER TABLE `tbl_dealer`
  ADD PRIMARY KEY (`DealerId`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`DepartId`);

--
-- Indexes for table `tbl_med`
--
ALTER TABLE `tbl_med`
  ADD PRIMARY KEY (`MedId`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`OrderId`),
  ADD KEY `DealerId` (`DealerId`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`StaffId`),
  ADD KEY `DepartId` (`DepartId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_dealer`
--
ALTER TABLE `tbl_dealer`
  MODIFY `DealerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `DepartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_med`
--
ALTER TABLE `tbl_med`
  MODIFY `MedId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `StaffId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`DealerId`) REFERENCES `tbl_dealer` (`DealerId`);

--
-- Constraints for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `tbl_staff_ibfk_1` FOREIGN KEY (`DepartId`) REFERENCES `tbl_department` (`DepartId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
