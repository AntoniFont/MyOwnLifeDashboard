<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/test/MockDatabaseHandler.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/controller/DataAccessObjects/StudyDataDAO.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/StudyData.php");

class StudyDataDAOTest extends PHPUnit\Framework\TestCase
{
  private function fillMockDatabase()
  {
    MockDatabaseHandler::createMockDatabaseAndSwitchCredentials();
    $dbManager = new DatabaseManager();
    $sql = "CREATE TABLE studydata100 (id integer ,courseID integer, initialTime integer, duration integer,userID integer)";
    $dbManager->query($sql, null);

    /*
    12- april-2023 in unixtimestamp
    11am (11): 1681290000
    13- april - 2023 in unixtimestamp
    11am (11): 1681376400
    2pm (14): 1681390800
    5pm (17): 1681405200 
    
    John Doe studied math for 2 hours at 11 am and
    1 hour of physics at 5 pm on 13 april 2023
    
    Jane Doe studied psychology for 3 hours at 2 pm
    and 1 hour of physics at 11 am on 13 april 2023
    
    John Doe studied math for 1 hour at 11am on 12 april 2023
    
    Jane Doe studied physics for 2 hours at 11am on 12 april 2023
    
    John Doe: User1
    Jane Doe: User2
    Math: Course1
    Physics: Course2
    Psychology: Course3
    */

    $sql = "INSERT INTO studydata100 (id, courseID, initialTime, duration, userID) VALUES 
            (1, 1, 1681376400, 2, 1),
            (2, 2, 1681405200, 1, 1),
            (3, 3, 1681390800, 3, 2),
            (4, 2, 1681376400, 1, 2)";
    $dbManager->query($sql, null);
    $sql = "INSERT INTO studydata100 (id, courseID, initialTime, duration, userID) VALUES 
            (5, 1, 1681290000, 1, 1),
            (6, 2, 1681290000, 2, 2)";
    $dbManager->query($sql, null);
  }
  
  public function testGetStudySessionsOfADay()
  {
    $this->fillMockDatabase();
    $user1 = new User(1, "John");
    $user2 = new User(2, "Jane");
    $day = "2023-04-13";
    $studyDataDAO = new StudyDataDAO();
    $studySessions = $studyDataDAO->getStudySessionsOfADay($user1,$day);
    $this->assertEquals(2, count($studySessions));
    $this->assertEquals(1, $studySessions[0]->getCourseID());
    $this->assertEquals(2, $studySessions[1]->getCourseID());
    $this->assertEquals(1681376400, $studySessions[0]->getInitialTime());
    $this->assertEquals(1681405200, $studySessions[1]->getInitialTime());
    $this->assertEquals(2, $studySessions[0]->getDuration());
    $this->assertEquals(1, $studySessions[1]->getDuration());
    $this->assertEquals(1, $studySessions[0]->getUserId());
    $this->assertEquals(1, $studySessions[1]->getUserId());
    $studySessions = $studyDataDAO->getStudySessionsOfADay($user2,$day);
    $this->assertEquals(2, count($studySessions));
    $this->assertEquals(3, $studySessions[0]->getCourseID());
    $this->assertEquals(2, $studySessions[1]->getCourseID());
    $this->assertEquals(1681390800, $studySessions[0]->getInitialTime());
    $this->assertEquals(1681376400, $studySessions[1]->getInitialTime());
    $this->assertEquals(3, $studySessions[0]->getDuration());
    $this->assertEquals(1, $studySessions[1]->getDuration());
    $this->assertEquals(2, $studySessions[0]->getUserId());
    $this->assertEquals(2, $studySessions[1]->getUserId());
    MockDatabaseHandler::deleteMockDatabaseAndRestoreCredentials();
  }
  
}

?>