package plannerJournal;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

public class DatabaseManager {

    /* DATABASE CONSTANTS */
    //private static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
    private static final String JDBC_DRIVER = "com.mysql.cj.jdbc.Driver";
	private static final String DB_URL = "jdbc:mysql://localhost:3306/";
    private static final String DB_NAME = "myowndashboard";
    private static final String USER = "root";
    private static final String PASSWORD = "";

    public Connection connection = null;

    public DatabaseManager() {

    }

    public void open() {
        // Open connection with database jdbc
        try {
            Class.forName(JDBC_DRIVER);
            connection = DriverManager.getConnection(DB_URL + DB_NAME, USER, PASSWORD);
            StackTraceElement[] stackTraceElements = Thread.currentThread().getStackTrace();
            StackTraceElement caller = stackTraceElements[2]; 
            System.out.println("[debug] Database opened by " + caller.getClassName() + "." + caller.getMethodName() + "()");
            
        } catch (Exception e) {
            e.printStackTrace();
        }
    	
    }

    public void close() {
        try {
            connection.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }

}
