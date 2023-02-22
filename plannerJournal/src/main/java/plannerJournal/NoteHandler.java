package plannerJournal;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class NoteHandler {

    public static ArrayList<Note> getNotes(int userID) {
        DatabaseManager db = new DatabaseManager();
        db.open();

        try {
            // String sql = "SELECT id,name,content FROM note100 WHERE userID=?";
            String sql = "SELECT id,name FROM note100";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            // stmt.setInt(1,userID);
            ArrayList<Note> notes = new ArrayList<Note>();
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                notes.add(new Note(rs.getInt("id"), rs.getString("name")));
            }
            db.close();
            return notes;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return null;
        }
    }

    public static String getNoteName(int id) {
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
            return result;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return "error al encontrar el nombre";
        }
    }

    public static String getNoteContent(int id) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        String result = "";
        try {
            String sql = "SELECT content FROM note100 where id=? ";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                result = rs.getString("content");
            }
            db.close();
            return result;
        } catch (Exception e) {
            db.close();
            e.printStackTrace();
            return "error al encontrar el contenido";
        }
    }

    public static void editNote(int id, String name, String content, User user) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        try {
            // Encrypt content
            content = EncryptionHandler.encryptMessage(content, user);
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
