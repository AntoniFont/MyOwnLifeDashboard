<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/DatabaseManager.php");

class DatabaseManagerTest extends PHPUnit\Framework\TestCase
{
    private $host = "localhost";
    private $root = "root";
    private $rootpassword = "";

    //file_get_contents throws a warning if the file does not exist instead of an exception,making
    //the code a mess less readable. This function is a neat workaround for that.
    private function read_file($filename)
    {
        set_error_handler(function ($severity, $message, $file, $line) {
            throw new \ErrorException($message, $severity, $severity, $file, $line);
        });
        $result = file_get_contents($filename);
        restore_error_handler();
        return $result;
    }

    protected function setUp(): void
    {
        //Creating a new mock database
        $dbh = new PDO("mysql:host=$this->host", $this->root, $this->rootpassword);
        $dbh->exec("CREATE DATABASE IF NOT EXISTS myowndashboardtest");
        $dbh->exec("USE myowndashboardtest");
        //Create a table that does not exist in the normal database
        //to make sure that the database manager does not use the normal database.
        $dbh->exec("CREATE TABLE IF NOT EXISTS absdasdieugisurhgisdrugh (name varchar(50))");
        $dbh->exec("INSERT INTO absdasdieugisurhgisdrugh (name) VALUES ('test')");
    }

    protected function tearDown(): void
    {
        $dbh = new PDO("mysql:host=$this->host", $this->root, $this->rootpassword);
        $dbh->exec("DROP DATABASE myowndashboardtest");
    }


    public function testLoadCredentials()
    {
        $previousCredentials = true;
        //Save the current credentials
        try {
            $credentials = $this->read_file($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json");
        } catch (Exception $e) {
            echo "Test load credentials: No credentials file found to backup.";
            $previousCredentials = false;
        }

        $newCredentials = "{
                \"host\": \"localhost\",
                \"database\": \"myowndashboardtest\",
                \"user\": \"root\",
                \"password\": \"\",
                \"charset\": \"utf8\" 
            }";

        //Change the new credentials
        file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json", $newCredentials);
        //Test if the database manager uses the new credentials
        $dbm = new DatabaseManager();
        $result = $dbm->query("SELECT * FROM absdasdieugisurhgisdrugh", array());
        $this->assertEquals("test", $result[0][0]);
        //Restore the old credentials
        if ($previousCredentials) { //If there were old credentials, restore the old credentials.
            echo file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json", $credentials);
        }else{ //delete the new credentials file.
            unlink($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json");
        }
    }
}

?>