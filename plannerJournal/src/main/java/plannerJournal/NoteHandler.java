package plannerJournal;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.ArrayList;

public class NoteHandler {

	public static ArrayList<Note> getNotes(String username, String privateKeyString, String groupCodeName) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			User user = UserHandler.getUserFromUsername(username);
			String sql = "SELECT id,name FROM note100 WHERE userID=?";
			PreparedStatement stmt = db.connection.prepareStatement(sql);
			stmt.setInt(1, user.getId());
			ArrayList<Note> notes = new ArrayList<Note>();
			ResultSet rs = stmt.executeQuery();
			while (rs.next()) {
				// Only add the note if it belongs to the group.
				int id = rs.getInt("id");
				if (noteBelongsToGroup(id, groupCodeName, user.getId())) {
					String name = rs.getString("name");
					name = EncryptionHandler.decrypt(name, privateKeyString);
					notes.add(new Note(rs.getInt("id"), name));
				}
			}
			db.close();
			return notes;
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return null;
		}
	}

	public static boolean noteBelongsToGroup(int noteID, String groupCodeName, int userID) {
		// First get the groupID
		int groupID = NotegroupHandler.getNoteGroupIDFromCodeName(groupCodeName, userID);
		if (groupID == -1) {
			return false;
		}
		// Check if the note belongs to the group
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			String sql = "SELECT id FROM note_notegroup WHERE noteID=? AND notegroupID=?";
			PreparedStatement stmt = db.connection.prepareStatement(sql);
			stmt.setInt(1, noteID);
			stmt.setInt(2, groupID);
			ResultSet rs = stmt.executeQuery();
			while (rs.next()) {
				db.close();
				return true;
			}
			db.close();
			return false;
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return false;
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
			result = EncryptionHandler.decrypt(result, privateKey);
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
			// Get the content
			String sql = "SELECT content FROM note100 where id=? ";
			PreparedStatement stmt = db.connection.prepareStatement(sql);
			stmt.setInt(1, id);
			ResultSet rs = stmt.executeQuery();
			while (rs.next()) {
				result = rs.getString("content");
			}
			db.close();
			// Decrypt the content
			result = EncryptionHandler.decrypt(result, privateKey);
			return result;
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return "error al encontrar el contenido";
		}
	}

	public static String getNoteUserID(int id) {
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

	public static void editNote(int id, String name, String content, User user, String privateKey,String isFixed) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			// Encrypt content
			content = EncryptionHandler.encrypt(content, privateKey);
			name = EncryptionHandler.encrypt(name, privateKey);
			// Update note
			String sql = "UPDATE note100 SET name=?, content=?, isFixed=? WHERE id=? AND userID=?";
			PreparedStatement stmt = db.connection.prepareStatement(sql);
			stmt.setString(1, name);
			stmt.setString(2, content);
			System.out.println("isFixed: " + isFixed);
			if(isFixed.equals("true")) {
				stmt.setBoolean(3, true);
			}else if(isFixed.equals("true")) {
				stmt.setBoolean(3, false);
			}
			stmt.setInt(4, id);
			stmt.setInt(5, user.getId());
			stmt.executeUpdate();
			db.close();
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
		}
	}

	public static void newEmptyNote(String username, String privateKey, String groupCodeName) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		User user = UserHandler.getUserFromUsername(username);
		int noteID = -1;
		try {
			String sql = "INSERT INTO note100 (name, content, userID) VALUES (?,?,?)";
			PreparedStatement stmt = db.connection.prepareStatement(sql, PreparedStatement.RETURN_GENERATED_KEYS);
			stmt.setString(1, EncryptionHandler.encrypt("Nueva nota", privateKey));
			stmt.setString(2, EncryptionHandler.encrypt("", privateKey));
			stmt.setInt(3, user.getId());
			stmt.executeUpdate();
			ResultSet rs = stmt.getGeneratedKeys();
			if (rs.next()) {
				noteID = rs.getInt(1);
			}
			db.close();
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
		}
		// Get the groupID
		int groupID = NotegroupHandler.getNoteGroupIDFromCodeName(groupCodeName, user.getId());
		if (groupID == -1 || noteID == -1) {
			return;
		}
		// Add the note to the group
		db.open();
		try {
			String sql = "INSERT INTO note_notegroup (noteID, notegroupID) VALUES (?,?)";
			PreparedStatement stmt = db.connection.prepareStatement(sql);
			stmt.setInt(1, noteID);
			stmt.setInt(2, groupID);
			System.out.println(stmt);
			stmt.executeUpdate();
			db.close();
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
		}

	}

}
