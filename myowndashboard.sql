-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2022 at 08:36 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myowndashboard`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses100`
--

CREATE TABLE `courses100` (
  `courseID` int(11) NOT NULL,
  `name` varchar(75) COLLATE utf8_unicode_ci NOT NULL,
  `initialDate` date DEFAULT NULL COMMENT 'The day that the course starts',
  `finalDate` date DEFAULT NULL COMMENT 'The day that the course ends',
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses100`
--

INSERT INTO `courses100` (`courseID`, `name`, `initialDate`, `finalDate`, `description`) VALUES
(1, 'Gestió de projectes', '2022-09-12', '2023-02-07', NULL),
(2, 'Aplicacions distribuïdes a internet i interfícies d\'usuari', '2022-09-12', '2023-02-07', NULL),
(3, 'Solucions pel sector turístic', '2022-09-12', '2023-02-07', NULL),
(4, 'Qualitat de software', '2022-09-12', '2023-02-07', NULL),
(5, 'Programació concurrent', '2022-09-12', '2023-02-07', NULL),
(6, 'Comunicacions de dades i xarxes', '2022-09-12', '2023-02-07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects100`
--

CREATE TABLE `projects100` (
  `projectID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `courseID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects100`
--

INSERT INTO `projects100` (`projectID`, `name`, `description`, `courseID`) VALUES
(1, 'Practica3', 'Haciendo la práctica 3 de la asignatura', 4),
(2, 'Práctica de GP', 'La práctica de todo el curso de GP.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `studydata100`
--

CREATE TABLE `studydata100` (
  `id` int(11) NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `typeID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `initialTime` datetime DEFAULT NULL,
  `duration` int(11) DEFAULT NULL COMMENT 'in seconds',
  `comments` text DEFAULT NULL,
  `planned` tinyint(1) NOT NULL COMMENT 'true if it is not a real activity, just a plan to do something at a specific time'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `typesstudydata100`
--

CREATE TABLE `typesstudydata100` (
  `typeStudyDataID` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `typesstudydata100`
--

INSERT INTO `typesstudydata100` (`typeStudyDataID`, `name`, `description`) VALUES
(1, 'Learning new things', 'The hardest type of work. You\'re pushing your mental limits to learn a new skill or concept. \r\n\r\nYou may be reading some slides, underlining some text, watching a video or reading some documentation.'),
(2, 'Reviewing or memorizing', 'You\'re looking at concepts that you already understand.\r\n\r\nMaybe you\'re trying to memorize for an exam or trying to solidify concepts that you already understand.'),
(3, 'Doing handwritten exercises', 'Usually done with courses that involve maths but you can be solving a questionnaire in a course without maths too. \r\n\r\nWith math you\'re learning how to use formulas and techniques that you already understand.\r\n\r\nIn a course without math the teachers may be: \r\n - They\'re trying to make you understand fully the details of a concept.\r\n - They\'re trying to make you understand the relationship between two concepts. \r\n - They\'re trying to develop your critical thinking skills in that area.\r\n\r\n'),
(4, 'Doing programming exercises', 'You\'re programming a concept that you already know and understand.\r\n\r\nThis type of task usually takes a lot of time.'),
(5, 'Organizing', 'You\'re organizing the day or some activity');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses100`
--
ALTER TABLE `courses100`
  ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `projects100`
--
ALTER TABLE `projects100`
  ADD PRIMARY KEY (`projectID`),
  ADD KEY `IDcourse` (`courseID`);

--
-- Indexes for table `studydata100`
--
ALTER TABLE `studydata100`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courseID` (`courseID`),
  ADD KEY `projectID` (`projectID`),
  ADD KEY `typeStudyDataID` (`typeID`);

--
-- Indexes for table `typesstudydata100`
--
ALTER TABLE `typesstudydata100`
  ADD PRIMARY KEY (`typeStudyDataID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses100`
--
ALTER TABLE `courses100`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `projects100`
--
ALTER TABLE `projects100`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studydata100`
--
ALTER TABLE `studydata100`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `typesstudydata100`
--
ALTER TABLE `typesstudydata100`
  MODIFY `typeStudyDataID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `projects100`
--
ALTER TABLE `projects100`
  ADD CONSTRAINT `IDcourse` FOREIGN KEY (`courseID`) REFERENCES `courses100` (`courseID`);

--
-- Constraints for table `studydata100`
--
ALTER TABLE `studydata100`
  ADD CONSTRAINT `courseID` FOREIGN KEY (`courseID`) REFERENCES `courses100` (`courseID`),
  ADD CONSTRAINT `projectID` FOREIGN KEY (`projectID`) REFERENCES `projects100` (`projectID`),
  ADD CONSTRAINT `typeStudyDataID` FOREIGN KEY (`typeID`) REFERENCES `typesstudydata100` (`typeStudyDataID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
