-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 02:25 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 7.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `do`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AP_ID` int(11) NOT NULL,
  `AP_RU_ID` int(11) NOT NULL,
  `AP_RD_ID` int(11) NOT NULL,
  `AP_DATE` date NOT NULL,
  `AP_TIME_SLOT` time NOT NULL,
  `AP_STATUS` enum('Active','Treated','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `CITY_CODE` int(11) NOT NULL,
  `CITY_NAME` varchar(30) NOT NULL,
  `STATE_CODE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`CITY_CODE`, `CITY_NAME`, `STATE_CODE`) VALUES
(1, 'AHMEDABAD', 7),
(2, 'VADODARA', 7),
(3, 'RAJKOT', 7),
(4, 'SURAT', 7),
(5, 'GANDHINAGAR', 7),
(6, 'MUMBAI', 15),
(7, 'PUNE', 15),
(8, 'NASHIK', 15),
(9, 'AURANGABAD', 15),
(10, 'KOLHAPUR', 15),
(11, 'BHOPAL', 14),
(12, 'INDORE', 14),
(13, 'GWALIER', 14),
(14, 'ITARASI', 14),
(15, 'KHANDWA', 14),
(16, 'UJJAIN', 14),
(17, 'BHARUCH', 7),
(18, 'VALSAD', 7),
(20, 'NAVSARI', 7),
(21, 'ANAND', 7);

-- --------------------------------------------------------

--
-- Table structure for table `dna_schedule`
--

