<?php
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/test/MockDatabaseHandler.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
    require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/CoursesDAO.php");
    
    class CoursesDAOTest extends PHPUnit\Framework\TestCase
    {
        /*
         7 courses
          CourseA (Active) (User1): 3h
          CourseB (Active) (User1): 2h
          CourseC (Active) (User1): 0h
          CourseD (Active) (User1): 7h
          CourseE (Active) (User1): 1h 
          CourseF (Active) (User1): 5h 
          CourseG (Active) (User1): 4h
          CourseH (Inactive) (User1): 10h
          CourseI (Active) (User2): 10h 
          
          10-April-2023 2hA, 1hD, 10hH
          11-April-2023 2hD, 5hF
          12-April-2023 1hA, 1hB
          13-April-2023 1hE  2hG
          14-April-2023 3hD, 2hG
          15-April-2023
          16-April-2023 1hB, 1hD, 10hI

          On the 17 of April The 50% least studied courses are CourseC, CourseE and CourseB
        */
        private function fillMockDatabase(){
            MockDatabaseHandler::createMockDatabaseAndSwitchCredentials();
            $dbManager = new DatabaseManager();
            //Create both tables
            $sql = "CREATE TABLE courses100 (courseID integer, name varchar(1), user integer, finalDate date)";
            $dbManager->query($sql, null);
            $sql = "CREATE TABLE studydata100 (courseID integer, duration integer, initialTime integer)";
            $dbManager->query($sql, null);
            //Fill courses table
            $sql = "INSERT INTO courses100 (courseID, name, user, finalDate) VALUES 
            (1, 'A', 1, '2023-05-01'),
            (2, 'B', 1, '2023-05-01'),
            (3, 'C', 1, '2023-05-01'),
            (4, 'D', 1, '2023-05-01'),
            (5, 'E', 1, '2023-05-01'),
            (6, 'F', 1, '2023-05-01'),
            (7, 'G', 1, '2023-05-01'),
            (8, 'H', 1, '2023-01-01'),
            (9, 'I', 2, '2023-05-01')";
            $dbManager->query($sql, null);
            //Fill studydata table
            $sql = "INSERT INTO studydata100 (courseID, duration, initialTime) VALUES ";
            //first day
            $sql .= "  
            (1,2,1681081200),
            (4,1,1681081200),
            (8,10,1681081200),";
            //second
            $sql .= "
            (4,2,1681167600),
            (6,5,1681167600),";
            //third
            $sql .= "
            (1,1,1681254000),
            (2,1,1681254000),";
            //fourth
            $sql .= "
            (5,1,1681340400),
            (7,2,1681340400),";
            //fifth
            $sql .= "
            (4,3,1681426800),
            (7,2,1681426800),
            ";
            //sixth (nothing)
            //seventh
            $sql .= "
            (2,1,1681599600),
            (4,1,1681599600),
            (8,10,1681599600)
            ";
            $dbManager->query($sql, null); 
        }
        
        public function testGetBottom50PercentLeastStudiedCoursesInInterval(){
            $this->fillMockDatabase();
            $coursesDao = new CoursesDAO();
            $courses = $coursesDao->getBottom50PercentLeastStudiedCoursesInInterval("2023-04-17", 1, 7);
            $this->assertEquals(3, count($courses));
            $this->assertEquals("C", $courses[0]->getName());
            $this->assertEquals("E", $courses[1]->getName());
            $this->assertEquals("B", $courses[2]->getName());
            MockDatabaseHandler::deleteMockDatabaseAndRestoreCredentials();
        
        }
    }

?>