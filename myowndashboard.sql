-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3307
-- Tiempo de generación: 17-11-2023 a las 21:03:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `academicdashboard`
--
CREATE DATABASE IF NOT EXISTS `academicdashboard` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `academicdashboard`;

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `studydatasumdurationbytrigger`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `studydatasumdurationbytrigger` (IN `userID` INT, IN `initialTimeUnixTimestamp` INT, IN `finalTimeUnixTimestamp` INT)   begin
select
	studysessiontrigger.id as "id",
	studysessiontrigger.name as "name",
	studysessiontrigger.description as "description",
	coalesce(sum(studydata100.duration/3600), 0) as "duration"
from
	studysessiontrigger
left join studydata100 on
	studysessiontrigger.id = studydata100.triggerID
	and
    	studydata100.initialTime > initialTimeUnixTimestamp
	and
        studydata100.initialTime < finalTimeUnixTimestamp
	and
        studydata100.userID =userID
group by
	studysessiontrigger.id;
END$$

DROP PROCEDURE IF EXISTS `triggersumdurationbystudycharacteristic`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `triggersumdurationbystudycharacteristic` (IN `userID` INT, IN `initialTimeUnixTimestamp` INT, IN `finalTimeUnixTimestamp` INT, IN `triggerID` INT)   begin
	/*In each instance of a study session you have a trigger and a 
	 * studyCharacteristicsSet. This procedure given a trigger, returns
	 * the breakdown of which studyCharacteristicsSet was chosen when that
	 * trigger was selected, in seconds of study data.
	 * So lets say you:
	 * studytrigger = 13, with charact=2 for 24seconds
	 * studytrigger = 13, with charact=3 for 32seconds
	 * studytrigger = 13, with charact=2 for 10seconds
	 * studytrigger = 14, with charact=2 for 21seconds
	 * and you call this function with studytrigger = 13 you'll get
	 * charact 1 --> 0 seconds
	 * charact 2 --> 34 seconds (24 + 10)
	 * charact 3 --> 32 seconds
	 * additionally, you specify as parameters the user and the time period.
	 * */
	SELECT 
    	studydatacharacteristics.id as "id",
    	studydatacharacteristics.name as "name",
        studydatacharacteristics.description as "description",
    	coalesce(sum(studydata100.duration/3600),0) as "duration" 
    FROM studydatacharacteristics 
    LEFT JOIN studydata100
    	ON studydata100.studyCharacteristicsID = studydatacharacteristics.id AND
    	studydata100.userID=userID AND
        studydata100.initialTime > initialTimeUnixTimestamp AND
        studydata100.initialTime + studydata100.duration < finalTimeUnixTimestamp AND
        studydata100.triggerID = triggerID
	GROUP BY studydatacharacteristics.id;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consistencygoal`
--

DROP TABLE IF EXISTS `consistencygoal`;
CREATE TABLE IF NOT EXISTS `consistencygoal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `texto` text NOT NULL,
  `number` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `startDate` date NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses100`
--

DROP TABLE IF EXISTS `courses100`;
CREATE TABLE IF NOT EXISTS `courses100` (
  `courseID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `initialDate` date DEFAULT NULL COMMENT 'The day that the course starts',
  `finalDate` date DEFAULT NULL COMMENT 'The day that the course ends',
  `description` text DEFAULT NULL,
  `is6thCourse` tinyint(1) NOT NULL DEFAULT 0,
  `is7thCourse` tinyint(1) NOT NULL DEFAULT 0,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`courseID`),
  KEY `userIDCOURSE` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `horasporasignatura`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `horasporasignatura`;