CREATE TABLE `dna_schedule` (
  `DNA_RD_ID` int(11) NOT NULL,
  `DNA_STDATE` date NOT NULL,
  `DNA_ENDATE` date NOT NULL,
  `DNA_WK_SRNO` int(11) NOT NULL,
  `DNA_ME_CODE` int(11) NOT NULL,
  `DNA_CREATEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DNA_MODIFIEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `doctors_schedule`
--

CREATE TABLE `doctors_schedule` (
  `DS_RD_ID` int(11) NOT NULL,
  `DS_WK_SRNO` int(11) NOT NULL,
  `DS_WK_STDATE` date DEFAULT NULL,
  `DS_WK_ENDATE` date DEFAULT NULL,
  `DS_AVAILABLE_DAYS` varchar(12) DEFAULT NULL,
  `DS_MOPD_SLOTS` int(11) DEFAULT NULL,
  `DS_EOPD_SLOTS` int(11) DEFAULT NULL,
  `DS_MAPP_STATUS` varchar(1024) DEFAULT NULL,
  `DS_EAPP_STATUS` varchar(1024) DEFAULT NULL,
  `DS_CREATEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DS_UPDATEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `LOC_CODE` int(11) NOT NULL,
  `LOCATION` varchar(30) NOT NULL,
  `CITY_CODE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`LOC_CODE`, `LOCATION`, `CITY_CODE`) VALUES
(1, 'ALKAPURI', 2),
(2, 'RACECOURSE', 2),
(3, 'AKOTA', 2),
(4, 'SAYAJIGUNJ', 2),
(5, 'FETEHGUNJ', 2),
(6, 'NIZAMPURA', 2),
(7, 'GORWA', 2),
(8, 'AJWA ROAD', 2),
(9, 'WAGHODIA ROAD', 2),
(12, 'GOTRI', 2);

-- --------------------------------------------------------

--
-- Table structure for table `opd_timings`
--

CREATE TABLE `opd_timings` (
  `OPD_TIME_CODE` int(11) NOT NULL,
  `OPD_TIME_NAME` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `opd_timings`
--

INSERT INTO `opd_timings` (`OPD_TIME_CODE`, `OPD_TIME_NAME`) VALUES
(1, 'MORNING'),
(2, 'EVENING'),
(3, 'MORN+EVEN');

-- --------------------------------------------------------

--
-- Table structure for table `prefix_mast`
--

CREATE TABLE `prefix_mast` (
  `PREFIX_CODE` int(11) NOT NULL,
  `PREFIX_NAME` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prefix_mast`
--

INSERT INTO `prefix_mast` (`PREFIX_CODE`, `PREFIX_NAME`) VALUES
(1, 'Mr.'),
(2, 'Mrs.'),
(3, 'Miss');

-- --------------------------------------------------------

--
-- Table structure for table `regadmin`
--

CREATE TABLE `regadmin` (
  `RA_ID` int(11) NOT NULL,
  `RA_PREFIX_CD` int(11) NOT NULL,
  `RA_NAME` varchar(55) DEFAULT NULL,
  `RA_GENDER` enum('Male','Female') DEFAULT NULL,
  `RA_LOGIN_ID` varchar(30) NOT NULL,
  `RA_PSWD` varchar(30) NOT NULL,
  `RA_EMAIL` varchar(30) DEFAULT NULL,
  `RA_MOB_PRFX` varchar(1) DEFAULT '+',
  `RA_COUNTRY_PRFX` int(5) DEFAULT '91',
  `RA_MOBILE` bigint(20) NOT NULL,
  `RA_LL_PHONE` bigint(20) NOT NULL,
  `RA_ADDRESS` varchar(160) DEFAULT NULL,
  `RA_LOC_CD` int(11) NOT NULL,
  `RA_CREATEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RA_MODIFIEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RA_STATUS` enum('Active','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `regadmin`
--

INSERT INTO `regadmin` (`RA_ID`, `RA_PREFIX_CD`, `RA_NAME`, `RA_GENDER`, `RA_LOGIN_ID`, `RA_PSWD`, `RA_EMAIL`, `RA_MOB_PRFX`, `RA_COUNTRY_PRFX`, `RA_MOBILE`, `RA_LL_PHONE`, `RA_ADDRESS`, `RA_LOC_CD`, `RA_CREATEDON`, `RA_MODIFIEDON`, `RA_STATUS`) VALUES
(2, 1, 'ANIL', 'Male', 'anil376', 'kerberos', 'deshmukh.anil30@gmail.com', '+', 91, 9925208865, 2652324414, 'GOTRI BARODA', 1, '2015-12-04 08:18:21', '2015-12-04 08:18:21', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `regdoctor`
--

CREATE TABLE `regdoctor` (
  `RD_ID` int(11) NOT NULL,
  `RD_PREFIX_CD` int(11) NOT NULL,
  `RD_NAME` varchar(55) DEFAULT NULL,
  `RD_GENDER` enum('Male','Female') DEFAULT NULL,
  `RD_QUALI` varchar(55) NOT NULL,
  `RD_SP_CD` int(11) NOT NULL,
  `RD_MRNO` varchar(55) NOT NULL,
  `RD_LOGIN_ID` varchar(30) NOT NULL,
  `RD_PSWD` varchar(30) NOT NULL,
  `RD_MOB_PRFX` varchar(1) DEFAULT '+',
  `RD_COUNTRY_PRFX` int(5) DEFAULT '91',
  `RD_MOBILE` bigint(15) NOT NULL,
  `RD_EMAIL` varchar(30) DEFAULT NULL,
  `RD_CLINIC_LL` bigint(20) DEFAULT NULL,
  `RD_CLINIC_ADDRESS` varchar(160) DEFAULT NULL,
  `RD_RESID_LL` bigint(20) DEFAULT NULL,
  `RD_RESID_ADDRESS` varchar(160) DEFAULT NULL,
  `RD_CHARGE_I` float DEFAULT NULL,
  `RD_CHARGE_II` float DEFAULT NULL,
  `RD_MOPD_FROM` time DEFAULT NULL,
  `RD_MOPD_TO` time DEFAULT NULL,
  `RD_EOPD_FROM` time DEFAULT NULL,
  `RD_EOPD_TO` time DEFAULT NULL,
  `RD_APP_SLOT` time DEFAULT NULL,
  `RD_LOC_CD` int(11) NOT NULL,
  `RD_CREATEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RD_MODIFIEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RD_STATUS` enum('Active','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `regdoctor`
--

INSERT INTO `regdoctor` (`RD_ID`, `RD_PREFIX_CD`, `RD_NAME`, `RD_GENDER`, `RD_QUALI`, `RD_SP_CD`, `RD_MRNO`, `RD_LOGIN_ID`, `RD_PSWD`, `RD_MOB_PRFX`, `RD_COUNTRY_PRFX`, `RD_MOBILE`, `RD_EMAIL`, `RD_CLINIC_LL`, `RD_CLINIC_ADDRESS`, `RD_RESID_LL`, `RD_RESID_ADDRESS`, `RD_CHARGE_I`, `RD_CHARGE_II`, `RD_MOPD_FROM`, `RD_MOPD_TO`, `RD_EOPD_FROM`, `RD_EOPD_TO`, `RD_APP_SLOT`, `RD_LOC_CD`, `RD_CREATEDON`, `RD_MODIFIEDON`, `RD_STATUS`) VALUES
(1, 1, 'ASHOK VAISHNAVI', 'Male', 'MBBS, MD', 22, 'GJ/JAM/ORTH/164/1979', 'asv', 'asv', '+', 91, 9925208865, 'asv@gebmail.com', 2652324414, '  ELLORA PARK,\r\nNEAR ATMA JYOTI ASHRAM,\r\nVADODARA \r\n390019  ', 2652324414, 'OM ORTHOPEDIC HOSPITAL,\r\nABOVE AMANTRAN HOTEL,\r\nSAMPATRAO COLONY,\r\nVADODARA \r\n390007', 300, 200, '11:00:00', '14:00:00', '17:00:00', '20:30:00', '00:15:00', 1, '2015-12-04 13:30:27', '2015-12-11 12:01:11', 'Active'),
(2, 2, 'MEERA VAISHNAVI', 'Female', 'MBBS, MD', 19, 'JK/SH/899/1983', 'mav', 'mav', '+', 91, 9925208865, 'mav@gebmail.com', 2652324414, '   ELLORA PARK, \r\nVADODARA   ', 2652324414, 'ELLORA PARK,\r\nVADODARA', 300, 200, '11:00:00', '14:00:00', '17:00:00', '20:00:00', '00:15:00', 3, '2015-12-04 13:36:09', '2015-12-11 12:03:20', 'Active'),
(3, 1, 'IC PATEL', 'Male', 'MBBS', 12, 'GJ/699', 'icp', 'icp', '+', 91, 9925208865, 'icp@gebmail.com', 2652324414, 'PARESHNAGAR\r\nWADI\r\nBARODA', 2652324414, 'KARELIBAUG,\r\nVADODARA', 100, 80, '00:00:00', '00:00:00', '17:00:00', '22:00:00', '00:10:00', 8, '2015-12-11 12:30:47', '2015-12-11 12:30:47', 'Active'),
(4, 1, 'ATUL MHASLEKAR', 'Male', 'MS', 33, 'DL/155', 'amh', 'amh', '+', 91, 9925208865, 'amh@gebmail.com', 2652324414, 'ELLORA PARK', 2652324414, 'VADODARA', 500, 300, '00:00:00', '00:00:00', '16:00:00', '20:00:00', '00:15:00', 2, '2015-12-12 16:54:56', '2015-12-12 16:54:56', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `reguser`
--

CREATE TABLE `reguser` (
  `RU_ID` int(11) NOT NULL,
  `RU_PREFIX_CD` int(11) NOT NULL,
  `RU_NAME` varchar(55) NOT NULL,
  `RU_GENDER` enum('Male','Female') DEFAULT NULL,
  `RU_LOGIN_ID` varchar(30) NOT NULL,
  `RU_PSWD` varchar(30) NOT NULL,
  `RU_MOB_PRFX` varchar(1) DEFAULT '+',
  `RU_COUNTRY_PRFX` int(5) DEFAULT '91',
  `RU_MOBILE` bigint(20) NOT NULL,
  `RU_LL_PHONE` bigint(20) DEFAULT NULL,
  `RU_EMAIL` varchar(30) DEFAULT NULL,
  `RU_ADDRESS` varchar(160) DEFAULT NULL,
  `RU_LOC_CD` int(11) NOT NULL,
  `RU_CREATEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `RU_MODIFIEDON` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `RU_STATUS` enum('Active','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reguser`
--

INSERT INTO `reguser` (`RU_ID`, `RU_PREFIX_CD`, `RU_NAME`, `RU_GENDER`, `RU_LOGIN_ID`, `RU_PSWD`, `RU_MOB_PRFX`, `RU_COUNTRY_PRFX`, `RU_MOBILE`, `RU_LL_PHONE`, `RU_EMAIL`, `RU_ADDRESS`, `RU_LOC_CD`, `RU_CREATEDON`, `RU_MODIFIEDON`, `RU_STATUS`) VALUES
(1, 1, 'ANIL', 'Male', 'ajd', 'rely', '+', 91, 9925208865, 2652324414, 'ajd@gebmail.com', '24/B, SMITA PARK SOCIETY,\nBEHIND MOTHERS SCHOOL,\nGOTRI ROAD,\nVADODARA 390021', 12, '2015-12-04 13:11:04', '2015-12-04 13:11:27', 'Active'),
(2, 2, 'MOKSHA', 'Female', 'mks', 'mks', '+', 91, 9925208865, 2652324414, 'mks@gebmail.com', '11/A, KRISHNA PARK SOCIETY,\r\nNEAR MEHASANA NAGAR GARABA GROUND,\r\nNIZAMPURA,\r\nVADODARA 390015\r\n', 6, '2015-12-04 13:13:25', '2015-12-04 13:13:25', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `speciality`
--

CREATE TABLE `speciality` (
  `SP_CODE` int(11) NOT NULL,
  `SPECIALITY` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `speciality`
--

INSERT INTO `speciality` (`SP_CODE`, `SPECIALITY`) VALUES
(1, 'ALLERGY IMMUNOLOGY'),
(2, 'ANESTHESIOLOGY'),
(3, 'CARDIDIOLOGY'),
(4, 'CARDIOVASCULAR HEALTH'),
(5, 'COMBINED SPECIALITY'),
(6, 'DERMATOLOGY'),
(7, 'DENTAL'),
(8, 'EMERGENCY MEDICINE'),
(9, 'ENDOCRINOLOGY DAIBETES METABOLISM'),
(10, 'FAMILY MEDICINE'),
(11, 'GASTROENTEROLOGY'),
(12, 'GENERAL PRACTICE'),
(13, 'INFECTIOUS DISEASE'),
(14, 'GENERAL INTERNAL MEDICINE'),
(15, 'MEDICAL GENETICS'),
(16, 'NEPHROLOGY'),
(17, 'NEUROLOGICAL SURGERY'),
(18, 'NEUROLOGY'),
(19, 'OBSTETRICS GYNECOLOGY'),
(20, 'ONCOLOGY CANCER'),
(21, 'OPTHALMOLOGY'),
(22, 'ORTHOPEDICS'),
(23, 'OTHERS'),
(24, 'OTOLARYNGOLOGY'),
(25, 'PATHOLOGY'),
(26, 'PEDIATRICS'),
(27, 'PHYSICAL MEDICINE REHABILITATION'),
(28, 'PLASTIC SURGERY'),
(29, 'PREVENTIVE MEDICINE'),
(30, 'PSYCHIATRY'),
(31, 'RADIOLOGY'),
(32, 'RHEUMATOLOGY'),
(33, 'SURGERY'),
(34, 'UROLOGY');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `STATE_CODE` int(11) NOT NULL,
  `STATE_NAME` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`STATE_CODE`, `STATE_NAME`) VALUES
(1, 'ANDHRA PRADESH'),
(2, 'ARUNACHAL PRADESH'),
(3, 'ASSAM'),
(4, 'BIHAR'),
(5, 'CHHATTISGARH'),
(6, 'GOA'),
(7, 'GUJARAT'),
(8, 'HARYANA'),
(9, 'HIMACHAL PRADESH'),
(10, 'JAMMU & KASHMIR'),
(11, 'JHARKHAND'),
(12, 'KARNATAKA'),
(13, 'KERALA'),
(14, 'MADHYA PRADESH'),
(15, 'MAHARASHTRA'),
(16, 'MANIPUR'),
(17, 'MEGHALAYA'),
(18, 'MIZORAM'),
(19, 'ODISHA (Orissa)'),
(20, 'PUNJAB'),
(21, 'RAJASTHAN'),
(22, 'SIKKIM'),
(23, 'TAMILNADU'),
(24, 'TELANGANA'),
(25, 'TRIPURA'),
(26, 'UTTAR PRADESH'),
(27, 'UTTARAKHAND'),
(28, 'WEST BENGAL');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `T_APID` int(11) NOT NULL,
  `T_DIAGNOSIS` varchar(255) DEFAULT NULL,
  `T_TREATMENT` varchar(255) DEFAULT NULL,
  `T_REMARKS` varchar(255) DEFAULT NULL,
  `T_STATUS` enum('Active','Treated','Cancelled') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_history`
--

CREATE TABLE `user_history` (
  `UH_SRNO` int(11) NOT NULL,
  `UH_USER_ID` int(11) NOT NULL,
  `UH_SYMPTOMS` varchar(250) DEFAULT NULL,
  `UH_PREV_DOCT` varchar(100) DEFAULT NULL,
  `UH_TREATED_FROM` date DEFAULT NULL,
  `UH_TREATED_TO` date DEFAULT NULL,
  `UH_PREV_DIAG` varchar(100) DEFAULT NULL,
  `UH_PREV_TREATMENT` varchar(100) DEFAULT NULL,
  `UH_STATUS` enum('Active','Inactive') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AP_ID`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`CITY_CODE`),
  ADD KEY `STATE_CODE` (`STATE_CODE`);

--
-- Indexes for table `dna_schedule`
--
ALTER TABLE `dna_schedule`
  ADD PRIMARY KEY (`DNA_RD_ID`,`DNA_STDATE`,`DNA_ENDATE`);

--
-- Indexes for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  ADD PRIMARY KEY (`DS_RD_ID`,`DS_WK_SRNO`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`LOC_CODE`),
  ADD KEY `CITY_CODE` (`CITY_CODE`);

--
-- Indexes for table `opd_timings`
--
ALTER TABLE `opd_timings`
  ADD PRIMARY KEY (`OPD_TIME_CODE`);

--
-- Indexes for table `prefix_mast`
--
ALTER TABLE `prefix_mast`
  ADD PRIMARY KEY (`PREFIX_CODE`);

--
-- Indexes for table `regadmin`
--
ALTER TABLE `regadmin`
  ADD PRIMARY KEY (`RA_ID`),
  ADD KEY `RA_PREFIX_CD` (`RA_PREFIX_CD`);

--
-- Indexes for table `regdoctor`
--
ALTER TABLE `regdoctor`
  ADD PRIMARY KEY (`RD_ID`),
  ADD KEY `RD_PREFIX_CD` (`RD_PREFIX_CD`),
  ADD KEY `RD_LOC_CD` (`RD_LOC_CD`);

--
-- Indexes for table `reguser`
--
ALTER TABLE `reguser`
  ADD PRIMARY KEY (`RU_ID`),
  ADD KEY `RU_PREFIX_CD` (`RU_PREFIX_CD`),
  ADD KEY `RU_LOC_CD` (`RU_LOC_CD`);

--
-- Indexes for table `speciality`
--
ALTER TABLE `speciality`
  ADD PRIMARY KEY (`SP_CODE`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`STATE_CODE`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`T_APID`);

--
-- Indexes for table `user_history`
--
ALTER TABLE `user_history`
  ADD PRIMARY KEY (`UH_SRNO`),
  ADD KEY `UH_USER_ID` (`UH_USER_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AP_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `CITY_CODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `LOC_CODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `opd_timings`
--
ALTER TABLE `opd_timings`
  MODIFY `OPD_TIME_CODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `prefix_mast`
--
ALTER TABLE `prefix_mast`
  MODIFY `PREFIX_CODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `regadmin`
--
ALTER TABLE `regadmin`
  MODIFY `RA_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `regdoctor`
--
ALTER TABLE `regdoctor`
  MODIFY `RD_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `reguser`
--
ALTER TABLE `reguser`
  MODIFY `RU_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `speciality`
--
ALTER TABLE `speciality`
  MODIFY `SP_CODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `STATE_CODE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `T_APID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_history`
--
ALTER TABLE `user_history`
  MODIFY `UH_SRNO` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
  ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`STATE_CODE`) REFERENCES `state` (`STATE_CODE`);

--
-- Constraints for table `dna_schedule`
--
ALTER TABLE `dna_schedule`
  ADD CONSTRAINT `dna_schedule_ibfk_1` FOREIGN KEY (`DNA_RD_ID`) REFERENCES `regdoctor` (`RD_ID`);

--
-- Constraints for table `doctors_schedule`
--
ALTER TABLE `doctors_schedule`
  ADD CONSTRAINT `doctors_schedule_ibfk_1` FOREIGN KEY (`DS_RD_ID`) REFERENCES `regdoctor` (`RD_ID`);

--
-- Constraints for table `location`
--
ALTER TABLE `location`
  ADD CONSTRAINT `location_ibfk_1` FOREIGN KEY (`CITY_CODE`) REFERENCES `city` (`CITY_CODE`);

--
-- Constraints for table `regadmin`
--
ALTER TABLE `regadmin`
  ADD CONSTRAINT `regadmin_ibfk_1` FOREIGN KEY (`RA_PREFIX_CD`) REFERENCES `prefix_mast` (`PREFIX_CODE`);

--
-- Constraints for table `regdoctor`
--
ALTER TABLE `regdoctor`
  ADD CONSTRAINT `regdoctor_ibfk_1` FOREIGN KEY (`RD_PREFIX_CD`) REFERENCES `prefix_mast` (`PREFIX_CODE`),
  ADD CONSTRAINT `regdoctor_ibfk_2` FOREIGN KEY (`RD_LOC_CD`) REFERENCES `location` (`LOC_CODE`);

--
-- Constraints for table `reguser`
--
ALTER TABLE `reguser`
  ADD CONSTRAINT `reguser_ibfk_1` FOREIGN KEY (`RU_PREFIX_CD`) REFERENCES `prefix_mast` (`PREFIX_CODE`),
  ADD CONSTRAINT `reguser_ibfk_2` FOREIGN KEY (`RU_LOC_CD`) REFERENCES `location` (`LOC_CODE`);

--
-- Constraints for table `user_history`
--
ALTER TABLE `user_history`
  ADD CONSTRAINT `user_history_ibfk_1` FOREIGN KEY (`UH_USER_ID`) REFERENCES `reguser` (`RU_ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
