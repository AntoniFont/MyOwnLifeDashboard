package plannerJournal;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;

public class DatabaseManager {

    /* DATABASE CONSTANTS */
    //private static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
    private static final String JDBC_DRIVER = "com.mysql.cj.jdbc.Driver";
	private static final String DB_URL = "jdbc:mysql://localhost:3306/plannerjournal?connectTimeout=60000&socketTimeout=60000";
    private static final String USER = "usuarioPlannerJournal";
    private static final String PASSWORD = "38xNUADVjIt3o3WiGwtjXHk";

    private Connection connection = null;

    public DatabaseManager() {

    }

    public void open() {
        // Open connection with database jdbc
        try {
            Class.forName(JDBC_DRIVER);
            connection = DriverManager.getConnection(DB_URL, USER, PASSWORD);
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

    public PreparedStatement prepareStatement(String sql) throws SQLException{
    	StackTraceElement[] stackTraceElements = Thread.currentThread().getStackTrace();
        StackTraceElement caller = stackTraceElements[2];
        System.out.println("[debug] Query prepared by " + caller.getClassName() + "." + caller.getMethodName() + "() " + sql);
    	return connection.prepareStatement(sql);
    }

    public PreparedStatement prepareStatement(String sql, int value) throws SQLException{
    	StackTraceElement[] stackTraceElements = Thread.currentThread().getStackTrace();
        StackTraceElement caller = stackTraceElements[2];
        System.out.println("[debug] Query prepared by " + caller.getClassName() + "." + caller.getMethodName() + "() " + sql);
    	return connection.prepareStatement(sql,value);
    }



}