CREATE TABLE IF NOT EXISTS `horasporasignatura` (
`asignatura` varchar(75)
,`horas` decimal(36,4)
,`nickname` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `horasporproyecto`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `horasporproyecto`;
CREATE TABLE IF NOT EXISTS `horasporproyecto` (
`proyecto` text
,`asignatura` varchar(75)
,`horas` decimal(36,4)
,`nickname` varchar(50)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects100`
--

DROP TABLE IF EXISTS `projects100`;
CREATE TABLE IF NOT EXISTS `projects100` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`projectID`),
  KEY `IDcourse` (`courseID`),
  KEY `userIDproject` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studydata100`
--

DROP TABLE IF EXISTS `studydata100`;
CREATE TABLE IF NOT EXISTS `studydata100` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `courseID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `initialTime` bigint(20) DEFAULT NULL COMMENT 'in unix timestamp',
  `duration` int(11) DEFAULT NULL COMMENT 'in seconds',
  `userID` int(11) NOT NULL,
  `triggerID` int(11) DEFAULT NULL,
  `studyCharacteristicsID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courseID` (`courseID`),
  KEY `projectID` (`projectID`),
  KEY `userID` (`userID`),
  KEY `studySessionTrigger` (`triggerID`),
  KEY `studyCharacteristicsID` (`studyCharacteristicsID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studydatacharacteristics`
--

DROP TABLE IF EXISTS `studydatacharacteristics`;
CREATE TABLE IF NOT EXISTS `studydatacharacteristics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `studydatacharacteristics_FK` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studysessiontrigger`
--

DROP TABLE IF EXISTS `studysessiontrigger`;
CREATE TABLE IF NOT EXISTS `studysessiontrigger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userIDg` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user100`
--

DROP TABLE IF EXISTS `user100`;
CREATE TABLE IF NOT EXISTS `user100` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura para la vista `horasporasignatura`
--
DROP TABLE IF EXISTS `horasporasignatura`;

DROP VIEW IF EXISTS `horasporasignatura`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `horasporasignatura`  AS SELECT `courses100`.`name` AS `asignatura`, sum(`studydata100`.`duration`) / 3600 AS `horas`, `user100`.`nickname` AS `nickname` FROM ((`studydata100` join `courses100` on(`courses100`.`courseID` = `studydata100`.`courseID`)) join `user100` on(`studydata100`.`userID` = `user100`.`id`)) GROUP BY `studydata100`.`courseID` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `horasporproyecto`
--
DROP TABLE IF EXISTS `horasporproyecto`;

DROP VIEW IF EXISTS `horasporproyecto`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `horasporproyecto`  AS SELECT `projects100`.`name` AS `proyecto`, `courses100`.`name` AS `asignatura`, sum(`studydata100`.`duration`) / 3600 AS `horas`, `user100`.`nickname` AS `nickname` FROM (((`studydata100` join `projects100` on(`projects100`.`projectID` = `studydata100`.`projectID`)) join `courses100` on(`courses100`.`courseID` = `projects100`.`courseID`)) join `user100` on(`studydata100`.`userID` = `user100`.`id`)) GROUP BY `studydata100`.`projectID` ;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consistencygoal`
--
ALTER TABLE `consistencygoal`
  ADD CONSTRAINT `consistencygoal_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user100` (`id`);

--
-- Filtros para la tabla `courses100`
--
ALTER TABLE `courses100`
  ADD CONSTRAINT `userIDCOURSE` FOREIGN KEY (`user`) REFERENCES `user100` (`id`);

--
-- Filtros para la tabla `projects100`
--
ALTER TABLE `projects100`
  ADD CONSTRAINT `IDcourse` FOREIGN KEY (`courseID`) REFERENCES `courses100` (`courseID`),
  ADD CONSTRAINT `userIDproject` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);

--
-- Filtros para la tabla `studydata100`
--
ALTER TABLE `studydata100`
  ADD CONSTRAINT `courseID` FOREIGN KEY (`courseID`) REFERENCES `courses100` (`courseID`),
  ADD CONSTRAINT `projectID` FOREIGN KEY (`projectID`) REFERENCES `projects100` (`projectID`),
  ADD CONSTRAINT `studyCharacteristicsID` FOREIGN KEY (`studyCharacteristicsID`) REFERENCES `studydatacharacteristics` (`id`),
  ADD CONSTRAINT `studySessionTrigger` FOREIGN KEY (`triggerID`) REFERENCES `studysessiontrigger` (`id`),
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);

--
-- Filtros para la tabla `studydatacharacteristics`
--
ALTER TABLE `studydatacharacteristics`
  ADD CONSTRAINT `studydatacharacteristics_FK` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);

--
-- Filtros para la tabla `studysessiontrigger`
--
ALTER TABLE `studysessiontrigger`
  ADD CONSTRAINT `userIDg` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
