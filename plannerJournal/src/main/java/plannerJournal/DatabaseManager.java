package plannerJournal;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;

public class DatabaseManager {

    /* DATABASE CONSTANTS */
    private static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";
    private static final String DB_URL = "jdbc:mysql://localhost:3306/";
    private static final String DB_NAME = "myowndashboard";
    private static final String USER = "root";
    private static final String PASSWORD = "";

    public Connection connection = null;

    public DatabaseManager() {

    }

    public ArrayList<String> getNicknames() {
        // Open connection with database jdbc
        try {
            Class.forName(JDBC_DRIVER);
            connection = DriverManager.getConnection(DB_URL + DB_NAME, USER, PASSWORD);
            System.out.println("Connection to database established");
            // SELECT EVERYTHING FROM THE TABLE users and print it out to console

        } catch (Exception e) {
            e.printStackTrace();
        }

        try {
            String sql = "SELECT * FROM user100";
            PreparedStatement stmt = connection.prepareStatement(sql);
            ResultSet rs = stmt.executeQuery();
            ArrayList<String> nicknames = new ArrayList<String>();
            while (rs.next()) {
                nicknames.add(rs.getString("nickname"));

            }
            return nicknames;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

    public void close() {
        try {
            connection.close();
        } catch (SQLException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
    }

}
