-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2022 at 07:24 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

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
-- Table structure for table `tbl_cate`
--

CREATE TABLE `tbl_cate` (
  `CateId` int(11) NOT NULL,
  `CateName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_cate`
--

INSERT INTO `tbl_cate` (`CateId`, `CateName`) VALUES
(1, 'ยาต้านไวรัสในกลุ่มเอ็นอาร์ทีไอ'),
(2, 'ยาละลายเสมหะ'),
(3, 'ยาเรตินอยด์'),
(4, 'ยาถ่ายพยาธิ'),
(5, 'ยาฉีดเข้าหลอดเลือดดำ และสารละลาย'),
(6, 'ยาสามัญ'),
(7, 'ยาต้านไวรัส'),
(8, 'ยาแคลเซียมแชนแนลบล็อกเกอร์'),
(9, 'ยาปฏิชีวนะกลุ่มเพนิซิลลิน'),
(10, 'อาหารเสริม '),
(11, 'ยารักษาภาวะหย่อนสมรรถภาพทางเพศ'),
(12, 'ยาต้านตัวรับแองจิโอเทนซิน '),
(14, 'ยาคลายกล้ามเนื้อ '),
(15, 'ยารักษาอาการวิงเวียนศีรษะ'),
(16, 'ยาระบาย'),
(17, 'ยาเบต้าบล็อกเกอร์'),
(18, 'ยาต้านเอนไซม์เอซีอี'),
(19, 'ยากลุ่มปิดกั้นเบต้า '),
(20, 'ยาปฏิชีวนะกลุ่มเซฟาโลสปอริน'),
(21, 'ยาปฏิชีวนะ'),
(22, 'ยาปฏิชีวนะ กลุ่มเซฟาโลสปอริน'),
(23, 'ยาแก้อักเสบที่ไม่ใช่สเตียรอยด์ (NSAIDs)');

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
  `DealerPhone` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_dealer`
--

INSERT INTO `tbl_dealer` (`DealerId`, `DealerName`, `DealerAddress`, `DealerPhone`) VALUES
(1, 'test', '63/1 Moo 2, Sri Surat, Damnoen Saduak, Raichaburi 70130', '0867526248'),
(2, 'marginframe', '654 โครงการ สามย่าน บิสซิเนสทาวน์ 16 Chinda Thawin Alley, Maha Phruttharam, Bang Rak, Bangkok 10500', '0867526248');

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
(1, 'admin'),
(2, 'อายุรกรรมชาย'),
(3, 'อายุรกรรมหญิง'),
(6, 'ศัลยกรรม'),
(7, 'สูตินรีเวช'),
(8, 'พิเศษ'),
(9, 'กุมารเวช');

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
  `TypeId` int(11) DEFAULT NULL,
  `CateId` int(11) DEFAULT NULL,
  `VolumnId` int(11) DEFAULT NULL,
  `UnitId` int(11) DEFAULT NULL,
  `MedName` varchar(255) DEFAULT NULL,
  `MedPack` varchar(255) DEFAULT NULL,
  `MedPrice` varchar(255) DEFAULT NULL,
  `MedDes` varchar(255) DEFAULT NULL,
  `MedIndi` varchar(255) DEFAULT NULL,
  `MedNoti` varchar(255) DEFAULT NULL,
  `MedLow` int(11) DEFAULT NULL,
  `MedTotal` int(11) DEFAULT NULL,
  `MedPoint` int(11) DEFAULT NULL,
  `MedPath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_med`
--

INSERT INTO `tbl_med` (`MedId`, `TypeId`, `CateId`, `VolumnId`, `UnitId`, `MedName`, `MedPack`, `MedPrice`, `MedDes`, `MedIndi`, `MedNoti`, `MedLow`, `MedTotal`, `MedPoint`, `MedPath`) VALUES
(1, 3, 1, 1, 1, 'Abacavir (อะบาคาเวียร์)', '50', '100', 'เป็นยาต้านไวรัสในกลุ่มเอ็นอาร์ทีไอ (Nucleoside Reverse Transcriptase Inhibitors: NRTI) ที่แพทย์นำมาใช้ร่วมกับยารักษาการติดเชื้อเอชไอวีชนิดอื่น ออกฤทธิ์ลดจำนวนเชื้อเอชไอวีในร่างกายของผู้ป่วยที่ติดเชื้อ', 'ผู้ใหญ่\r\nรับประทานยาปริมาณ 300 มิลลิกรัม 2 ครั้ง/วัน หรือ 600 มิลลิกรัม 1 ครั้ง/วัน ร่วมกับยาต้านรีโทรไวรัสชนิดอื่น\r\nเด็ก\r\nเด็กอายุ 3 เดือนขึ้นไปที่มีน้ำหนักตัว 14-20 กิโลกรัม รับประทานยาปริมาณ 150 มิลลิกรัม 2 ครั้ง/วัน หรือ 300 มิลลิกรัม 1 ครั้ง/วัน\r\n', '50', 10, 0, 10, '1.Abacavir.jpg'),
(2, 2, 2, 2, 1, 'Acetylcysteine (อะเซทิลซิสเทอีน)', '30', '50', 'คือ ยาขับเสมหะ หรือยาละลายเสมหะ ใช้รักษาอาการป่วยจากการรับประทานยาพาราเซตามอลเกินขนาด เพื่อป้องกันการเกิดความเสียหายที่ตับ', 'ปริมาณการใช้ยา Acetylcysteine\r\n	แคปซูล\r\n	ผู้ใหญ่ และเด็กอายุมากกว่า 14 ปี รับประทานครั้งละ 1 แคปซูล=150 มิลลิกรัม 2-3 ครั้ง/วัน\r\n	เด็กอายุมากกว่า 6 ปี รับประทานยาหลังมื้ออาหารครั้งละ 1 แคปซูล=150 มิลลิกรัม 2 ครั้ง/วัน\r\n\r\n', '50', 10, 0, 30, '2.Acetylcysteine.jpg'),
(3, 2, 3, 3, 1, 'Acitretin (อาซิเทรติน)', '50', '50', 'เป็นยาในกลุ่มเรตินอยด์ ใช้รักษาโรคผิวหนังแดริเออร์ โรคผิวหนังแห้งลอกแต่กำเนิด โรคไลเคน พลานัส ', 'ปริมาณการใช้ยา Acitretin\r\nโรคแดริเออร์\r\nผู้ใหญ่ รับประทานยาปริมาณเริ่มต้น 10 มิลลิกรัม/วัน เป็นระยะเวลา 2-4 สัปดาห์\r\nโรคผิวหนังแห้งลอกแต่กำเนิด โรคไลเคน พลานัส \r\nผู้ใหญ่ รับประทานยาปริมาณเริ่มต้น 25 หรือ 30 มิลลิกรัม/วัน เป็นระยะเวลา 2-4 สัปดาห์\r\n', '50', 50, 0, 50, '3.Acitretin.jpg'),
(4, 2, 4, 4, 1, 'Albendazole (อัลเบนดาโซล)', '50', '50', ' เป็นยารักษาการติดเชื้อที่เกิดจากพยาธิตัวกลมทุกชนิด เช่น พยาธิตัวตืด พยาธิไส้เดือน โดยยาจะออกฤทธิ์ด้วยการทำให้พยาธิไม่สามารถดูดซึมน้ำตาลในร่างกายไปใช้ จนพยาธิไม่มีพลังงานและตายลงในที่สุด', 'รักษาโรคพยาธิไส้เดือน เด็กและผู้ใหญ่รับประทาน 400 มิลลิกรัม เพียง 1 ครั้ง\r\nรักษาโรคจากไข่พยาธิตัวตืด เด็กและผู้ใหญ่ที่มีน้ำหนักน้อยกว่า 60 กิโลกรัม รับประทาน 15 มิลลิกรัม/น้ำหนักตัว 1 กิโลกรัม/วัน\r\n', '50', 50, 0, 50, '4.Albendazole.jpg'),
(5, 2, 5, 5, 3, 'Albumin (อัลบูมิน)', '50', '50', 'เป็นหนึ่งในโปรตีนที่พบได้ในเลือด แต่นำมาใช้เพื่อรักษาผู้ป่วยที่มีภาวะโปรตีนในเลือดต่ำจากสาเหตุต่าง ๆ เช่น การสูญเสียเลือด ถูกไฟไหม้ การสูญเสียระดับโปรตีนในเลือดจากการผ่าตัด', 'ภาวะช็อกจากการสูญเสียน้ำและเกลือแรอย่างเฉียบพลัน\r\nผู้ใหญ่ เบื้องต้นให้สาร Albumin 25 กรัม แล้วค่อย ๆ เพิ่มหรือลด ตามการตอบสนองของผู้ป่วย ความเร็วในการให้ ไม่เกิน 5 มิลลิลิตรต่อนาที \r\nเด็ก ไม่เกิน 1 กรัม ต่อน้ำหนักตัว 1 กิโลกรัม แล้วค่อย ๆ เพิ่มหรือลด ตามก', '50', 50, 0, 50, '5.Albumin.jpg'),
(6, 1, 6, 6, 1, 'Allopurinol (อัลโลพูรินอล)', '100', '100', 'เป็นยาที่ช่วยลดการสร้างกรดยูริคในร่างกาย มักใช้รักษาในผู้ป่วยโรคเก๊าท์ นิ่วในไต และใช้เพื่อป้องกันการเพิ่มระดับกรดยูริคในผู้ป่วยโรคมะเร็งที่กำลังรับการรักษาเคมีบำบัด', 'ผู้ใหญ่ ยารับประทาน วันละครั้ง ครั้งละ 100 มิลลิกรัม/วัน', '50', 100, 0, 50, '6.Allopurinol.jpg'),
(7, 2, 7, 6, 1, 'Amantadine (อะแมนตาดีน)', '50', '50', 'เป็นยาต้านไวรัสที่ออกฤทธิ์ยับยั้งการทำงานของไวรัสในร่างกาย ใช้ในการรักษาและป้องกันไข้หวัดใหญ่สายพันธุ์เอ โดยจะช่วยบรรเทาอาการที่รุนแรงให้ผู้ป่วยกลับมามีสุขภาพดีเร็วขึ้นและลดความเสี่ยงในการกลับมาเป็นซ้ำ', 'ปริมาณการใช้ยา Amantadine\r\nไข้หวัดใหญ่สายพันธุ์เอ\r\nผู้ใหญ่ รับประทานยาปริมาณ 100 มิลลิกรัม/วัน เป็นระยะเวลา 5 วัน\r\nเด็กที่มีอายุ 10-15 ปี รับประทานยาปริมาณ 100 มิลลิกรัม/วัน\r\nผู้ที่มีอายุมากกว่า 65 ปีขึ้นไป รับประทานยาปริมาณน้อยกว่า 100 มิลลิกรัม/วัน\r\n', '50', 50, 0, 50, '7.Amantadine.jpg'),
(8, 1, 2, 7, 1, 'Ambroxol (แอมบรอกซอล)', '100', '100', 'เป็นยาลดความเหนียวข้นของเสมหะ โดยออกฤทธิ์ทำลายโครงสร้างเส้นใยมิวโคโพลี แซคคาไรด์ในเสมหะ (Acid Mucopolysaccharide Fibers) ทำให้ง่ายต่อการขจัดออกจากร่างกายด้วยการไอ', 'ปริมาณการใช้ยา Ambroxol\r\n	ผู้ใหญ่ รับประทาน ขนาด 60-120 มิลลิกรัม โดยแบ่งรับประทานวันละ 2-3 ครั้ง\r\n	เด็กอายุไม่เกิน 2 ปี รับประทาน ขนาด 7.5 มิลลิกรัม วันละ 2 ครั้ง\r\n	เด็กอายุ 2-5 ปี รับประทาน ขนาด 7.5 มิลลิกรัม วันละ 2-3 ครั้ง\r\n	เด็กอายุ 6-12 ปี รับปร', '100', 100, 0, 100, '8.Ambroxol.jpg'),
(9, 1, 8, 8, 1, 'Amlodipine (แอมโลดิปีน)', '50', '50', 'เป็นยาในกลุ่มแคลเซียมแชนแนลบล็อกเกอร์ (Calcium Channel Blocker) ที่ช่วยควบคุมโรคความดันโลหิตสูง บรรเทาอาการเจ็บหน้าอกจากกล้ามเนื้อหัวใจขาดเลือด หรือโรคอื่นที่เกี่ยวข้องกับหลอดเลือดหัวใจ', 'เด็กอายุ 6-17 ปี: รับประทาน ขนาด 2.5-5 มิลลิกรัม วันละ 1 ครั้ง (สูงสุดไม่เกิน 5 มิลลิกรัม/วัน)\r\nผู้ใหญ่: รับประทาน ขนาด 5-10 มิลลิกรัม วันละ 1 ครั้ง (สูงสุดไม่เกิน 10 มิลลิกรัม/วัน)\r\nผู้สูงอายุ: รับประทาน ขนาด 2.5-10 มิลลิกรัม วันละ 1 ครั้ง (สูงสุดไม่เกิน', '50', 50, 0, 50, '9.Amlodipine.jpg'),
(10, 2, 9, 9, 1, 'Ampicillin (แอมพิซิลลิน)', '50', '50', 'เป็นยาปฏิชีวนะในกลุ่มเพนิซิลลิน ออกฤทธิ์โดยกำจัดหรือยับยั้งการเจริญเติบโตของเชื้อแบคทีเรียบางชนิดในร่างกาย อาจใช้รักษาโรคติดเชื้อในทางเดินปัสสาวะ หลอดลมอักเสบ', 'รักษาทางเดินปัสสาวะอักเสบ\r\n	ผู้ใหญ่ รับประทานยาปริมาณ 500 มิลลิกรัม ทุก ๆ 8 ชั่วโมง\r\n\r\n', '50', 50, 0, 50, '10.Ampicillin.jpg'),
(11, 1, 10, 10, 1, 'Astaxanthin (แอสตาแซนทิน)', '24', '50', 'เป็นหนึ่งในสารประเภทแคโรทีนอยด์ (Carotenoid) ในธรรมชาติ ที่ทำให้เกิดสีแดงหรือสีชมพูในพืชหรือสัตว์ ซึ่งมีฤทธิ์ในการต่อต้านอนุมูลอิสระ (Antioxidant) ช่วยป้องกันการทำลายเซลล์และกระบวนการออกซิเดชั่นที่มีผลทำให้เกิดริ้วรอย', 'ปริมาณที่แนะนำต่อวันควรบริโภคประมาณ 4-12 มิลลิกรัม', '365', 30, 0, 30, '11.Astaxanthin.jpg'),
(12, 2, 11, 6, 1, 'Avanafil (อะแวนาฟิล)', '12', '180', 'เป็นยารักษาภาวะหย่อนสมรรถภาพทางเพศในผู้ชาย โดยออกฤทธิ์ช่วยคลายกล้ามเนื้อหลอดเลือด และเพิ่มการไหลเวียนเลือดไปยังอวัยวะเพศชาย', 'ผู้ใหญ่ รับประทานยาปริมาณเริ่มต้น 100 มิลลิกรัม โดยรับประทานก่อนมีเพศสัมพันธ์ประมาณ 15-30 นาที', '365', 10, 0, 15, '12.Avanafil.jpg'),
(13, 2, 12, 13, 1, 'Azilsartan (ยาอะซิลซาร์แทน)', '24', '250', 'เป็นยารักษาโรคความดันโลหิตสูง โดยตัวยาจะออกฤทธิ์ยับยั้งการทำงานของสารแองจิโอเทนซิน 2 (Angiotensin II) ที่ทำให้หลอดเลือดตีบ เมื่อหลอดเลือดขยายและคลายตัว', 'ผู้ใหญ่ เริ่มรับประทานยาที่ปริมาณ 40 มิลลิกรัม วันละครั้ง', '100', 20, 0, 20, '13.Azilsartan.jpg'),
(14, 1, 14, 8, 1, 'Baclofen (บาโคลเฟน)', '36', '160', 'เป็นยาคลายกล้ามเนื้อที่ออกฤทธิ์ต่อระบบประสาทส่วนกลาง อาจใช้ร่วมกับการรักษาวิธีอื่น เช่น กายภาพบำบัด เพื่อบรรเทาอาการกล้ามเนื้อหดเกร็งหรือกระตุก สำหรับผู้ที่มีกล้ามเนื้อแข็งตึงผิดปกติ', 'ผู้ใหญ่ เริ่มต้นรับประทานยาวันละ 15 มิลลิกรัม โดยแบ่งรับประทานปริมาณ 5 มิลลิกรัม วันละ 3 ครั้ง เป็นเวลา 3 วัน', '5', 20, 0, 20, '14.Baclofen.jpg'),
(15, 1, 15, 3, 1, 'Betahistine (เบตาฮีสทีน)', '30', '200', 'เป็นยาบรรเทาและป้องกันอาการเวียนศีรษะจากน้ำในหูไม่เท่ากันหรือโรคเมเนียส์', ' เริ่มรับประทาน 8-16 มิลลิกรัม วันละ 3 ครั้ง จากนั้นรับประทานต่อเนื่อง 24-48 มิลลิกรัม/วัน', '35', 20, 0, 12, '15.Betahistine.jpg'),
(16, 1, 16, 15, 1, 'Bisacodyl (บิซาโคดิล)', '24', '80', 'เป็นยาระบายที่ออกฤทธิ์กระตุ้นการทำงานของกล้ามเนื้อผนังลำไส้เล็กและลำไส้ใหญ่ ทำให้อุจจาระเคลื่อนที่และเกิดการขับถ่ายในที่สุด ใช้เพื่อรักษาอาการท้องผูก', '1.	เด็กอายุ 4-10 ปี รับประทานยา 5 มิลลิกรัม ก่อนนอน\r\n2.	ผู้ใหญ่ รับประทานยา 5-10 มิลลิกรัม สูงสุดไม่เกิน 20 มิลลิกรัม ก่อนนอน\r\n', '35', 30, 0, 30, '16.Bisacodyl.jpg'),
(17, 3, 17, 15, 1, 'Bisoprolol (ไบโซโปรลอล)', '35', '35', 'เป็นยากลุ่มเบต้าบล็อกเกอร์ ออกฤทธิ์โดยการช่วยลดอัตราการเต้นของหัวใจและช่วยไม่ให้หัวใจทำงานหนักเกินไป ใช้รักษาภาวะความดันโลหิตสูง', 'ผู้ใหญ่ รับประทานยาปริมาณ 5-10 มิลลิกรัม วันละ 1 ครั้ง รับประทานยาปริมาณสูงสุดไม่เกิน 20 มิลลิกรัม/วัน\r\n\r\n', '35', 35, 0, 35, '17.Bisoprolol.jpg'),
(18, 1, 2, 16, 1, 'Bromhexine (บรอมเฮกซีน)', '24', '100', 'เป็นยาช่วยละลายความเหนียวข้นของเสมหะในระบบทางเดินหายใจให้ลดน้อยลง ทำให้ง่ายต่อการขจัดออกจากร่างกายด้วยการไอ', '1.	อายุ  2-5 ปี รับประทานยาในปริมาณ 8 มิลลิกรัม โดยแบ่งรับประทานวันละ 2-3 ครั้งต่อวัน\r\n2.	อายุ 6-11 ปี รับประทานยาในปริมาณ 4-8 มิลลิกรัม โดยแบ่งรับประทานวันละ 3 ครั้ง\r\n3.	อายุมากกว่า 12 ปี รับประทานยาในปริมาณ 8-16 มิลลิกรัม วันละ 3 ครั้ง\r\n', '35', 20, 0, 20, '18.Bromhexine.jpg'),
(19, 1, 18, 3, 1, 'Captopril (แคปโตพริล)', '24', '50', 'ยาต้านเอนไซม์เอซีอี ใช้รักษาผู้ป่วยความดันโลหิตสูง ลดความเสี่ยงการเกิดภาวะหัวใจล้มเหลว ควบคุมอาการหลังเกิดภาวะหัวใจขาดเลือดเฉียบพลัน', 'ผู้ใหญ่ เริ่มจากรับประทานยา 12.5 มิลลิกรัม วันละ 2 ครั้ง 1 ชั่วโมงก่อนอาหาร สามารถปรับปริมาณยาได้ภายใน 2-4 สัปดาห์', '35', 20, 0, 20, '19.Captopril.jpg'),
(20, 1, 1, 17, 1, 'Carvedilol (คาร์วีไดลอล)', '50', '90', 'ยากลุ่มปิดกั้นเบต้า (Beta-Blockers) ช่วยให้หัวใจเต้นช้าลงและลดความดันโลหิต ใช้รักษาอาการความดันโลหิตสูง ภาวะหัวใจล้มเหลว', 'ปริมาณเริ่มต้น 6.25 มิลลิกรัม 2 ครั้งต่อวัน รับประทานร่วมกับอาหาร', '30', 30, 0, 30, '20.Carvedilol.jpg');

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
(1, 'admin', 'admin', '0867526248', 'tao_2349@hotmail.com', 1),
(2, 'staff', 'staff', '0867526248', 'test@gmil.com', 2),
(3, 'warakorn', 'warakorn', '0882427585', 'kittyman@live.com', 6),
(4, 'supakorn', 'supakorn', '0878234250', 'mooskylove123@gmail.com', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_type`
--

CREATE TABLE `tbl_type` (
  `TypeId` int(11) NOT NULL,
  `TypeName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_type`
--

INSERT INTO `tbl_type` (`TypeId`, `TypeName`) VALUES
(1, 'ยาสามัญประจำบ้าน'),
(2, 'ยาอันตราย'),
(3, 'ยาแผนปัจจุบันบรรจุเสร็จที่มิใช่ยาอันตราย'),
(4, 'ยาสมุนไพร');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_unit`
--

CREATE TABLE `tbl_unit` (
  `UnitId` int(11) NOT NULL,
  `UnitName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_unit`
--

INSERT INTO `tbl_unit` (`UnitId`, `UnitName`) VALUES
(1, 'เม็ด'),
(2, 'แคปซูล'),
(3, 'ขวด'),
(4, 'เข็ม');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_volumn`
--

CREATE TABLE `tbl_volumn` (
  `VolumnId` int(11) NOT NULL,
  `VolumnName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_volumn`
--

INSERT INTO `tbl_volumn` (`VolumnId`, `VolumnName`) VALUES
(1, '300 มิลลิกรัม '),
(2, '600 มิลลิกรัม '),
(3, '25 มิลลิกรัม '),
(4, '400 มิลลิกรัม '),
(5, '50 มิลลิลิตร'),
(6, '100 มิลลิกรัม '),
(7, '30 มิลลิกรัม '),
(8, '10 มิลลิกรัม'),
(9, '500 มิลลิกรัม'),
(10, '4 มิลลิกรัม'),
(13, '40 มิลลิกรัม'),
(15, '5 มิลลิกรัม'),
(16, '8 มิลลิกรัม'),
(17, '12.5 มิลลิกรัม');

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
-- Indexes for table `tbl_cate`
--
ALTER TABLE `tbl_cate`
  ADD PRIMARY KEY (`CateId`);

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
  ADD PRIMARY KEY (`MedId`),
  ADD KEY `TypeId` (`TypeId`),
  ADD KEY `VolumnId` (`VolumnId`),
  ADD KEY `UnitId` (`UnitId`),
  ADD KEY `CateId` (`CateId`);

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
-- Indexes for table `tbl_type`
--
ALTER TABLE `tbl_type`
  ADD PRIMARY KEY (`TypeId`);

--
-- Indexes for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  ADD PRIMARY KEY (`UnitId`);

--
-- Indexes for table `tbl_volumn`
--
ALTER TABLE `tbl_volumn`
  ADD PRIMARY KEY (`VolumnId`);

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
-- AUTO_INCREMENT for table `tbl_cate`
--
ALTER TABLE `tbl_cate`
  MODIFY `CateId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_claim`
--
ALTER TABLE `tbl_claim`
  MODIFY `ClaimId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_dealer`
--
ALTER TABLE `tbl_dealer`
  MODIFY `DealerId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `DepartId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_lot`
--
ALTER TABLE `tbl_lot`
  MODIFY `LotId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_med`
--
ALTER TABLE `tbl_med`
  MODIFY `MedId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  MODIFY `StaffId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_type`
--
ALTER TABLE `tbl_type`
  MODIFY `TypeId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_unit`
--
ALTER TABLE `tbl_unit`
  MODIFY `UnitId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_volumn`
--
ALTER TABLE `tbl_volumn`
  MODIFY `VolumnId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
-- Constraints for table `tbl_med`
--
ALTER TABLE `tbl_med`
  ADD CONSTRAINT `tbl_med_ibfk_1` FOREIGN KEY (`TypeId`) REFERENCES `tbl_type` (`TypeId`),
  ADD CONSTRAINT `tbl_med_ibfk_2` FOREIGN KEY (`CateId`) REFERENCES `tbl_cate` (`CateId`),
  ADD CONSTRAINT `tbl_med_ibfk_3` FOREIGN KEY (`VolumnId`) REFERENCES `tbl_volumn` (`VolumnId`),
  ADD CONSTRAINT `tbl_med_ibfk_4` FOREIGN KEY (`UnitId`) REFERENCES `tbl_unit` (`UnitId`),
  ADD CONSTRAINT `tbl_med_ibfk_5` FOREIGN KEY (`CateId`) REFERENCES `tbl_cate` (`CateId`);

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
