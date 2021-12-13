-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2021 at 10:07 AM
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
-- Table structure for table `tbl_claim`
--

CREATE TABLE `tbl_claim` (
  `ClaimId` int(11) NOT NULL,
  `LotId` int(11) DEFAULT NULL,
  `StaffId` int(11) DEFAULT NULL,
  `DealerId` int(11) DEFAULT NULL,
  `MedId` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `Reason` varchar(255) DEFAULT NULL,
  `ClaimDate` varchar(255) DEFAULT NULL,
  `ClaimStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dealer`
--

CREATE TABLE `tbl_dealer` (
  `DealerId` int(11) NOT NULL,
  `DealerName` varchar(255) DEFAULT NULL,
  `DealerAddress` varchar(255) DEFAULT NULL,
  `DealerPhone` varchar(255) DEFAULT NULL,
  `ContractStart` date DEFAULT NULL,
  `ContractEnd` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_dealer`
--

INSERT INTO `tbl_dealer` (`DealerId`, `DealerName`, `DealerAddress`, `DealerPhone`, `ContractStart`, `ContractEnd`) VALUES
(1, 'Weerapat', '63/1 Moo 2, Sri Surat, Damnoen Saduak, Raichaburi 77777', '0867526248', '2021-12-13', '2025-12-31');

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
(1, 'Admin'),
(2, 'Nuser'),
(5, 'Docter');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lot`
--

CREATE TABLE `tbl_lot` (
  `LotId` int(11) NOT NULL,
  `MedId` int(11) DEFAULT NULL,
  `RecClaimid` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `Reserve` int(11) DEFAULT NULL,
  `Mfd` varchar(255) DEFAULT NULL,
  `Exd` varchar(255) DEFAULT NULL,
  `LotStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `MedLow` int(11) DEFAULT NULL,
  `MedDes` varchar(255) DEFAULT NULL,
  `MedIndi` varchar(255) DEFAULT NULL,
  `MedType` varchar(255) DEFAULT NULL,
  `MedTotal` int(11) DEFAULT NULL,
  `MedPoint` int(11) DEFAULT NULL,
  `MedPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_med`
--

INSERT INTO `tbl_med` (`MedId`, `MedName`, `MedCate`, `MedVolumn`, `MedUnit`, `MedPack`, `MedPrice`, `MedLow`, `MedDes`, `MedIndi`, `MedType`, `MedTotal`, `MedPoint`, `MedPath`) VALUES
(1, 'Abacavir (อะบาคาเวียร์)', 'Vitamins', '100 MG', 'Tablet', '50', '100', 50, 'เป็นยาต้านไวรัสในกลุ่มเอ็นอาร์ทีไอ (Nucleoside Reverse Transcriptase Inhibitors: NRTI) ที่แพทย์นำมาใช้ร่วมกับยารักษาการติดเชื้อเอชไอวีชนิดอื่น ออกฤทธิ์ลดจำนวนเชื้อเอชไอวีในร่างกายของผู้ป่วยที่ติดเชื้อ', 'ปริมาณการใช้ยา Abacavir\r\nผู้ใหญ่\r\nรับประทานยาปริมาณ 300 มิลลิกรัม 2 ครั้ง/วัน หรือ 600 มิลลิกรัม 1 ครั้ง/วัน ร่วมกับยาต้านรีโทรไวรัสชนิดอื่น\r\nเด็ก\r\nเด็กอายุ 3 เดือนขึ้นไปที่มีน้ำหนักตัว 14-20 กิโลกรัม รับประทานยาปริมาณ 150 มิลลิกรัม 2 ครั้ง/วัน หรือ 300 ม', 'Internal medicine', 0, 50, '1.Abacavir.jpg'),
(2, 'Acetylcysteine (อะเซทิลซิสเทอีน)', 'Antipyretics', '500 MG', 'Tablet', '20', '200', 10, 'ยาขับเสมหะ หรือยาละลายเสมหะ ใช้รักษาอาการป่วยจากการรับประทานยาพาราเซตามอลเกินขนาด เพื่อป้องกันการเกิดความเสียหายที่ตับ', '1.	ผู้ใหญ่ และเด็กอายุมากกว่า 14 ปี รับประทานครั้งละ 1 แคปซูล=150 มิลลิกรัม 2-3 ครั้ง/วัน\r\n2.	เด็กอายุมากกว่า 6 ปี รับประทานยาหลังมื้ออาหารครั้งละ 1 แคปซูล=150 มิลลิกรัม 2 ครั้ง/วัน\r\n', 'ยารับประทาน', 0, 50, '2.Acetylcysteine.jpg'),
(3, 'Acitretin (อาซิเทรติน)', 'Antibiotics', '300 MG', 'Tablet', '20', '200', 20, 'เป็นยาในกลุ่มเรตินอยด์ ใช้รักษาโรคผิวหนังแดริเออร์ โรคผิวหนังแห้งลอกแต่กำเนิด (Congenital Ichthyosis) โรคไลเคน พลานัส (Lichen Planus)', 'โรคแดริเออร์\r\nผู้ใหญ่ รับประทานยาปริมาณเริ่มต้น 10 มิลลิกรัม/วัน เป็นระยะเวลา 2-4 สัปดาห์\r\nผู้ใหญ่ รับประทานยาปริมาณเริ่มต้น 25 หรือ 30 มิลลิกรัม/วัน เป็นระยะเวลา 2-4 สัปดาห์\r\n', 'ยารับประทาน', 0, 50, '3.Acitretin.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `OrderId` int(11) NOT NULL,
  `OrderDate` varchar(255) DEFAULT NULL,
  `OrderStatus` varchar(255) DEFAULT NULL,
  `OrderPrice` int(11) DEFAULT NULL,
  `OrderTotal` int(11) DEFAULT NULL,
  `DealerId` int(11) DEFAULT NULL,
  `StaffName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orderdetail`
--

CREATE TABLE `tbl_orderdetail` (
  `OrderdeId` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `MedId` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_recclaim`
--

CREATE TABLE `tbl_recclaim` (
  `RecClaimid` int(11) NOT NULL,
  `ClaimId` int(11) DEFAULT NULL,
  `StaffId` int(11) DEFAULT NULL,
  `RecClaimName` varchar(255) DEFAULT NULL,
  `RecClaimdate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_received`
--

CREATE TABLE `tbl_received` (
  `RecId` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `StaffId` int(11) DEFAULT NULL,
  `RecDate` varchar(255) DEFAULT NULL,
  `RecDeli` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receiveddetail`
--

CREATE TABLE `tbl_receiveddetail` (
  `RecdeId` int(11) NOT NULL,
  `RecId` int(11) DEFAULT NULL,
  `LotId` int(11) DEFAULT NULL,
  `MedId` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `Mfd` varchar(255) DEFAULT NULL,
  `Exd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
(4, 'admin', 'admin', '0867526248', 'tao_2349@hotmail.com', 1),
(8, 'staff1', 'staff', '0123456789', '1111', 2),
(9, 'Staff2', 'staff', '6686752624', 'test@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_withdraw`
--

CREATE TABLE `tbl_withdraw` (
  `WithId` int(11) NOT NULL,
  `StaffId` int(11) DEFAULT NULL,
  `Qtysum` int(11) DEFAULT NULL,
  `WithStatus` varchar(255) DEFAULT NULL,
  `WithDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_withdrawdetail`
--

CREATE TABLE `tbl_withdrawdetail` (
  `WithdeId` int(11) NOT NULL,
  `WithId` int(11) DEFAULT NULL,
  `MedId` int(11) DEFAULT NULL,
  `LotId` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `Mfd` varchar(255) DEFAULT NULL,
  `Exd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_writeoff`
--

CREATE TABLE `tbl_writeoff` (
  `WriteId` int(11) NOT NULL,
  `LotId` int(11) DEFAULT NULL,
  `MedId` int(11) DEFAULT NULL,
  `StaffId` int(11) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `WriteDate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_claim`
--
ALTER TABLE `tbl_claim`
  ADD PRIMARY KEY (`ClaimId`),
  ADD KEY `LotId` (`LotId`),
  ADD KEY `StaffId` (`StaffId`),
  ADD KEY `DealerId` (`DealerId`),
  ADD KEY `MedId` (`MedId`);

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
-- Indexes for table `tbl_lot`
--
ALTER TABLE `tbl_lot`
  ADD PRIMARY KEY (`LotId`),
  ADD KEY `MedId` (`MedId`),
  ADD KEY `RecClaimid` (`RecClaimid`);

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
-- Indexes for table `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  ADD PRIMARY KEY (`OrderdeId`),
  ADD KEY `OrderId` (`OrderId`),
  ADD KEY `MedId` (`MedId`);

--
-- Indexes for table `tbl_recclaim`
--
ALTER TABLE `tbl_recclaim`
  ADD PRIMARY KEY (`RecClaimid`),
  ADD KEY `ClaimId` (`ClaimId`),
  ADD KEY `StaffId` (`StaffId`);

--
-- Indexes for table `tbl_received`
--
ALTER TABLE `tbl_received`
  ADD PRIMARY KEY (`RecId`),
  ADD KEY `OrderId` (`OrderId`),
  ADD KEY `StaffId` (`StaffId`);

--
-- Indexes for table `tbl_receiveddetail`
--
ALTER TABLE `tbl_receiveddetail`
  ADD PRIMARY KEY (`RecdeId`),
  ADD KEY `RecId` (`RecId`),
  ADD KEY `MedId` (`MedId`),
  ADD KEY `LotId` (`LotId`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`StaffId`),
  ADD KEY `DepartId` (`DepartId`);

--
-- Indexes for table `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
  ADD PRIMARY KEY (`WithId`),
  ADD KEY `StaffId` (`StaffId`);

--
-- Indexes for table `tbl_withdrawdetail`
--
ALTER TABLE `tbl_withdrawdetail`
  ADD PRIMARY KEY (`WithdeId`),
  ADD KEY `WithId` (`WithId`),
  ADD KEY `MedId` (`MedId`),
  ADD KEY `LotId` (`LotId`);

--
-- Indexes for table `tbl_writeoff`
--
ALTER TABLE `tbl_writeoff`
  ADD PRIMARY KEY (`WriteId`),
  ADD KEY `LotId` (`LotId`),
  ADD KEY `MedId` (`MedId`),
  ADD KEY `StaffId` (`StaffId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_claim`
--
ALTER TABLE `tbl_claim`
  MODIFY `ClaimId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dealer`
--
ALTER TABLE `tbl_dealer`
  MODIFY `DealerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `DepartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_lot`
--
ALTER TABLE `tbl_lot`
  MODIFY `LotId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_med`
--
ALTER TABLE `tbl_med`
  MODIFY `MedId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  MODIFY `OrderdeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_recclaim`
--
ALTER TABLE `tbl_recclaim`
  MODIFY `RecClaimid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_received`
--
ALTER TABLE `tbl_received`
  MODIFY `RecId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_receiveddetail`
--
ALTER TABLE `tbl_receiveddetail`
  MODIFY `RecdeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `StaffId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
  MODIFY `WithId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_withdrawdetail`
--
ALTER TABLE `tbl_withdrawdetail`
  MODIFY `WithdeId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_writeoff`
--
ALTER TABLE `tbl_writeoff`
  MODIFY `WriteId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_claim`
--
ALTER TABLE `tbl_claim`
  ADD CONSTRAINT `tbl_claim_ibfk_1` FOREIGN KEY (`LotId`) REFERENCES `tbl_lot` (`LotId`),
  ADD CONSTRAINT `tbl_claim_ibfk_2` FOREIGN KEY (`StaffId`) REFERENCES `tbl_staff` (`StaffId`),
  ADD CONSTRAINT `tbl_claim_ibfk_3` FOREIGN KEY (`DealerId`) REFERENCES `tbl_dealer` (`DealerId`),
  ADD CONSTRAINT `tbl_claim_ibfk_4` FOREIGN KEY (`MedId`) REFERENCES `tbl_med` (`MedId`);

--
-- Constraints for table `tbl_lot`
--
ALTER TABLE `tbl_lot`
  ADD CONSTRAINT `tbl_lot_ibfk_1` FOREIGN KEY (`MedId`) REFERENCES `tbl_med` (`MedId`),
  ADD CONSTRAINT `tbl_lot_ibfk_2` FOREIGN KEY (`RecClaimid`) REFERENCES `tbl_recclaim` (`RecClaimid`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`DealerId`) REFERENCES `tbl_dealer` (`DealerId`);

--
-- Constraints for table `tbl_orderdetail`
--
ALTER TABLE `tbl_orderdetail`
  ADD CONSTRAINT `tbl_orderdetail_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `tbl_order` (`OrderId`),
  ADD CONSTRAINT `tbl_orderdetail_ibfk_2` FOREIGN KEY (`MedId`) REFERENCES `tbl_med` (`MedId`);

--
-- Constraints for table `tbl_recclaim`
--
ALTER TABLE `tbl_recclaim`
  ADD CONSTRAINT `tbl_recclaim_ibfk_1` FOREIGN KEY (`ClaimId`) REFERENCES `tbl_claim` (`ClaimId`),
  ADD CONSTRAINT `tbl_recclaim_ibfk_2` FOREIGN KEY (`StaffId`) REFERENCES `tbl_staff` (`StaffId`);

--
-- Constraints for table `tbl_received`
--
ALTER TABLE `tbl_received`
  ADD CONSTRAINT `tbl_received_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `tbl_order` (`OrderId`),
  ADD CONSTRAINT `tbl_received_ibfk_2` FOREIGN KEY (`StaffId`) REFERENCES `tbl_staff` (`StaffId`);

--
-- Constraints for table `tbl_receiveddetail`
--
ALTER TABLE `tbl_receiveddetail`
  ADD CONSTRAINT `tbl_receiveddetail_ibfk_1` FOREIGN KEY (`RecId`) REFERENCES `tbl_received` (`RecId`),
  ADD CONSTRAINT `tbl_receiveddetail_ibfk_2` FOREIGN KEY (`MedId`) REFERENCES `tbl_med` (`MedId`),
  ADD CONSTRAINT `tbl_receiveddetail_ibfk_3` FOREIGN KEY (`LotId`) REFERENCES `tbl_lot` (`LotId`);

--
-- Constraints for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `tbl_staff_ibfk_1` FOREIGN KEY (`DepartId`) REFERENCES `tbl_department` (`DepartId`);

--
-- Constraints for table `tbl_withdraw`
--
ALTER TABLE `tbl_withdraw`
  ADD CONSTRAINT `tbl_withdraw_ibfk_1` FOREIGN KEY (`StaffId`) REFERENCES `tbl_staff` (`StaffId`);

--
-- Constraints for table `tbl_withdrawdetail`
--
ALTER TABLE `tbl_withdrawdetail`
  ADD CONSTRAINT `tbl_withdrawdetail_ibfk_1` FOREIGN KEY (`WithId`) REFERENCES `tbl_withdraw` (`WithId`),
  ADD CONSTRAINT `tbl_withdrawdetail_ibfk_2` FOREIGN KEY (`MedId`) REFERENCES `tbl_med` (`MedId`),
  ADD CONSTRAINT `tbl_withdrawdetail_ibfk_3` FOREIGN KEY (`LotId`) REFERENCES `tbl_lot` (`LotId`);

--
-- Constraints for table `tbl_writeoff`
--
ALTER TABLE `tbl_writeoff`
  ADD CONSTRAINT `tbl_writeoff_ibfk_1` FOREIGN KEY (`LotId`) REFERENCES `tbl_lot` (`LotId`),
  ADD CONSTRAINT `tbl_writeoff_ibfk_2` FOREIGN KEY (`MedId`) REFERENCES `tbl_med` (`MedId`),
  ADD CONSTRAINT `tbl_writeoff_ibfk_3` FOREIGN KEY (`StaffId`) REFERENCES `tbl_staff` (`StaffId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
