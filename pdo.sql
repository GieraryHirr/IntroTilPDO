-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2021 at 02:10 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdo`
--

-- --------------------------------------------------------

--
-- Table structure for table `afdeling`
--

CREATE TABLE `afdeling` (
  `AfdNummer` int(11) NOT NULL,
  `AfdNavn` varchar(255) NOT NULL,
  `ByNavn` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `afdeling`
--

INSERT INTO `afdeling` (`AfdNummer`, `AfdNavn`, `ByNavn`) VALUES
(1, 'Administration', 'Ballerup'),
(2, 'Marketing', 'Hvidovre'),
(3, 'Udvikling', 'Frederiksberg');

-- --------------------------------------------------------

--
-- Table structure for table `job_titel`
--

CREATE TABLE `job_titel` (
  `Titel` varchar(255) NOT NULL,
  `Beskrivelse` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `job_titel`
--

INSERT INTO `job_titel` (`Titel`, `Beskrivelse`) VALUES
('Boss', 'Boss of slaves'),
('Designer', 'Best designer in TEC'),
('Slave', 'Average slave');

-- --------------------------------------------------------

--
-- Table structure for table `medarbejder`
--

CREATE TABLE `medarbejder` (
  `Person_ID` int(11) NOT NULL,
  `Adgangskode` varchar(255) NOT NULL,
  `CPR` int(11) NOT NULL,
  `Fornavn` varchar(255) NOT NULL,
  `Efternavn` varchar(255) NOT NULL,
  `Titel` varchar(255) NOT NULL,
  `TlfNr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- --------------------------------------------------------

--
-- Table structure for table `projekt`
--

CREATE TABLE `projekt` (
  `PNummer` int(11) NOT NULL,
  `ProjektNavn` varchar(255) NOT NULL,
  `AfdNummer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projekt`
--

INSERT INTO `projekt` (`PNummer`, `ProjektNavn`, `AfdNummer`) VALUES
(1, 'FirstProject', 1),
(2, 'Second project', 3);

-- --------------------------------------------------------

--
-- Table structure for table `projekt_deltagere`
--

CREATE TABLE `projekt_deltagere` (
  `Person_ID` int(11) NOT NULL,
  `PNummer` int(11) NOT NULL,
  `Timer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projekt_deltagere`
--

INSERT INTO `projekt_deltagere` (`Person_ID`, `PNummer`, `Timer`) VALUES
(123456789, 1, 0),
(111, 2, 3),
(222, 1, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `afdeling`
--
ALTER TABLE `afdeling`
  ADD PRIMARY KEY (`AfdNummer`);

--
-- Indexes for table `job_titel`
--
ALTER TABLE `job_titel`
  ADD PRIMARY KEY (`Titel`);

--
-- Indexes for table `medarbejder`
--
ALTER TABLE `medarbejder`
  ADD PRIMARY KEY (`Person_ID`),
  ADD UNIQUE KEY `CPR` (`CPR`),
  ADD KEY `Titel` (`Titel`);

--
-- Indexes for table `projekt`
--
ALTER TABLE `projekt`
  ADD PRIMARY KEY (`PNummer`),
  ADD KEY `AfdNummer` (`AfdNummer`);

--
-- Indexes for table `projekt_deltagere`
--
ALTER TABLE `projekt_deltagere`
  ADD KEY `Person_ID` (`Person_ID`),
  ADD KEY `PNummer` (`PNummer`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medarbejder`
--
ALTER TABLE `medarbejder`
  ADD CONSTRAINT `medarbejder_ibfk_1` FOREIGN KEY (`Titel`) REFERENCES `job_titel` (`Titel`);

--
-- Constraints for table `projekt`
--
ALTER TABLE `projekt`
  ADD CONSTRAINT `projekt_ibfk_1` FOREIGN KEY (`AfdNummer`) REFERENCES `afdeling` (`AfdNummer`);

--
-- Constraints for table `projekt_deltagere`
--
ALTER TABLE `projekt_deltagere`
  ADD CONSTRAINT `projekt_deltagere_ibfk_1` FOREIGN KEY (`Person_ID`) REFERENCES `medarbejder` (`Person_ID`),
  ADD CONSTRAINT `projekt_deltagere_ibfk_2` FOREIGN KEY (`PNummer`) REFERENCES `projekt` (`PNummer`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
