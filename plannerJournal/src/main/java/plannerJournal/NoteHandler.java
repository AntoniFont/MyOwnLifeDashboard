package plannerJournal;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class NoteHandler {

    public static ArrayList<Note> getNotes(String username, String privateKeyString) {
        DatabaseManager db = new DatabaseManager();
        db.open();

        try {
        	User user = UserHandler.getUserFromUsername(username);
            String sql = "SELECT id,name FROM note100 WHERE userID=?";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1,user.getId());
            ArrayList<Note> notes = new ArrayList<Note>();
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
            	String name = rs.getString("name");
            	name = EncryptionHandler.decryptMessage(name, privateKeyString);
                notes.add(new Note(rs.getInt("id"), name ));
            }
            db.close();
            return notes;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return null;
        }
    }

    public static String getNoteName(int id, String privateKey) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        String result = "";
        try {
            String sql = "SELECT name FROM note100 where id=? ";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                result = rs.getString("name");
            }
            db.close();
            result = EncryptionHandler.decryptMessage(result, privateKey);
            return result;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return "error al encontrar el nombre";
        }
    }

    public static String getNoteContent(int id, String privateKey) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        String result = "";
        try {
        	//Get the content
            String sql = "SELECT content FROM note100 where id=? ";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                result = rs.getString("content");
            }
            db.close();
            //Decrypt the content
            result = EncryptionHandler.decryptMessage(result, privateKey);
            return result;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return "error al encontrar el contenido";
        }
    }

    public static String getNoteUserID(int id){
        DatabaseManager db = new DatabaseManager();
        db.open();
        String result = "";
        try {
            String sql = "SELECT userID FROM note100 where id=? ";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                result = rs.getString("userID");
            }
            db.close();
            return result;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return "error al encontrar el usuario";
        }
    }

    public static void editNote(int id, String name, String content, User user) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        try {
            // Encrypt content
            content = EncryptionHandler.encryptMessage(content, user);
            name = EncryptionHandler.encryptMessage(name, user);
            // Update note
            String sql = "UPDATE note100 SET name=?, content=? WHERE id=? AND userID=?";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setString(1, name);
            stmt.setString(2, content);
            stmt.setInt(3, id);
            stmt.setInt(4, user.getId());
            System.out.println(stmt.toString());
            stmt.executeUpdate();
            db.close();
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
        }
    }

}
