package plannerJournal;

import java.sql.Array;
import java.sql.Blob;
import java.sql.CallableStatement;
import java.sql.Clob;
import java.sql.Connection;
import java.sql.DatabaseMetaData;
import java.sql.DriverManager;
import java.sql.NClob;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLClientInfoException;
import java.sql.SQLException;
import java.sql.SQLWarning;
import java.sql.SQLXML;
import java.sql.Savepoint;
import java.sql.Statement;
import java.sql.Struct;
import java.util.ArrayList;
import java.util.Map;
import java.util.Properties;
import java.util.concurrent.Executor;

import javax.tools.JavaCompiler;

public class DatabaseManager {

    /* DATABASE CONSTANTS */
    //private static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
    private static final String JDBC_DRIVER = "com.mysql.cj.jdbc.Driver";
	private static final String DB_URL = "jdbc:mysql://localhost:3306/myowndashboard?connectTimeout=60000&socketTimeout=60000";
    private static final String USER = "root";
    private static final String PASSWORD = "";

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
