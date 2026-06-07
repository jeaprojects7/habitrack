-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2026 at 11:59 AM
-- Server version: 8.4.3
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `habitrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `adminID` varchar(11) NOT NULL,
  `adminFName` varchar(50) NOT NULL,
  `adminLName` varchar(50) NOT NULL,
  `adminMName` varchar(50) NOT NULL,
  `adminSuffix` varchar(10) NOT NULL,
  `adminEmail` varchar(30) NOT NULL,
  `adminPhoneNum` varchar(11) NOT NULL,
  `adminPass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `adminID`, `adminFName`, `adminLName`, `adminMName`, `adminSuffix`, `adminEmail`, `adminPhoneNum`, `adminPass`) VALUES
(1, 'C0001', 'admin', 'admin', 'admin', 'admin', 'admin', '1', 'admin'),
(2, 'AD0002', 'admin1', 'admin1', 'admin1', 'admin1', 'admin1', '2', '$2y$10$2WfTv5b1ATpCDlDrHlGSzekfk6Iz2OoWQFwx60qbvxMzUpyNUtM7S');

-- --------------------------------------------------------

--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `id` int NOT NULL,
  `agentID` varchar(11) NOT NULL,
  `agentFName` varchar(50) NOT NULL,
  `agentLName` varchar(50) NOT NULL,
  `agentMName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agentSuffix` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agentEmail` varchar(30) NOT NULL,
  `agentPhoneNum` varchar(11) NOT NULL,
  `agentPass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `agentPic` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agentAddress` varchar(100) NOT NULL,
  `agentSoldUnits` int DEFAULT '0',
  `agentFB` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agentGender` enum('Male','Female') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `agentBirthdate` date DEFAULT NULL,
  `agentStatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`id`, `agentID`, `agentFName`, `agentLName`, `agentMName`, `agentSuffix`, `agentEmail`, `agentPhoneNum`, `agentPass`, `agentPic`, `agentAddress`, `agentSoldUnits`, `agentFB`, `agentGender`, `agentBirthdate`, `agentStatus`) VALUES
(1, 'AG0001', 'Jea', 'Calvo', 'Ela', NULL, 'jea@gmail.com', '09653284221', '$2y$10$pmIFuoL/PyJcBsJk8uFnMernWmsvbuVkOxbzGmlLNzwMkmM91xuJq', '/uploads/agents/agent_20260607084202_222ef188.jpg', 'Bacolod', 1, 'Heya Mari', 'Female', '2013-06-06', 'Active'),
(2, 'AG0002', 'Allen', 'Calvo', 'Ela', NULL, 'jea2@gmail.com', '09653284221', '$2y$10$8WQqM.ULKGMUeZarkBaJ5O4STlsZu7f93DHQznezm4m3vObhT3kte', '/uploads/agents/agent_20260607084911_fb2d7ebe.jpg', 'Silay', 2, NULL, 'Female', '2013-06-06', 'Active'),
(3, 'AG0003', 'Yuu', 'Jeniel', 'Jae', NULL, 'yuujaedc@gmail.com', '09658954669', '$2y$10$M3rB7WIbEUgLwCluwPmSZejJbJSSuPy3kzTEmrNN8MBOk36MOGV.S', NULL, 'Bacolod', 1, NULL, 'Female', '2005-06-02', 'Active'),
(4, 'AG0004', 'Eun', 'Abujan', 'Ari', NULL, 'eunicemarii29@gmail.com', '09856854225', '$2y$10$6IgIAisxJRlfg86JFtVD8e3o/m0zpupbYAUM1eGNfh9dyRz/4LKGq', NULL, 'Bacolod', 1, NULL, 'Female', '2006-06-02', 'Active'),
(5, 'AG0005', 'Azhee', 'Andrea', 'Mari', NULL, 'azheelandrea@gmail.com', '03991648552', '$2y$10$t.Roa3TedNptPww6LMhzhe1evl17XBFKBMliQbahNc5MnmPmWFl5i', '/uploads/agents/agent_20260607104843_2dbe946a.jpg', 'Canlaon City', 1, 'Azhee Val', 'Female', '2006-09-22', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `id` int NOT NULL,
  `clientID` varchar(11) NOT NULL,
  `clientFName` varchar(50) NOT NULL,
  `clientMName` varchar(50) NOT NULL,
  `clientLName` varchar(50) NOT NULL,
  `clientSuffix` varchar(10) NOT NULL,
  `clientEmail` varchar(30) NOT NULL,
  `clientPhoneNum` varchar(11) NOT NULL,
  `clientPass` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `clientID`, `clientFName`, `clientMName`, `clientLName`, `clientSuffix`, `clientEmail`, `clientPhoneNum`, `clientPass`) VALUES
(1, 'C0001', 'Jewel', 'Alfie', 'Marsi', '', 'jewel@gmail.com', '09476545672', '$2y$10$WN/qxA2ShmKjmJ2iv1NlrevqcarNgNzDUzPWn8VZR2doII4b4KKGO'),
(2, 'C0002', 'Allen', 'Jewel', 'Sarmiento', '', 'allen@gmail.com', '09885658442', '$2y$10$G4kzYO2e2AXVj7Ej0QxO6e7okcR3ZSJQkychW4U2IsgJq1OJN4z96'),
(3, 'C0003', 'Frances', 'Jew', 'Marcel', '', 'frances@gmail.com', '09889562335', '$2y$10$QKQINGuy4ZBFP7u43TcEIOp3q3lr0IBJBVLhdR3BBgBP1vp0shhdm');

-- --------------------------------------------------------

--
-- Table structure for table `clientcoprequal`
--

CREATE TABLE `clientcoprequal` (
  `id` int NOT NULL,
  `coOwnerID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `prequalID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `financingID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerRelationship` varchar(11) DEFAULT NULL,
  `coOwnerFName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerMName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerLName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerSuffix` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerEmail` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerPhoneNum` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerEmpStatus` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coOwnerMonthlyIncome` decimal(20,2) DEFAULT NULL,
  `coFinancingType` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coContributionStart` date DEFAULT NULL,
  `coCurrentLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coBankName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coExistingHouseLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coCancelledHouseLoan` enum('Yes','No') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coFinancingStatus` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `clientcoprequal`
--

INSERT INTO `clientcoprequal` (`id`, `coOwnerID`, `prequalID`, `financingID`, `coOwnerRelationship`, `coOwnerFName`, `coOwnerMName`, `coOwnerLName`, `coOwnerSuffix`, `coOwnerEmail`, `coOwnerPhoneNum`, `coOwnerEmpStatus`, `coOwnerMonthlyIncome`, `coFinancingType`, `coContributionStart`, `coCurrentLoan`, `coBankName`, `coExistingHouseLoan`, `coCancelledHouseLoan`, `coFinancingStatus`) VALUES
(1, 'CP0001', 'PQ0004', 'FN0004', 'Spouse', 'Arldri', 'A', 'Marcel', '', 'arldri@gmail.com', '09655622448', 'local', 100000.00, 'bank', NULL, NULL, 'BDO', 'No', 'No', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `client_information`
--

CREATE TABLE `client_information` (
  `id` int NOT NULL,
  `clientCISID` varchar(11) NOT NULL,
  `prequalID` varchar(11) DEFAULT NULL,
  `clientCitizenship` varchar(50) NOT NULL,
  `clientGender` enum('Male','Female') NOT NULL,
  `clientReligion` varchar(50) NOT NULL,
  `clientBirthdate` date NOT NULL,
  `clientPlaceOfBirth` varchar(50) NOT NULL,
  `clientAddress` varchar(100) NOT NULL,
  `clientProvinceAddress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `clientTaxIdenNum` varchar(15) NOT NULL,
  `clientSSS_GSISnumber` varchar(15) NOT NULL,
  `clientDependentsElem` int NOT NULL,
  `clientDependentsHS` int NOT NULL,
  `clientDependentsC` int NOT NULL,
  `clientDependentsNotStud` int NOT NULL,
  `clientSourceOfIncome` enum('Employed','Professional','Self-Employed','Sole Proprietorship','Partnership corporation') NOT NULL,
  `clientEmployerBusinessName` varchar(50) NOT NULL,
  `clientNatureOfBusiness` varchar(50) NOT NULL,
  `clientBusinessAddress` varchar(100) NOT NULL,
  `clientPosition` varchar(50) NOT NULL,
  `clientDepartment` varchar(50) NOT NULL,
  `clientDateHired` date NOT NULL,
  `clientAppointment` enum('Regular','Probationary','Contractual','OFW','More than 2 years') NOT NULL,
  `clientPlaceOfWork` enum('Office','Field','Overseas') NOT NULL,
  `clientEmpPhoneNum` varchar(11) NOT NULL,
  `clientEmployerEmail` varchar(30) NOT NULL,
  `clientFathersName` varchar(50) NOT NULL,
  `clientMothersMaidenName` varchar(50) NOT NULL,
  `clientParentsAddress` varchar(100) NOT NULL,
  `clientParentsPhoneNum` varchar(11) NOT NULL,
  `clientSpaName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `clientSpaAddress` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `clientSpaPhoneNum` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `client_information`
--

INSERT INTO `client_information` (`id`, `clientCISID`, `prequalID`, `clientCitizenship`, `clientGender`, `clientReligion`, `clientBirthdate`, `clientPlaceOfBirth`, `clientAddress`, `clientProvinceAddress`, `clientTaxIdenNum`, `clientSSS_GSISnumber`, `clientDependentsElem`, `clientDependentsHS`, `clientDependentsC`, `clientDependentsNotStud`, `clientSourceOfIncome`, `clientEmployerBusinessName`, `clientNatureOfBusiness`, `clientBusinessAddress`, `clientPosition`, `clientDepartment`, `clientDateHired`, `clientAppointment`, `clientPlaceOfWork`, `clientEmpPhoneNum`, `clientEmployerEmail`, `clientFathersName`, `clientMothersMaidenName`, `clientParentsAddress`, `clientParentsPhoneNum`, `clientSpaName`, `clientSpaAddress`, `clientSpaPhoneNum`) VALUES
(1, 'CIS0001', 'PQ0001', 'Filipino', 'Female', 'Catholic', '2006-06-01', 'Canlaon City ', 'Blk 16 Lot 13, Tigulang, Camel, Ramon, Bacolod, Negros Oriental', '', '1234', '1234', 0, 0, 0, 0, 'Employed', 'Frances Marcelino', 'Eggs', 'Hello Street ', 'Secretary', 'Accounting', '2026-06-04', 'Regular', 'Office', '09376545675', 'hello@gmail.com', 'Ronald Abu  Oswald', 'Marsh Dewel Oswald', 'Blk 15 Lot 70 Decagon Homes', '09876545678', '', '', ''),
(2, 'CIS0002', 'PQ0003', 'Filipino', 'Female', 'Roman Catholic', '2005-08-07', 'Silay City', 'Blk 16 Lot 7, Silayer, Camella, Estefania, Silay City, Negros Occidental', '', '123456789000', '12345678900', 0, 0, 0, 0, 'Employed', 'Frances Marsi', 'Manufacturing', 'O hotel building, Bacolod City', 'Manager', 'Accounting', '2021-06-04', 'Regular', 'Office', '09376545675', 'ohotel@gmail.com', 'Rory Calvo Sarmiento', 'Rora Dove Sarmiento', 'Blk 16 Lot 18 Deca Home, Bacolod City, Negros Occ.', '09876545678', '', '', ''),
(3, 'CIS0003', 'PQ0004', 'Filipino', 'Female', 'Catholic', '2026-06-02', 'Bacolod City', 'Blk 16 Lot 13, Camello, Camello, Barangay Estefania, Bacolod, Negros Occidental', 'Blk 16 Lot 13, Camello, Camello, Barangay Estefania, Bacolod, Negros Occidental', '123456789000', '12345678900', 1, 0, 0, 0, 'Professional', 'Frances Marcelino', 'Manufacturing', 'NU Bacolod, Negros Occ', 'Employee', 'Testing', '2025-06-12', 'Regular', 'Office', '09376545675', 'nu@gmail.com', 'Ronald Mello Dela Pena', 'Marsh Dewel Dela Pena', 'Blk 15 Lot 70 Decagon Homes', '09876545678', 'Mello Gabriel Dela Cruz', 'Bacolod City', '09553548552');

-- --------------------------------------------------------

--
-- Table structure for table `coowner_information`
--

CREATE TABLE `coowner_information` (
  `id` int NOT NULL,
  `coownerISID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `coOwnerID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `coCitizenship` varchar(50) NOT NULL,
  `coCivilStatus` enum('Single','Married','Widow','Divorced') NOT NULL,
  `coGender` enum('Male','Female') NOT NULL,
  `coReligion` varchar(50) NOT NULL,
  `coBirthdate` date NOT NULL,
  `coPlaceOfBirth` varchar(50) NOT NULL,
  `coAddress` varchar(100) NOT NULL,
  `coProvinceAddress` varchar(100) DEFAULT NULL,
  `coTaxIdenNum` varchar(15) NOT NULL,
  `coSSS_GSISnumber` varchar(15) NOT NULL,
  `coDependentsElem` int NOT NULL,
  `coDependentsHS` int NOT NULL,
  `coDependentsC` int NOT NULL,
  `coDependentsNotStud` int NOT NULL,
  `coSourceOfIncome` enum('Employed','Professional','Self-Employed','Sole Proprietorship','Partnership corporation') NOT NULL,
  `coEmployerBusinessName` varchar(50) NOT NULL,
  `coNatureOfBusiness` varchar(50) NOT NULL,
  `coBusinessAddress` varchar(100) NOT NULL,
  `coPosition` varchar(50) NOT NULL,
  `coDepartment` varchar(50) NOT NULL,
  `coDateHired` date NOT NULL,
  `coAppointment` enum('Regular','Probationary','Contractual','OFW','More than 2 years') NOT NULL,
  `coPlaceOfWork` enum('Office','Field','Overseas') NOT NULL,
  `coEmpPhoneNum` varchar(11) NOT NULL,
  `coEmployerEmail` varchar(30) NOT NULL,
  `coFathersName` varchar(50) NOT NULL,
  `coMothersMaidenName` varchar(50) NOT NULL,
  `coParentsAddress` varchar(100) NOT NULL,
  `coParentsPhoneNum` varchar(11) NOT NULL,
  `coSpaName` varchar(50) DEFAULT NULL,
  `coSpaAddress` varchar(100) DEFAULT NULL,
  `coSpaPhoneNum` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financing`
