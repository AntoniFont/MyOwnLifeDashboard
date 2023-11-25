-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 25-11-2023 a las 17:50:16
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.1.12

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
CREATE DEFINER=`superRoot`@`localhost` PROCEDURE `getUnusedTriggersByUserInPeriod` (IN `userID` INT, IN `initialTimeUnixTimestamp` INT, IN `finalTimeUnixTimestamp` INT)  SQL SECURITY INVOKER begin
SELECT
    studysessiontrigger.name,
    studysessiontrigger.description
FROM
    studysessiontrigger
    LEFT JOIN(
        SELECT
            *
        FROM
            studydata_triggers
            JOIN studydata100 ON studydata_triggers.studydataID = studydata100.id
            and studydata100.initialTime > initialTimeUnixTimestamp
            AND studydata100.initialTime + studydata100.duration < finalTimeUnixTimestamp
        ORDER BY
            studydata100.id DESC
    ) AS tabla ON tabla.triggerID = studysessiontrigger.id
WHERE
    tabla.triggerID IS NULL
    AND(
        studysessiontrigger.userID = userID
        OR 
        studysessiontrigger.userID IS NULL
    )
    ;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `studydatasumdurationbytrigger` (IN `userID` INT, IN `initialTimeUnixTimestamp` INT, IN `finalTimeUnixTimestamp` INT)  SQL SECURITY INVOKER begin
select
		studysessiontrigger.id as "id",
		studysessiontrigger.name as "name",
		studysessiontrigger.description as "description",
		sum(studydata100.duration) / 3600 as "duration"
	from
		studydata100
    join studydata_triggers
    	on studydata100.id=studydata_triggers.studydataID
	join studysessiontrigger 
	on
		 studydata_triggers.triggerID = studysessiontrigger.id
	where
		studydata100.initialTime > initialTimeUnixTimestamp
		and
        studydata100.initialTime < finalTimeUnixTimestamp
		and
        studydata100.userID = userID
	group by
		studydata_triggers.triggerID;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consistencygoal`
--

CREATE TABLE `consistencygoal` (
  `id` int(11) NOT NULL,
  `texto` text NOT NULL,
  `number` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `startDate` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses100`
--

CREATE TABLE `courses100` (
  `courseID` int(11) NOT NULL,
  `name` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `initialDate` date DEFAULT NULL COMMENT 'The day that the course starts',
  `finalDate` date DEFAULT NULL COMMENT 'The day that the course ends',
  `description` text DEFAULT NULL,
  `is6thCourse` tinyint(1) NOT NULL DEFAULT 0,
  `is7thCourse` tinyint(1) NOT NULL DEFAULT 0,
  `user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `projects100`
--

CREATE TABLE `projects100` (
  `projectID` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `endDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studydata100`
--

CREATE TABLE `studydata100` (
  `id` int(11) NOT NULL,
  `courseID` int(11) DEFAULT NULL,
  `projectID` int(11) DEFAULT NULL,
  `initialTime` bigint(20) DEFAULT NULL COMMENT 'in unix timestamp',
  `duration` int(11) DEFAULT NULL COMMENT 'in seconds',
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studydata_triggers`
--

CREATE TABLE `studydata_triggers` (
  `studydata_triggersID` int(11) NOT NULL,
  `studydataID` int(11) NOT NULL,
  `triggerID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `studysessiontrigger`
--

CREATE TABLE `studysessiontrigger` (
  `id` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user100`
--

CREATE TABLE `user100` (
  `id` int(11) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `passwordHash` varchar(200) NOT NULL,
  `specialSpotifyFeatureEnabled` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consistencygoal`
--
ALTER TABLE `consistencygoal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Indices de la tabla `courses100`
--
ALTER TABLE `courses100`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `userIDCOURSE` (`user`);

--
-- Indices de la tabla `projects100`
--
ALTER TABLE `projects100`
  ADD PRIMARY KEY (`projectID`),
  ADD KEY `IDcourse` (`courseID`),
  ADD KEY `userIDproject` (`userID`);

--
-- Indices de la tabla `studydata100`
--
ALTER TABLE `studydata100`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courseID` (`courseID`),
  ADD KEY `projectID` (`projectID`),
  ADD KEY `userID` (`userID`);

--
-- Indices de la tabla `studydata_triggers`
--
ALTER TABLE `studydata_triggers`
  ADD PRIMARY KEY (`studydata_triggersID`),
  ADD KEY `stuyddataID` (`studydataID`),
  ADD KEY `triggerID` (`triggerID`);

--
-- Indices de la tabla `studysessiontrigger`
--
ALTER TABLE `studysessiontrigger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userIDg` (`userID`);

--
-- Indices de la tabla `user100`
--
ALTER TABLE `user100`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nickname` (`nickname`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consistencygoal`
--
ALTER TABLE `consistencygoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `courses100`
--
ALTER TABLE `courses100`
  MODIFY `courseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `projects100`
--
ALTER TABLE `projects100`
  MODIFY `projectID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `studydata100`
--
ALTER TABLE `studydata100`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `studydata_triggers`
--
ALTER TABLE `studydata_triggers`
  MODIFY `studydata_triggersID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `studysessiontrigger`
--
ALTER TABLE `studysessiontrigger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user100`
--
ALTER TABLE `user100`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `user100` (`id`);

--
-- Filtros para la tabla `studydata_triggers`
--
ALTER TABLE `studydata_triggers`
  ADD CONSTRAINT `stuyddataID` FOREIGN KEY (`studydataID`) REFERENCES `studydata100` (`id`),
  ADD CONSTRAINT `triggerID` FOREIGN KEY (`triggerID`) REFERENCES `studysessiontrigger` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
