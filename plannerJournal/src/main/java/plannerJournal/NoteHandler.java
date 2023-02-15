package plannerJournal;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class NoteHandler {

	public static ArrayList<Note> getNotes(int userID){
		DatabaseManager db = new DatabaseManager();
		db.open();
		
		try {
            //String sql = "SELECT id,name,content FROM note100 WHERE userID=?";
            String sql = "SELECT id,name,content FROM note100";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
            //stmt.setInt(1,userID);
            ResultSet rs = stmt.executeQuery();
            ArrayList<Note> notes = new ArrayList<Note>();
            while (rs.next()) {
                notes.add(new Note(rs.getInt("id"),rs.getString("name"),rs.getString("content")));
            }
            db.close();
            return notes;
        } catch (Exception e) {
        	db.close();
            e.printStackTrace();
            return null;
        }
	}
	
}
