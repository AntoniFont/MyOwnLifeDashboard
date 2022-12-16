-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2022 at 04:31 PM
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
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `courses100`
--

INSERT INTO `courses100` (`courseID`, `name`, `initialDate`, `finalDate`, `description`, `user`) VALUES
(1, 'Gestió de projectes', '2022-09-12', '2023-02-07', NULL, 1),
(2, 'Aplicacions distribuïdes a internet i interfícies d\'usuari', '2022-09-12', '2023-02-07', NULL, 1),
(3, 'Solucions pel sector turístic', '2022-09-12', '2023-02-07', NULL, 1),
(4, 'Qualitat de software', '2022-09-12', '2023-02-07', NULL, 1),
(5, 'Programació concurrent', '2022-09-12', '2023-02-07', NULL, 1),
(6, 'Comunicacions de dades i xarxes', '2022-09-12', '2023-02-07', NULL, 1),
(7, 'Algorítmia i Estructures de dades I', '2022-09-12', '2023-02-07', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `projects100`
--

CREATE TABLE `projects100` (
  `projectID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `projects100`
--

INSERT INTO `projects100` (`projectID`, `name`, `description`, `courseID`, `userID`) VALUES
(1, 'Practica3 Qualitat', 'La práctica 3 de la asignatura qualitat de software.\r\n\r\nHeu de realitzar una avaluació de les característiques de qualitat del producte software que hàgiu triat el vostre grup. \r\n\r\nTriau un producte software que sigui àmpliament conegut i utilitzat, adreçat a un públic general i no especialitzat, de tal manera que tots hi poguem tenir accés: NETFLIX.\r\n\r\nHeu d’avaluar 3 característiques cada equip. Les característiques a avaluar corresponen a les vistes interna i externa de la qualitat del producte software.\r\n\r\n    8.3.4 Attactiveness metrics\r\n    8.3.3 Operability metrics f) Suitable for individualisation\r\n    8.3.3 Operability metrics d) Self descriptive (Guiding)\r\n\r\n    Reproducir vídeos\r\n    Descargar Vídeos\r\n    Filtrar por género\r\n\r\n\r\nPer avaluar la qualitat de vostre producte software heu d\'utilitzar les normes ISO/IEC 9126-2 i ISO/IEC 9126-3 que defineixen les mètriques per les característiques de les vistes interna i externa. La vostra tasca consistirà en entendre i utilitzar les mètriques de les característiques triades per avaluar el producte des de la perspectiva de la característica. ', 4, 1),
(2, 'Práctica de GP', 'La práctica de todo el curso de GP.', 1, 1),
(3, 'Preparando la defensa de GP', 'Realizando las 130 preguntas que ha publicado la profesora para la defensa de GP', 1, 1),
(4, 'Sprint 3 Solucions', 'Sprint 3 Solucions pel Sector Turístic', 3, 1),
(5, 'Práctica IPO ADIIU', 'Se entrega como máximo el dia 11 de enero de 2023', 2, 1),
(6, 'Aprendiendo HCI ADIIU', 'Únicamente fui a 2 clases de 8 de este tema de ADIIU, así que tendre que mirar los power points y intentar entenderlo por mi cuenta.', 2, 1),
(7, 'Preparar examen Algoritima1', '', 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `studydata100`
--

CREATE TABLE `studydata100` (
  `id` int(11) NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `typeID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `initialTime` bigint(20) DEFAULT NULL COMMENT 'in unix timestamp',
  `duration` int(11) DEFAULT NULL COMMENT 'in seconds',
  `descripción` text DEFAULT NULL,
  `planned` tinyint(1) NOT NULL COMMENT 'true(1) if it is not a real activity, just a plan to do something at a specific time',
  `workingAlone` tinyint(1) DEFAULT NULL COMMENT '1 if you worked alone, 0 if you were working together with other people.\r\n\r\nIf you were next to someone it doesn''t count, that''s another attribute',
  `beingAlone` tinyint(1) DEFAULT NULL COMMENT '1 if you were alone in a room, 0 if you were with friends or colleaguesin the room ',
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studydata100`
--

INSERT INTO `studydata100` (`id`, `courseID`, `typeID`, `projectID`, `initialTime`, `duration`, `descripción`, `planned`, `workingAlone`, `beingAlone`, `userID`) VALUES
(27, 4, 5, 1, 1670672946, 28, NULL, 0, 1, 1, 1),
(28, 4, 5, 1, 1670673083, 686, NULL, 0, 1, 1, 1),
(30, 1, 3, 3, 1670770740, 3656, NULL, 0, 0, 0, 1),
(31, 1, 3, 3, 1670774653, 406, NULL, 0, 0, 0, 1),
(32, 4, 1, 1, 1670779045, 270, 'reading iso 9126-1 (2001 version) to be able to do the practica', 0, 1, 0, 1),
(33, 4, 1, 1, 1670779906, 879, 'reading iso 9126-1 (2001 version) to be able to do the practica', 0, 1, 0, 1),
(34, 4, 1, 1, 1670781035, 681, 'reading iso 9126-1 (2001 version) to be able to do the practica', 0, 1, 0, 1),
(35, 4, 1, 1, 1670782211, 357, 'reading iso 9126-2 (2002 version) to be able to do the practica', 0, 1, 0, 1),
(36, 4, 3, 1, 1670785043, 1513, 'Doing the practica', 0, 1, 0, 1),
(37, 4, 3, 1, 1670787449, 34, 'Doing the practica', 0, 1, 0, 1),
(38, 4, 3, 1, 1670818979, 1031, 'Doing the practica', 0, 1, 1, 1),
(39, 4, 6, 1, 1670820038, 1508, 'Changing colors and fonts', 0, 1, 1, 1),
(40, 4, 6, 1, 1670821788, 2120, 'Changing colors and fonts', 0, 1, 1, 1),
(44, 4, 3, 1, 1670844736, 139, NULL, 0, 1, 0, 1),
(45, 4, 6, 1, 1670844880, 795, NULL, 0, 1, 0, 1),
(46, 4, 3, 1, 1670852341, 466, NULL, 0, 1, 1, 1),
(47, 1, 3, 3, 1670855192, 371, NULL, 0, 1, 1, 1),
(48, 1, 3, 3, 1670860274, 1605, NULL, 0, 1, 1, 1),
(49, 1, 3, 3, 1670941057, 2879, NULL, 0, 1, 0, 1),
(50, 1, 3, 3, 1670948290, 2661, NULL, 0, 1, 0, 1),
(51, 1, 3, 3, 1670952030, 1323, NULL, 0, 1, 0, 1),
(52, 1, 3, 3, 1670956121, 629, NULL, 0, 1, 1, 1),
(53, NULL, 5, NULL, 1671010160, 90, NULL, 0, 1, 0, 1),
(54, 3, 4, 4, 1671010460, 1140, NULL, 0, 1, 0, 1),
(55, 3, 4, 4, 1671011657, 905, NULL, 0, 1, 0, 1),
(56, 3, 4, 4, 1671012619, 409, NULL, 0, 1, 1, 1),
(57, 3, 4, 4, 1671109842, 3222, NULL, 0, 1, 1, 1),
(59, 2, 5, 5, 1671114116, 443, 'Viendo que practicas quedan por hacer en la asignatura', 0, 1, 1, 1),
(61, 2, 5, 6, 1671115530, 709, 'Descargando los powerpoints en la tablet', 0, 1, 1, 1),
(62, 2, 1, 6, 1671116778, 801, 'Primera parte del tema de needfinding', 0, NULL, NULL, 1),
(63, 2, 2, 6, 1671117730, 869, 'Creando preguntas de repaso de la primera mitad del tema de Needfinding y respondiendolas.', 0, NULL, NULL, 1),
(64, 7, NULL, 7, 1671203301, 1, NULL, 0, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `typesstudydata100`
--

CREATE TABLE `typesstudydata100` (
  `typeStudyDataID` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `typesstudydata100`
--

INSERT INTO `typesstudydata100` (`typeStudyDataID`, `name`, `description`) VALUES
(1, 'Learning new things', 'The hardest type of work. You\'re pushing your mental limits to learn a new skill or concept. \n\nYou may be reading some slides, underlining some text, watching a video or reading some documentation.'),
(2, 'Reviewing or memorizing', 'You\'re looking at concepts that you already understand.\n\nMaybe you\'re trying to memorize for an exam or trying to solidify concepts that you already understand.'),
(3, 'Solving questions and doing exercises (Not programming)', 'Usually done with courses that involve maths but you can be solving a questionnaire in a course without maths too. \r\n\r\nWith math you\'re learning how to use formulas and techniques that you already understand.\r\n\r\nIn a course without math the teachers may be: \r\n - They\'re trying to make you understand fully the details of a concept.\r\n - They\'re trying to make you understand the relationship between two concepts. \r\n - They\'re trying to develop your critical thinking skills in that area.\r\n\r\n'),
(4, 'Doing programming exercises', 'You\'re programming a concept that you already know and understand.\r\n\r\nThis type of task usually takes a lot of time.'),
(5, 'Organizing', 'You\'re organizing the day or some activity'),
(6, 'Tyding up a word document', 'This task includes:\r\n- Adding a title page\r\n- Adding a index\r\n- Adding links\r\n- Everything related to typography (font, font size, color...)\r\n- Adding introduction\r\n- Adding context\r\n- Adding a conclusion\r\n- etc');

-- --------------------------------------------------------

--
-- Table structure for table `user100`
--

CREATE TABLE `user100` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user100`
--

INSERT INTO `user100` (`id`, `nickname`) VALUES
(1, 'toniet'),
(2, 'sufi.mago');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses100`
--
ALTER TABLE `courses100`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `userIDCOURSE` (`user`);

--
-- Indexes for table `projects100`
--
ALTER TABLE `projects100`
  ADD PRIMARY KEY (`projectID`),
  ADD KEY `IDcourse` (`courseID`),
  ADD KEY `userIDproject` (`userID`);

--
-- Indexes for table `studydata100`
--
ALTER TABLE `studydata100`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courseID` (`courseID`),
  ADD KEY `projectID` (`projectID`),
  ADD KEY `typeStudyDataID` (`typeID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `typesstudydata100`
--
ALTER TABLE `typesstudydata100`
  ADD PRIMARY KEY (`typeStudyDataID`);

--
-- Indexes for table `user100`
--
ALTER TABLE `user100`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses100`
--
ALTER TABLE `courses100`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `projects100`
--
ALTER TABLE `projects100`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `studydata100`
--
ALTER TABLE `studydata100`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `typesstudydata100`
--
ALTER TABLE `typesstudydata100`
  MODIFY `typeStudyDataID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user100`
--
ALTER TABLE `user100`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses100`
--
ALTER TABLE `courses100`
  ADD CONSTRAINT `userIDCOURSE` FOREIGN KEY (`user`) REFERENCES `user100` (`id`);

--
-- Constraints for table `projects100`
--
ALTER TABLE `projects100`
  ADD CONSTRAINT `IDcourse` FOREIGN KEY (`courseID`) REFERENCES `courses100` (`courseID`),
  ADD CONSTRAINT `userIDproject` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);

--
-- Constraints for table `studydata100`
--
ALTER TABLE `studydata100`
  ADD CONSTRAINT `courseID` FOREIGN KEY (`courseID`) REFERENCES `courses100` (`courseID`),
  ADD CONSTRAINT `projectID` FOREIGN KEY (`projectID`) REFERENCES `projects100` (`projectID`),
  ADD CONSTRAINT `typeStudyDataID` FOREIGN KEY (`typeID`) REFERENCES `typesstudydata100` (`typeStudyDataID`),
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
