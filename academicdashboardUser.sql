GRANT USAGE ON *.* TO `root`@`localhost` IDENTIFIED BY PASSWORD '';

GRANT ALL PRIVILEGES ON `academicdashboard`.`studydata100` TO `root`@`localhost`;

GRANT ALL PRIVILEGES ON `academicdashboard`.`projects100` TO `root`@`localhost`;

GRANT ALL PRIVILEGES ON `academicdashboard`.`consistencygoal` TO `root`@`localhost`;

GRANT SELECT, INSERT ON `academicdashboard`.`studydata_triggers` TO `root`@`localhost`;

GRANT ALL PRIVILEGES ON `academicdashboard`.`courses100` TO `root`@`localhost`;

GRANT ALL PRIVILEGES ON `academicdashboard`.`studysessiontrigger` TO `root`@`localhost`;

GRANT ALL PRIVILEGES ON `academicdashboard`.`user100` TO `root`@`localhost`;

GRANT ALL PRIVILEGES ON `academicdashboard`.`studydatacharacteristics` TO `root`@`localhost`;

GRANT EXECUTE ON PROCEDURE `academicdashboard`.`studydatasumdurationbytrigger` TO `root`@`localhost`;

GRANT EXECUTE ON PROCEDURE `academicdashboard`.`triggersumdurationbystudycharacteristic` TO `root`@`localhost`;

GRANT EXECUTE ON PROCEDURE `academicdashboard`.`getunusedtriggersbyuserinperiod` TO `root`@`localhost`;

GRANT PROXY ON ''@'%' TO 'root'@'localhost' WITH GRANT OPTION;