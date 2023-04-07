<?php
class MockDatabaseHandler
{
    private static $host = "localhost";
    private static $root = "root";
    private static $rootpassword = "";
    private static $mockDatabaseCredentials = "{
        \"host\": \"localhost\",
        \"database\": \"myowndashboardtest\",
        \"user\": \"root\",
        \"password\": \"\",
        \"charset\": \"utf8\" 
    }";


    public static function createMockDatabaseAndSwitchCredentials()
    {
        $dbh = new PDO("mysql:host=" . self::$host, self::$root, self::$rootpassword);
        $dbh->exec("CREATE DATABASE IF NOT EXISTS myowndashboardtest ");
        $defaultCredentialsExists = file_exists($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json");
        
        if(!$defaultCredentialsExists){ 
            //if there is no default credentials file, create it with the testing credentials
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json", self::$mockDatabaseCredentials);
        } else { 
            // if there is a default credentials file, save a copy (rename) and set the default credentials to the testing credentials
            rename(
                $_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json", //origin
                $_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/realDatabaseCredentials.json" //destination
            );
            file_put_contents($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json", self::$mockDatabaseCredentials);
        }
    }

    public static function deleteMockDatabaseAndRestoreCredentials()
    {
        $dbh = new PDO("mysql:host=" . self::$host, self::$root, self::$rootpassword);
        $dbh->exec("DROP DATABASE myowndashboardtest");
        $copyOfDefaultCredentialsExists = file_exists($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/realDatabaseCredentials.json");
        if ($copyOfDefaultCredentialsExists) {
            //Restore everything to the original state
            unlink($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json");
            rename(
                $_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/realDatabaseCredentials.json", //origin
                $_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json" //destination
            );
        } else {
            //Delete the testing credentials file
            unlink($_SERVER["DOCUMENT_ROOT"] . "/myownlifedashboard/dashboard/model/database/databaseCredentials.json");
        }
    }
}
?>