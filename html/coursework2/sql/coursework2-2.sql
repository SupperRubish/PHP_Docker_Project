-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： mariadb
-- 生成日期： 2023-12-09 23:26:59
-- 服务器版本： 10.8.8-MariaDB-1:10.8.8+maria~ubu2204
-- PHP 版本： 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `coursework2`
--

-- --------------------------------------------------------

--
-- 表的结构 `Fines`
--

CREATE TABLE `Fines` (
  `Fine_ID` int(11) NOT NULL,
  `Fine_Amount` int(11) NOT NULL,
  `Fine_Points` int(11) NOT NULL,
  `Incident_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Fines`
--

INSERT INTO `Fines` (`Fine_ID`, `Fine_Amount`, `Fine_Points`, `Incident_ID`) VALUES
(1, 2000, 6, 3),
(2, 50, 0, 2),
(3, 500, 3, 4),
(8, 10000, 12, 12),
(9, 900, 1, 11),
(10, 900, 1, 9);

-- --------------------------------------------------------

--
-- 表的结构 `Incident`
--

CREATE TABLE `Incident` (
  `Incident_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) DEFAULT NULL,
  `People_ID` int(11) DEFAULT NULL,
  `Incident_Date` date NOT NULL,
  `Incident_Report` varchar(500) NOT NULL,
  `Offence_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Incident`
--

INSERT INTO `Incident` (`Incident_ID`, `Vehicle_ID`, `People_ID`, `Incident_Date`, `Incident_Report`, `Offence_ID`) VALUES
(1, 15, 4, '2017-12-01', '40mph in a 30 limit', 1),
(2, 20, 8, '2017-11-01', 'Double parked', 4),
(3, 13, 4, '2017-09-17', '110mph on motorway', 1),
(4, 14, 2, '2017-08-22', 'Failure to stop at a red light - travelling 25mph', 8),
(5, 13, 4, '2017-10-17', 'Not wearing a seatbelt on the M1', 3),
(6, 25, 19, '2023-11-15', '80km/h, nb', 1),
(9, 25, 19, '2023-11-23', '80km/h, nb', 1),
(10, 31, 17, '2023-11-22', '190km/h, nb', 1),
(11, 33, 10, '2023-12-06', 'kill 5 people', 9),
(12, 33, 19, '2023-12-07', 'kill people', 5);

-- --------------------------------------------------------

--
-- 表的结构 `Log`
--

CREATE TABLE `Log` (
  `Log_ID` int(11) NOT NULL,
  `U_ID` int(20) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Page` varchar(255) NOT NULL,
  `Action` varchar(255) NOT NULL,
  `Time` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 转存表中的数据 `Log`
--

INSERT INTO `Log` (`Log_ID`, `U_ID`, `Username`, `Page`, `Action`, `Time`) VALUES
(1, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:39:02.000000'),
(2, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:21.000000'),
(3, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:25.000000'),
(4, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:30.000000'),
(5, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:33.000000'),
(6, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:35.000000'),
(7, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:42.000000'),
(8, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:54.000000'),
(9, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:43:57.000000'),
(10, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 15:47:35.000000'),
(11, 3, 'daniels', 'selectCarByCid.php', 'Select Car which ID = 609QH', '2023-12-07 15:47:51.000000'),
(12, 3, 'daniels', 'addNewCar.php', 'Add new car 521csr for 520csr', '2023-12-07 15:54:50.000000'),
(13, 3, 'daniels', 'RecordFine.php', 'Provide Fine and Point for people', '2023-12-07 15:56:08.000000'),
(14, 3, 'daniels', 'Fine.php', 'Add fine for Incident_ID= 12', '2023-12-07 16:09:07.000000'),
(15, 3, 'daniels', 'selectCarByCid.php', 'Select Car which ID = 609QH', '2023-12-07 16:15:13.000000'),
(16, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-07 16:15:54.000000'),
(17, 3, 'daniels', 'Fine.php', 'Add fine for Incident_ID= 11', '2023-12-07 16:49:00.000000'),
(18, 3, 'daniels', 'Fine.php', 'Add fine for Incident_ID= 9', '2023-12-07 16:49:33.000000'),
(19, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-09 22:52:23.000000'),
(20, 3, 'daniels', 'SelectDataByNameOrNumber.php', 'Using name to select People', '2023-12-09 22:52:48.000000'),
(21, 3, 'daniels', 'selectCarByCid.php', 'Select Car which ID = 609QH', '2023-12-09 22:53:10.000000');

-- --------------------------------------------------------

--
-- 表的结构 `Offence`
--

CREATE TABLE `Offence` (
  `Offence_ID` int(11) NOT NULL,
  `Offence_description` varchar(50) NOT NULL,
  `Offence_maxFine` int(11) NOT NULL,
  `Offence_maxPoints` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Offence`
--

INSERT INTO `Offence` (`Offence_ID`, `Offence_description`, `Offence_maxFine`, `Offence_maxPoints`) VALUES
(1, 'Speeding', 1000, 3),
(2, 'Speeding on a motorway', 2500, 6),
(3, 'Seat belt offence', 500, 0),
(4, 'Illegal parking', 500, 0),
(5, 'Drink driving', 10000, 11),
(6, 'Driving without a licence', 10000, 0),
(7, 'Traffic light offences', 1000, 3),
(8, 'Cycling on pavement', 500, 0),
(9, 'Failure to have control of vehicle', 1000, 3),
(10, 'Dangerous driving', 1000, 11),
(11, 'Careless driving', 5000, 6),
(12, 'Dangerous cycling', 2500, 0);

-- --------------------------------------------------------

--
-- 表的结构 `Ownership`
--

CREATE TABLE `Ownership` (
  `People_ID` int(11) NOT NULL,
  `Vehicle_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Ownership`
--

INSERT INTO `Ownership` (`People_ID`, `Vehicle_ID`) VALUES
(3, 12),
(8, 20),
(4, 15),
(4, 13),
(1, 16),
(2, 14),
(5, 17),
(6, 18),
(7, 21),
(1, 25),
(12, 30),
(17, 31),
(18, 32),
(19, 33);

-- --------------------------------------------------------

--
-- 表的结构 `People`
--

CREATE TABLE `People` (
  `People_ID` int(11) NOT NULL,
  `People_name` varchar(50) NOT NULL,
  `People_address` varchar(50) DEFAULT NULL,
  `People_licence` varchar(16) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `People`
--

INSERT INTO `People` (`People_ID`, `People_name`, `People_address`, `People_licence`) VALUES
(1, 'James Smith', '23 Barnsdale Road, Leicester', 'SMITH92LDOFJJ829'),
(2, 'Jennifer Allen', '46 Bramcote Drive, Nottingham', 'ALLEN88K23KLR9B3'),
(3, 'John Myers', '323 Derby Road, Nottingham', 'MYERS99JDW8REWL3'),
(4, 'James Smith', '26 Devonshire Avenue, Nottingham', 'SMITHR004JFS20TR'),
(5, 'Terry Brown', '7 Clarke Rd, Nottingham', 'BROWND3PJJ39DLFG'),
(6, 'Mary Adams', '38 Thurman St, Nottingham', 'ADAMSH9O3JRHH107'),
(7, 'Neil Becker', '6 Fairfax Close, Nottingham', 'BECKE88UPR840F9R'),
(8, 'Angela Smith', '30 Avenue Road, Grantham', 'SMITH222LE9FJ5DS'),
(9, 'Xene Medora', '22 House Drive, West Bridgford', 'MEDORH914ANBB223'),
(10, 'cheng songrui', 'nottingham', '20545459'),
(12, 'zzz', 'zzz', 'zzz'),
(17, 'zhao dabao', 'nottingham', '1818192'),
(18, 'Kevin De Bruyne', 'Manchester', 'Kevin17'),
(19, 'JH', 'hang zhou liu zi', '520csr');

-- --------------------------------------------------------

--
-- 表的结构 `Users`
--

CREATE TABLE `Users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(225) NOT NULL,
  `Password` varchar(225) NOT NULL,
  `identity` varchar(12) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `Users`
--

INSERT INTO `Users` (`UserID`, `Username`, `Password`, `identity`) VALUES
(1, 'mcnulty', 'plod123', '0'),
(2, 'moreland', 'fuzz42', '0'),
(3, 'daniels', 'copper99', '1');

-- --------------------------------------------------------

--
-- 表的结构 `Vehicle`
--

CREATE TABLE `Vehicle` (
  `Vehicle_ID` int(11) NOT NULL,
  `Vehicle_type` varchar(20) NOT NULL,
  `Vehicle_colour` varchar(20) NOT NULL,
  `Vehicle_licence` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `Vehicle`
--

INSERT INTO `Vehicle` (`Vehicle_ID`, `Vehicle_type`, `Vehicle_colour`, `Vehicle_licence`) VALUES
(12, 'Ford Fiesta', 'Blue', 'LB15AJL'),
(13, 'Ferrari 458', 'Red', 'MY64PRE'),
(14, 'Vauxhall Astra', 'Silver', 'FD65WPQ'),
(15, 'Honda Civic', 'Green', 'FJ17AUG'),
(16, 'Toyota Prius', 'Silver', 'FP16KKE'),
(17, 'Ford Mondeo', 'Black', 'FP66KLM'),
(18, 'Ford Focus', 'White', 'DJ14SLE'),
(20, 'Nissan Pulsar', 'Red', 'NY64KWD'),
(21, 'Renault Scenic', 'Silver', 'BC16OEA'),
(22, 'Hyundai i30', 'Grey', 'AD223NG'),
(25, 'x5', 'red', '609QH'),
(26, 'e300', 'blue', '802QY'),
(30, 'sfsffs', 'fsfsfs', 'sfsfs'),
(31, 'x5', 'green', '110120119'),
(32, 'Jaguar', 'silver', 'KDB14MC'),
(33, 's350', 'colourful', '521csr');

--
-- 转储表的索引
--

--
-- 表的索引 `Fines`
--
ALTER TABLE `Fines`
  ADD PRIMARY KEY (`Fine_ID`),
  ADD KEY `fk_fines_incident` (`Incident_ID`);

--
-- 表的索引 `Incident`
--
ALTER TABLE `Incident`
  ADD PRIMARY KEY (`Incident_ID`),
  ADD KEY `fk_incident_offence` (`Offence_ID`),
  ADD KEY `fk_incident_people` (`People_ID`),
  ADD KEY `fk_incident_vehicle` (`Vehicle_ID`);

--
-- 表的索引 `Log`
--
ALTER TABLE `Log`
  ADD PRIMARY KEY (`Log_ID`),
  ADD KEY `cw_log_user` (`U_ID`);

--
-- 表的索引 `Offence`
--
ALTER TABLE `Offence`
  ADD PRIMARY KEY (`Offence_ID`);

--
-- 表的索引 `Ownership`
--
ALTER TABLE `Ownership`
  ADD KEY `fk_ownership_people` (`People_ID`),
  ADD KEY `fk_ownership_vehicle` (`Vehicle_ID`);

--
-- 表的索引 `People`
--
ALTER TABLE `People`
  ADD PRIMARY KEY (`People_ID`),
  ADD UNIQUE KEY `People_licence` (`People_licence`);

--
-- 表的索引 `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserID`);

--
-- 表的索引 `Vehicle`
--
ALTER TABLE `Vehicle`
  ADD PRIMARY KEY (`Vehicle_ID`),
  ADD UNIQUE KEY `Vehicle_licence` (`Vehicle_licence`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `Fines`
--
ALTER TABLE `Fines`
  MODIFY `Fine_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `Incident`
--
ALTER TABLE `Incident`
  MODIFY `Incident_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `Log`
--
ALTER TABLE `Log`
  MODIFY `Log_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- 使用表AUTO_INCREMENT `People`
--
ALTER TABLE `People`
  MODIFY `People_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用表AUTO_INCREMENT `Users`
--
ALTER TABLE `Users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `Vehicle`
--
ALTER TABLE `Vehicle`
  MODIFY `Vehicle_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- 限制导出的表
--

--
-- 限制表 `Fines`
--
ALTER TABLE `Fines`
  ADD CONSTRAINT `fk_fines_incident` FOREIGN KEY (`Incident_ID`) REFERENCES `Incident` (`Incident_ID`);

--
-- 限制表 `Incident`
--
ALTER TABLE `Incident`
  ADD CONSTRAINT `fk_incident_offence` FOREIGN KEY (`Offence_ID`) REFERENCES `Offence` (`Offence_ID`),
  ADD CONSTRAINT `fk_incident_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  ADD CONSTRAINT `fk_incident_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`);

--
-- 限制表 `Log`
--
ALTER TABLE `Log`
  ADD CONSTRAINT `cw_log_user` FOREIGN KEY (`U_ID`) REFERENCES `Users` (`UserID`);

--
-- 限制表 `Ownership`
--
ALTER TABLE `Ownership`
  ADD CONSTRAINT `fk_ownership_people` FOREIGN KEY (`People_ID`) REFERENCES `People` (`People_ID`),
  ADD CONSTRAINT `fk_ownership_vehicle` FOREIGN KEY (`Vehicle_ID`) REFERENCES `Vehicle` (`Vehicle_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
