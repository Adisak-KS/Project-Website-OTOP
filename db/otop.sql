-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 07, 2024 at 03:26 AM
-- Server version: 8.2.0
-- PHP Version: 8.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `otop`
--

-- --------------------------------------------------------

--
-- Table structure for table `ot_admin`
--

DROP TABLE IF EXISTS `ot_admin`;
CREATE TABLE IF NOT EXISTS `ot_admin` (
  `adm_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสผู้ดูแลระบบ',
  `adm_profile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รูปโปรไฟล์',
  `adm_fname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อ',
  `adm_lname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'นามสกุล',
  `adm_username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อผู้ใช้',
  `adm_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสผ่าน',
  `adm_email` varchar(65) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `adm_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดง/ไม่แสดง',
  PRIMARY KEY (`adm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลผู้ดูแลระบบ';

--
-- Dumping data for table `ot_admin`
--

INSERT INTO `ot_admin` (`adm_id`, `adm_profile`, `adm_fname`, `adm_lname`, `adm_username`, `adm_password`, `adm_email`, `adm_show`) VALUES
(1, 'profile_66388f22e9dfc7.46304157.png', 'อดิศักดิ์', 'คงสุข', 'Admin1', '$2y$10$c8su0r8rkfiEXYvx9mOsfudpm9IppLilbcBnuJiU2UEEqJpLYZvFS', 'Admin.General@gmail.com', 1),
(70, 'profile_6638c895e73a07.04858495.png', 'ภัทรภา', 'มนัสภร', 'Adminnnn2', '$2y$10$qt7UWxeNQ.T6jEJ9liLfvuObxTaPY3KxkqId5buUHoJ0EEReLLFeK', 'Adminnnn2@hotmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ot_cart`
--

DROP TABLE IF EXISTS `ot_cart`;
CREATE TABLE IF NOT EXISTS `ot_cart` (
  `mem_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า',
  `cart_quantity` int NOT NULL COMMENT 'จำนวน',
  KEY `mem_id` (`mem_id`),
  KEY `prd_id` (`prd_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ตะกร้าสินค้า';

-- --------------------------------------------------------

--
-- Table structure for table `ot_email`
--

DROP TABLE IF EXISTS `ot_email`;
CREATE TABLE IF NOT EXISTS `ot_email` (
  `em_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการ',
  `em_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อ-นามสกุล',
  `em_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `em_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รายละเอียด',
  `em_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'สถานะรายการ',
  `em_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วัน/เวลา',
  PRIMARY KEY (`em_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='รายการติดต่อ';

--
-- Dumping data for table `ot_email`
--

INSERT INTO `ot_email` (`em_id`, `em_name`, `em_email`, `em_detail`, `em_show`, `em_time`) VALUES
(2, 'นายเอ นามสมมุติ', 'aaaaa@gmail.com', 'ติดต่อขอลงขายสินค้า OTOP จังหวัดเชียงใหม่', 0, '2024-05-06 13:05:31');

-- --------------------------------------------------------

--
-- Table structure for table `ot_member`
--

DROP TABLE IF EXISTS `ot_member`;
CREATE TABLE IF NOT EXISTS `ot_member` (
  `mem_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสมาชิก',
  `mem_profile` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'โปรไฟล์',
  `mem_fname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อ',
  `mem_lname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'นามสกุล',
  `mem_username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อผู้ใช้',
  `mem_password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รหัสผ่าน',
  `mem_email` varchar(65) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `mem_show` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'แสดง/ไม่แสดง',
  PRIMARY KEY (`mem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลสมาชิก';

--
-- Dumping data for table `ot_member`
--

INSERT INTO `ot_member` (`mem_id`, `mem_profile`, `mem_fname`, `mem_lname`, `mem_username`, `mem_password`, `mem_email`, `mem_show`) VALUES
(22, 'profile_6638df409d5b08.46056785.png', 'ผู้ซื้อ', 'ทดลอง', 'Member11', '$2y$10$QsKdvKTWpMvIE5lGRNa6IO6Ms2SHm5IqdhxKVt4LYtF6.1Zz1gPym', 'Member11@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ot_order`
--

DROP TABLE IF EXISTS `ot_order`;
CREATE TABLE IF NOT EXISTS `ot_order` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสรายการ',
  `ord_id` int NOT NULL COMMENT 'รหัสออเดอร์',
  `mem_id` int NOT NULL COMMENT 'รหัสสมาชิก',
  `mem_fname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อ',
  `mem_lname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'นามสกุล',
  `mem_house_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'บ้านเลขที่, ตำบล',
  `mem_district` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อำเภอ/เขต',
  `mem_province` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'จังหวัด',
  `mem_zip_code` int NOT NULL COMMENT 'รหัสไปรษณีย์',
  `mem_tel` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เบอร์โทร',
  `mem_email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'อีเมล',
  `mem_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รายละเอียดเพิ่มเติม',
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า',
  `prd_price` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ราคาสินค้า',
  `cart_quantity` int NOT NULL COMMENT 'จำนวน',
  `cart_shipping_const` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '50' COMMENT 'ค่าส่ง',
  `cart_net_price` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ราคาสุทธิ',
  `ord_status` enum('รอชำระเงิน','รอตรวจสอบ','รอจัดส่ง','จัดส่งแล้ว','ยกเลิกรายการ') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'รอชำระเงิน' COMMENT 'สถานะรายการ',
  `ord_prd_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เลขพัสดุ',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'วัน/เวลา',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='รายการสั่งซื้อ';

--
-- Dumping data for table `ot_order`
--

INSERT INTO `ot_order` (`id`, `ord_id`, `mem_id`, `mem_fname`, `mem_lname`, `mem_house_number`, `mem_district`, `mem_province`, `mem_zip_code`, `mem_tel`, `mem_email`, `mem_detail`, `prd_id`, `prd_price`, `cart_quantity`, `cart_shipping_const`, `cart_net_price`, `ord_status`, `ord_prd_number`, `time`) VALUES
(66, 1, 22, 'ผู้ซื้อ', 'ทดลอง', 'บ้านเลขที่ 5/12 หมู่.5 ต.เมือง', 'เมือง', 'เพชรบุรี', 87651, '0258744325', 'Member11@gmail.com', 'บ้านหลังสีแดง', 40, '59', 2, '50', '1113', 'จัดส่งแล้ว', '68464646455', '2024-05-06 13:48:11'),
(67, 1, 22, 'ผู้ซื้อ', 'ทดลอง', 'บ้านเลขที่ 5/12 หมู่.5 ต.เมือง', 'เมือง', 'เพชรบุรี', 87651, '0258744325', 'Member11@gmail.com', 'บ้านหลังสีแดง', 42, '150', 4, '50', '1113', 'จัดส่งแล้ว', '68464646455', '2024-05-06 13:48:11'),
(68, 1, 22, 'ผู้ซื้อ', 'ทดลอง', 'บ้านเลขที่ 5/12 หมู่.5 ต.เมือง', 'เมือง', 'เพชรบุรี', 87651, '0258744325', 'Member11@gmail.com', 'บ้านหลังสีแดง', 39, '69', 5, '50', '1113', 'จัดส่งแล้ว', '68464646455', '2024-05-06 13:48:11'),
(69, 2, 22, 'ผู้ซื้อ', 'ทดลอง', '8 ,ม.5 ต.เม', 'แมว', 'ไก่', 78954, '9874563210', 'Member11@gmail.com', 'กกกกกก', 42, '150', 1, '50', '200', 'จัดส่งแล้ว', '6568469', '2024-05-06 14:11:41'),
(71, 3, 22, 'ผู้ซื้อ', 'ทดลอง', 'aa', 'aa', 'aa', 42752, '0984565577', 'Member11@gmail.com', '', 42, '150', 1, '50', '200', 'ยกเลิกรายการ', '', '2024-05-06 14:42:57'),
(72, 4, 22, 'ผู้ซื้อ', 'ทดลอง', 'wef', 'www', 'www', 88888, '8888888888', 'Member11@gmail.com', '', 41, '800', 1, '50', '850', 'รอชำระเงิน', '', '2024-05-06 14:54:04');

-- --------------------------------------------------------

--
-- Table structure for table `ot_order_slip`
--

DROP TABLE IF EXISTS `ot_order_slip`;
CREATE TABLE IF NOT EXISTS `ot_order_slip` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัส',
  `ord_id` int NOT NULL COMMENT 'รหัสออเดอร์',
  `ord_slip_img` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'สลิปหลักฐานโอนเงิน',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='หลักฐานการชำระเงิน';

--
-- Dumping data for table `ot_order_slip`
--

INSERT INTO `ot_order_slip` (`id`, `ord_id`, `ord_slip_img`) VALUES
(13, 1, 'slip_6638dfa08726d3.26078649.png'),
(14, 2, 'slip_6638e5240ac478.62291495.png'),
(15, 4, 'slip_6638ef4a14c581.67021429.png');

-- --------------------------------------------------------

--
-- Table structure for table `ot_payment`
--

DROP TABLE IF EXISTS `ot_payment`;
CREATE TABLE IF NOT EXISTS `ot_payment` (
  `pm_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสช่องทางโอนเงิน',
  `pm_qrcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รูปภาพ QR Code',
  `pm_bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อธนาคาร',
  `pm_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อบัญชี',
  `pm_number` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'เลขบัญชี',
  `pm_show` tinyint NOT NULL DEFAULT '0' COMMENT 'แสดง/ไม่แสดง',
  PRIMARY KEY (`pm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลช่องทางชำระเงิน';

--
-- Dumping data for table `ot_payment`
--

INSERT INTO `ot_payment` (`pm_id`, `pm_qrcode`, `pm_bank`, `pm_name`, `pm_number`, `pm_show`) VALUES
(8, 'qrcode_6638c2a75e4c18.79528911.png', 'ออมสิน', 'นายออมสิน สินออม', '12345678901112', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ot_product`
--

DROP TABLE IF EXISTS `ot_product`;
CREATE TABLE IF NOT EXISTS `ot_product` (
  `prd_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสสินค้า',
  `prd_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อสินค้า',
  `prd_price` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ราคา',
  `prd_amount` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'จำนวนในคลัง',
  `prd_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รายละเอียด',
  `pty_id` int NOT NULL COMMENT 'รหัสประเภทสินค้า',
  `prd_show` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'แสดง/ไม่แสดง',
  PRIMARY KEY (`prd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลสินค้า';

--
-- Dumping data for table `ot_product`
--

INSERT INTO `ot_product` (`prd_id`, `prd_name`, `prd_price`, `prd_amount`, `prd_detail`, `pty_id`, `prd_show`) VALUES
(37, 'ข้าวเหนียวดำออแกนิกส์', '80', '5', 'ข้าวเหนียวดำออร์แกนิกส์ ทางเลือกเพื่อสุขภาพที่ดีกว่า ปลูกโดยไม่ใช้สารเคมี ปลอดภัย อุดมไปด้วยคุณค่าทางโภชนาการ เหมาะกับทุกเพศทุกวัย', 22, 1),
(38, 'สวดีกาแฟ (น้ำกระเจี๊ยบ)', '10', '95', 'สวดีกาแฟเย็น เป็นผู้ผลิตขายปลีกและขายส่งน้ำกระเจี๊ยบเย็นแบบขวด มีขวดน้ำกระเจี๊ยบ 3ขนาด ให้ผู้บริโภคเลือกซื้อ สวดีกาแฟเย็น ผลิตน้ำกระเจี๊ยบพร้อมดื่มที่ผลิตจากท้องถิ่นเล็กๆใน อ.บ้านสร้าง จ.ปราจีนบุรี การันตีด้วยการคัดสรรเป็นผลิตภัณต์OTOP ของ จ.ปราจีนบุรี ผู้ผลิตมีความตั้งใจผลิตน้ำกระเจี๊ยบพร้อมดื่มคุณภาพดี คงความสดใหม่ของน้ำกระเจี๊ยบด้วยการผลิตวันต่อวัน กรรมวิธีการผลิตสะอาดถูกต้องตามมาตราฐาน และสวดีกาแฟพร้อมส่งมอบน้ำกระเจี๊ยบพร้อมดื่มคุณภาพดีถึงมือผู้บริโภค', 22, 1),
(39, 'พวงกุญแจถักไหมพรม', '69', '15', 'พวงกุญแจรูปเห็ด น่ารัก ถักด้วยมือขนาดเล็ก สำหรับห้อยกระเป๋าถือกระเป๋าเป้สะพายหลัง', 23, 1),
(40, 'พวงกุญแจลูกปัทมโนราห์', '59', '0', 'พวงกุญแจลูกปัทมโราห์ จากกลุ่มลูกปัทมโนราห์บ้านบ่อหว้า ตำบลเขาไม้แก้ว อำเภอสิเกา จังหวัดตรัง', 23, 1),
(41, 'ผ้ามัดหมี่', '800', '17', 'ผ้ามัดหมี่ เรณูนคร', 24, 1),
(42, 'ผ้าคลุมไหล่', '150', '23', 'ผ้าคุลไหล่มัดย้อม เนื้อผ้าเรยอน เบา สบาย ไม่ร้อน', 24, 1),
(43, 'น้ำมะขามเข้มข้น ตราแทมมิลี่', '79', '58', 'น้ำมะขามเข้มข้นเป็นน้ำผลไม้ที่ทำจากมะขามแบบเข้มข้นที่ผลิตจากวัตถุดิบ มีคุณภาพ ส่งเสริมสุขภาพให้ได้วิตามิน ซีสูงและช่วยให้สดชื่นจากพลังงานและช่วยด้านการขับถ่ายจากกากใยอาหารโดยสามารถผสมน้ำสุกหรือโซดาบริโภคได้ทั้งร้อนและเย็น', 22, 1),
(44, 'สร้อยข้อมือหินเสริมมงคล', '350', '32', 'สร้อยข้อมือหินเสริมมงคล ที่นเอาหินมงคลจากต่างประเทศมาร้อยเป็นเครื่องประดับ', 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ot_product_img`
--

DROP TABLE IF EXISTS `ot_product_img`;
CREATE TABLE IF NOT EXISTS `ot_product_img` (
  `prd_id` int NOT NULL COMMENT 'รหัสสินค้า',
  `prd_img_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รูปภาพสินค้า'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='รูปภาพสินค้า';

--
-- Dumping data for table `ot_product_img`
--

INSERT INTO `ot_product_img` (`prd_id`, `prd_img_name`) VALUES
(37, 'prd_6638bf16ea2385.57794907.png'),
(38, 'prd_6638c00f849a37.51962693.png'),
(39, 'prd_6638c079c407c2.51325700.png'),
(40, 'prd_6638c100c1d2e1.65518298.png'),
(41, 'prd_6638c13f282e16.98415873.png'),
(42, 'prd_6638c17f208eb0.00820688.png'),
(43, 'prd_6638c1d45e47d3.15529585.png'),
(44, 'prd_6638c21a96d823.12967746.png');

-- --------------------------------------------------------

--
-- Table structure for table `ot_product_type`
--

DROP TABLE IF EXISTS `ot_product_type`;
CREATE TABLE IF NOT EXISTS `ot_product_type` (
  `pty_id` int NOT NULL AUTO_INCREMENT COMMENT 'รหัสประเภทสินค้า',
  `pty_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'ชื่อประเภทสินค้า',
  `pty_detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รายละเอียดประเภทสินค้า',
  `pty_img` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'รูปประเภทสินค้า',
  `pty_show` tinyint NOT NULL DEFAULT '0' COMMENT 'แสดง/ ไม่แสดง',
  PRIMARY KEY (`pty_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='ข้อมูลประเภทสินค้า';

--
-- Dumping data for table `ot_product_type`
--

INSERT INTO `ot_product_type` (`pty_id`, `pty_name`, `pty_detail`, `pty_img`, `pty_show`) VALUES
(22, 'อาหารและเครื่องเดื่ม', 'อาหารและเครื่องเดื่ม', 'img_6638bdf978b283.09008440.png', 1),
(23, 'ของใช้และของประดับ', 'ของใช้และของประดับ', 'img_6638be2a3be017.81963256.png', 1),
(24, 'เสื้อผ้าและเครื่องแต่งกาย', 'เสื้อผ้าและเครื่องแต่งกาย', 'img_6638be9b014a43.00516394.png', 1),
(25, 'ยาและสมุนไพร', 'ยาและสมุนไพร', 'img_6638c901127e75.09909295.png', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ot_cart`
--
ALTER TABLE `ot_cart`
  ADD CONSTRAINT `ot_cart_ibfk_1` FOREIGN KEY (`mem_id`) REFERENCES `ot_member` (`mem_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ot_cart_ibfk_2` FOREIGN KEY (`prd_id`) REFERENCES `ot_product` (`prd_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
