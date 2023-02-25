package plannerJournal;

import java.sql.PreparedStatement;
import java.sql.ResultSet;

public class UserHandler{

    public static User getUserFromID(int id){
        DatabaseManager db = new DatabaseManager();
        db.open();
        User user = null;
        try {
            String sql = "SELECT id,name,publicKey FROM user100 WHERE id=?";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1,id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                user = new User(rs.getString("id"),rs.getString("name"),rs.getString("publicKey"));
            }
            db.close();
            return user;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return null;
        }
    }

    public static User getUserFromUsername(String username){
        DatabaseManager db = new DatabaseManager();
        db.open();
        User user = null;
        try {
            String sql = "SELECT id,nickname,publicKey FROM user100 WHERE nickname=?";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setString(1,username);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                user = new User(rs.getString("id"),rs.getString("nickname"),rs.getString("publicKey"));
            }
            db.close();
            return user;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return null;
        }
    }

    public static boolean existsUser(String username){
        if(getUserFromUsername(username) == null){
            return false;
        }else{
            return true;
        }
    }

    public static String getHash(int id){
        DatabaseManager db = new DatabaseManager();
        db.open();
        String hash = "";
        try {
            String sql = "SELECT password FROM user100 WHERE id=?";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1,id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                hash = rs.getString("password");
            }
            db.close();
            return hash;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return null;
        }
    }



}