--

CREATE TABLE `financing` (
  `id` int NOT NULL,
  `financingID` varchar(11) NOT NULL,
  `prequalID` varchar(11) NOT NULL,
  `financingType` varchar(8) NOT NULL,
  `contributionStartDate` date DEFAULT NULL,
  `currentLoan` enum('Yes','No') DEFAULT NULL,
  `bankName` varchar(50) DEFAULT NULL,
  `existingHouseLoan` enum('Yes','No') DEFAULT NULL,
  `cancelledHouseLoan` enum('Yes','No') DEFAULT NULL,
  `financingStatus` enum('Pending','Approved','Rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `financing`
--

INSERT INTO `financing` (`id`, `financingID`, `prequalID`, `financingType`, `contributionStartDate`, `currentLoan`, `bankName`, `existingHouseLoan`, `cancelledHouseLoan`, `financingStatus`) VALUES
(1, 'FN0001', 'PQ0001', 'bank', NULL, NULL, 'BDO', 'No', 'No', 'Approved'),
(2, 'FN0002', 'PQ0002', 'bank', NULL, NULL, 'BDO', 'No', 'No', 'Approved'),
(3, 'FN0003', 'PQ0003', 'bank', NULL, NULL, 'BDO', 'No', 'No', 'Approved'),
(4, 'FN0004', 'PQ0004', 'bank', NULL, NULL, 'BDO', 'No', 'No', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `prequal`
--

CREATE TABLE `prequal` (
  `id` int NOT NULL,
  `prequalID` varchar(11) NOT NULL,
  `clientID` varchar(11) NOT NULL,
  `agentID` varchar(11) NOT NULL,
  `propertyID` varchar(11) NOT NULL,
  `financingID` varchar(11) NOT NULL,
  `coOwnerID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `clientCivilStatus` varchar(8) NOT NULL,
  `clientEmpStatus` varchar(5) NOT NULL,
  `clientMonthlyIncome` decimal(20,2) NOT NULL,
  `prequalStatus` varchar(8) NOT NULL,
  `submissionDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `prequal`
--

INSERT INTO `prequal` (`id`, `prequalID`, `clientID`, `agentID`, `propertyID`, `financingID`, `coOwnerID`, `clientCivilStatus`, `clientEmpStatus`, `clientMonthlyIncome`, `prequalStatus`, `submissionDate`) VALUES
(1, 'PQ0001', 'C0001', 'AG0001', 'PR0002', 'FN0001', '', 'single', 'local', 100000.00, 'Approved', '2026-06-07'),
(2, 'PQ0002', 'C0001', 'AG0001', 'PR0004', 'FN0002', '', 'single', 'local', 100000.00, 'Pending', '2026-06-07'),
(3, 'PQ0003', 'C0002', 'AG0005', 'PR0004', 'FN0003', '', 'single', 'local', 100000.00, 'Approved', '2026-06-07'),
(4, 'PQ0004', 'C0003', 'AG0005', 'PR0001', 'FN0004', 'CP0001', 'married', 'local', 70000.00, 'Approved', '2026-06-07');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `id` int NOT NULL,
  `propertyID` varchar(11) NOT NULL,
  `propertyName` varchar(50) NOT NULL,
  `propertyType` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `propertyCity` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `propertyLat` double NOT NULL,
  `propertyLng` double NOT NULL,
  `propertyBrgy` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `propertyLotArea` int DEFAULT NULL,
  `propertyPrice` int DEFAULT NULL,
  `propertyStatus` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'Available',
  `houseFloorArea` int DEFAULT NULL,
  `houseStorey` int DEFAULT NULL,
  `houseBedroom` int DEFAULT NULL,
  `houseTandB` int DEFAULT NULL,
  `housePowderRoom` tinyint DEFAULT '0',
  `houseGarage` tinyint DEFAULT '0',
  `houseBalcony` tinyint NOT NULL DEFAULT '0',
  `houseTerrace` tinyint NOT NULL DEFAULT '0',
  `housePool` tinyint NOT NULL DEFAULT '0',
  `houseLaundryArea` tinyint NOT NULL DEFAULT '0',
  `houseMaidRoom` tinyint NOT NULL DEFAULT '0',
  `houseCabinets` tinyint NOT NULL DEFAULT '0',
  `houseBilliardRoom` tinyint NOT NULL DEFAULT '0',
  `houseClubhouse` tinyint NOT NULL DEFAULT '0',
  `houseGarden` tinyint NOT NULL DEFAULT '0',
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `propertyID`, `propertyName`, `propertyType`, `propertyCity`, `propertyLat`, `propertyLng`, `propertyBrgy`, `propertyLotArea`, `propertyPrice`, `propertyStatus`, `houseFloorArea`, `houseStorey`, `houseBedroom`, `houseTandB`, `housePowderRoom`, `houseGarage`, `houseBalcony`, `houseTerrace`, `housePool`, `houseLaundryArea`, `houseMaidRoom`, `houseCabinets`, `houseBilliardRoom`, `houseClubhouse`, `houseGarden`, `is_deleted`) VALUES
(1, 'PR0001', 'Tierra Del Rey', 'Lot', 'Bacolod', 10.672358634274264, 123.00839571779045, 'Estefania', 140, 2240000, 'Reserved', NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'PR0002', 'Oroland', 'House', 'Bacolod', 10.616358278361512, 122.94820767653476, 'Alijis', 120, 4234000, 'Reserved', 75, 1, 2, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'PR0003', 'Sunny Plains', 'House', 'Bacolod', 10.609445829278357, 122.96990655315243, 'Mansilingan', 98, 4218823, 'Available', 59, 2, 3, 2, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(4, 'PR0004', 'Balay Bugana', 'House', 'Bacolod', 10.670624264476134, 123.00090426825538, 'Burgos', 100, 3251662, 'Reserved', 51, 1, 3, 2, 0, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(5, 'PR0005', 'Villa Estefania', 'House', 'Bacolod', 10.674135166940687, 122.99476348388337, 'Fortune Towne', 239, 4818152, 'Available', 60, 2, 3, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 'PR0006', 'Manhattan', 'House', 'Bacolod', 10.663960818605027, 122.96129797084288, 'Villamonte', 150, 2400000, 'Available', 90, 2, 0, 2, 1, 1, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `property_images`
--

CREATE TABLE `property_images` (
  `id` int NOT NULL,
  `propertyID` varchar(10) NOT NULL,
  `imagePath` varchar(50) NOT NULL,
  `imageOrder` int NOT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `property_images`
--

INSERT INTO `property_images` (`id`, `propertyID`, `imagePath`, `imageOrder`, `is_deleted`) VALUES
(1, 'PR0001', '/views/Adminassets/images/property/28.jpg', 0, 0),
(2, 'PR0002', '/views/Adminassets/images/property/33.jpg', 0, 0),
(3, 'PR0002', '/views/Adminassets/images/property/32.jpg', 1, 0),
(4, 'PR0002', '/views/Adminassets/images/property/14.jpg', 2, 0),
(5, 'PR0002', '/views/Adminassets/images/property/17.jpg', 3, 0),
(6, 'PR0002', '/views/Adminassets/images/property/19.jpg', 4, 0),
(7, 'PR0003', '/views/Adminassets/images/property/23.jpg', 0, 0),
(8, 'PR0003', '/views/Adminassets/images/property/25.jpg', 1, 0),
(9, 'PR0003', '/views/Adminassets/images/property/26.jpg', 2, 0),
(10, 'PR0003', '/views/Adminassets/images/property/34.jpg', 3, 0),
(11, 'PR0003', '/views/Adminassets/images/property/20.jpg', 4, 0),
(12, 'PR0004', '/views/Adminassets/images/property/18.jpg', 0, 0),
(13, 'PR0004', '/views/Adminassets/images/property/35.jpg', 1, 0),
(14, 'PR0004', '/views/Adminassets/images/property/29.jpg', 2, 0),
(15, 'PR0004', '/views/Adminassets/images/property/24.jpg', 3, 0),
(16, 'PR0005', '/views/Adminassets/images/property/16.jpg', 0, 0),
(17, 'PR0005', '/views/Adminassets/images/property/21.jpg', 1, 0),
(18, 'PR0005', '/views/Adminassets/images/property/22.jpg', 2, 0),
(19, 'PR0005', '/views/Adminassets/images/property/30.jpg', 3, 0),
(20, 'PR0005', '/views/Adminassets/images/property/31.jpg', 4, 0),
(21, 'PR0006', '/views/Adminassets/images/property/16.jpg', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int NOT NULL,
  `reservationID` varchar(11) NOT NULL,
  `prequalID` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `agentID` varchar(11) NOT NULL,
  `clientValidID` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `reserveDate` date DEFAULT NULL,
  `reserveTime` time DEFAULT NULL,
  `reserveStatus` enum('Rejected','Pending','Approved','Archive') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `reservationID`, `prequalID`, `agentID`, `clientValidID`, `reserveDate`, `reserveTime`, `reserveStatus`) VALUES
(1, 'R0001', 'PQ0001', 'AG0001', '/uploads/valid_ids/validid_6a253953bcb54.jpg', '2026-06-07', '09:27:50', 'Approved'),
(2, 'R0002', 'PQ0002', 'AG0001', NULL, NULL, NULL, 'Pending'),
(3, 'R0003', 'PQ0003', 'AG0005', '/uploads/valid_ids/validid_6a2553dad781b.png', '2026-06-07', '11:20:57', 'Approved'),
(4, 'R0004', 'PQ0004', 'AG0005', '/uploads/valid_ids/validid_6a25583ac97bf.png', '2026-06-07', '11:39:23', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `sitevisit`
--

CREATE TABLE `sitevisit` (
  `id` int NOT NULL,
  `siteVisitID` varchar(11) NOT NULL,
  `clientID` varchar(11) NOT NULL,
  `agentID` varchar(11) NOT NULL,
  `propertyID` varchar(11) NOT NULL,
  `siteVisitStatus` enum('Completed','Booked','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `siteVisitDate` date NOT NULL,
  `siteVisitTime` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sitevisit`
--

INSERT INTO `sitevisit` (`id`, `siteVisitID`, `clientID`, `agentID`, `propertyID`, `siteVisitStatus`, `siteVisitDate`, `siteVisitTime`) VALUES
(1, 'SV25703077', 'C0001', 'AG0001', 'PR0002', 'Completed', '2026-06-07', '05:45 PM'),
(2, 'SV18556090', 'C0002', 'AG0005', 'PR0004', 'Completed', '2026-06-07', '07:30 PM');

-- --------------------------------------------------------

--
-- Table structure for table `spouse_information`
--

CREATE TABLE `spouse_information` (
  `id` int NOT NULL,
  `spouseISID` varchar(11) NOT NULL,
  `clientCISID` varchar(11) DEFAULT NULL,
  `spouseFName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spouseMName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spouseLName` varchar(50) NOT NULL,
  `spouseSuffix` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spouseEmail` varchar(30) NOT NULL,
  `spousePhoneNum` varchar(11) NOT NULL,
  `spouseCitizenship` varchar(50) NOT NULL,
  `spouseGender` enum('Male','Female') NOT NULL,
  `spouseReligion` varchar(50) NOT NULL,
  `spouseBirthdate` date NOT NULL,
  `spousePlaceOfBirth` varchar(50) NOT NULL,
  `spouseAddress` varchar(100) NOT NULL,
  `spouseProvinceAddress` varchar(100) NOT NULL,
  `spouseTaxIdenNum` varchar(15) NOT NULL,
  `spouseSSS_GSISnumber` varchar(15) NOT NULL,
  `spouseDependentsElem` int NOT NULL,
  `spouseDependentsHS` int NOT NULL,
  `spouseDependentsC` int NOT NULL,
  `spouseDependentsNotStud` int NOT NULL,
  `spouseMonthlyIncome` varchar(11) NOT NULL,
  `spouseSourceOfIncome` enum('Employed','Professional','Self-Employed','Sole Proprietorship','Partnership corporation') NOT NULL,
  `spouseEmployerBusinessName` varchar(50) NOT NULL,
  `spouseNatureOfBusiness` varchar(50) NOT NULL,
  `spouseBusinessAddress` varchar(100) NOT NULL,
  `spousePosition` varchar(50) NOT NULL,
  `spouseDepartment` varchar(50) NOT NULL,
  `spouseDateHired` date NOT NULL,
  `spouseAppointment` enum('Regular','Probationary','Contractual','OFW','More than 2 years') NOT NULL,
  `spousePlaceOfWork` enum('Office','Field','Overseas') NOT NULL,
  `spouseEmpPhoneNum` varchar(11) NOT NULL,
  `spouseEmployerEmail` varchar(30) NOT NULL,
  `spouseFathersName` varchar(50) NOT NULL,
  `spouseMothersMaidenName` varchar(50) NOT NULL,
  `spouseParentsAddress` varchar(100) NOT NULL,
  `spouseParentsPhoneNum` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `spouse_information`
--

INSERT INTO `spouse_information` (`id`, `spouseISID`, `clientCISID`, `spouseFName`, `spouseMName`, `spouseLName`, `spouseSuffix`, `spouseEmail`, `spousePhoneNum`, `spouseCitizenship`, `spouseGender`, `spouseReligion`, `spouseBirthdate`, `spousePlaceOfBirth`, `spouseAddress`, `spouseProvinceAddress`, `spouseTaxIdenNum`, `spouseSSS_GSISnumber`, `spouseDependentsElem`, `spouseDependentsHS`, `spouseDependentsC`, `spouseDependentsNotStud`, `spouseMonthlyIncome`, `spouseSourceOfIncome`, `spouseEmployerBusinessName`, `spouseNatureOfBusiness`, `spouseBusinessAddress`, `spousePosition`, `spouseDepartment`, `spouseDateHired`, `spouseAppointment`, `spousePlaceOfWork`, `spouseEmpPhoneNum`, `spouseEmployerEmail`, `spouseFathersName`, `spouseMothersMaidenName`, `spouseParentsAddress`, `spouseParentsPhoneNum`) VALUES
(1, 'SIS0001', 'CIS0003', 'Arldri', 'A', 'Marcel', ' ', 'arldri@gmail.com', '09655622448', 'Filipino', 'Male', 'Roman Catholic', '2009-06-04', 'Bacolod City', 'Blk 16 Lot 13, Tigulang, Camello, Barangay Estefania, Bacolod, Negros Occidental', '', '123456789000', '12345678900', 1, 0, 0, 0, '100000.00', 'Employed', 'Azheel Valencia', 'Manufacturing', 'San Agustin Street, BS. Aquino Drive, Bacolod City, Negros Occidental', 'Manager', 'Accounting', '2009-06-04', 'Probationary', 'Field', '09376545675', 'csab@gmail.com', 'Mirando Roy Marcel', 'Miranda Reya Marcel', 'Blk 15 Lot 70 Decagon Homes', '09876545678');

-- --------------------------------------------------------

--
-- Table structure for table `userrights`
--

CREATE TABLE `userrights` (
  `id` int NOT NULL,
  `userid` varchar(5) NOT NULL,
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `upassword` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `userrights`
--

INSERT INTO `userrights` (`id`, `userid`, `username`, `upassword`) VALUES
(1, 'E001', 'try', 'try'),
(2, 'E002', 'try@gmail.com', 'again'),
(3, '', 'v', 'v'),
(4, '', 'w', 'w'),
(5, '', 'x', 'x'),
(6, '', 'y', 'y'),
(7, '', 'y', 'y'),
(8, '', 'y', 'y'),
(9, '', 'y', 'y'),
(10, '', 'y', 'y'),
(11, '', 'y', 'y'),
(12, '', 'y', 'y'),
(13, '', 'hello', 'hello'),
(14, '', 'bye', 'bye');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agent`
--
ALTER TABLE `agent`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `clientcoprequal`
--
ALTER TABLE `clientcoprequal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_information`
--
ALTER TABLE `client_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coowner_information`
--
ALTER TABLE `coowner_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `financing`
--
ALTER TABLE `financing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prequal`
--
ALTER TABLE `prequal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `property_images`
--
ALTER TABLE `property_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sitevisit`
--
ALTER TABLE `sitevisit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siteVisitID` (`siteVisitID`);

--
-- Indexes for table `spouse_information`
--
ALTER TABLE `spouse_information`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userrights`
--
ALTER TABLE `userrights`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `agent`
--
ALTER TABLE `agent`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `clientcoprequal`
--
ALTER TABLE `clientcoprequal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `client_information`
--
ALTER TABLE `client_information`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `coowner_information`
--
ALTER TABLE `coowner_information`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financing`
--
ALTER TABLE `financing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `prequal`
--
ALTER TABLE `prequal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `property_images`
--
ALTER TABLE `property_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sitevisit`
--
ALTER TABLE `sitevisit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spouse_information`
--
ALTER TABLE `spouse_information`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `userrights`
--
ALTER TABLE `userrights`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
