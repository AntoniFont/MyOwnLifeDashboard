package plannerJournal;

import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Iterator;

public class NoteHandler {


	public static ArrayList<Note> getNotesi(String username, String privateKeyString, String groupCodeName, boolean archived) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			User user = UserHandler.getUserFromUsername(username);
			String sql;
			if(!archived) {
				sql = "SELECT id,name,isFixed FROM note100 WHERE userID=? AND isArchived=0 ORDER BY isFixed DESC, lastUpdate DESC ";
			}else {
				sql = "SELECT id,name,isFixed FROM note100 WHERE userID=? ORDER BY isFixed DESC, lastUpdate DESC ";
			}
			PreparedStatement stmt = db.prepareStatement(sql);
			stmt.setInt(1, user.getId());
			ArrayList<Note> notes = new ArrayList<>();
			ResultSet rs = stmt.executeQuery();
			while (rs.next()) {
				String name = rs.getString("name");
				name = EncryptionHandler.decrypt(name, privateKeyString);
				notes.add(new Note(rs.getInt("id"), name,rs.getBoolean("isFixed")));
			}
			//filter out the notes that dont belong to the group
			notes = filterNotesThatDontBelongToGroup(groupCodeName, notes, user.getId());
			db.close();
			return notes;
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return null;
		}
	}

	//It removes from the arraylist the notes that dont belong to a group
	//Using over and over the method noteBelongsToGroup was slow, so I switched to
	//this function that only conects to the database once,
	public static ArrayList<Note> filterNotesThatDontBelongToGroup(String groupCodeName, ArrayList<Note> notas, int userID){
		int groupID = NotegroupHandler.getNoteGroupIDFromCodeName(groupCodeName, userID);
		if (groupID == -1) {
			return new ArrayList<>();
		}
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			String sql = "SELECT noteID FROM note_notegroup WHERE notegroupID=?";
			PreparedStatement stmt = db.prepareStatement(sql);
			stmt.setInt(1, groupID);
			ResultSet rs = stmt.executeQuery();
			//get all the noteIDs that belong to the group
			ArrayList<Integer> noteIDs = new ArrayList<>();
			while (rs.next()) {
				noteIDs.add(rs.getInt("noteID"));
			}
			//remove from the arraylist the notes that dont belong to the group
			Iterator<Note> it = notas.iterator();
			while(it.hasNext()){
				Note n = it.next();
				if(!noteIDs.contains(n.getId())){
					it.remove();
				}
			}
			db.close();
			return notas;
		}
		catch(Exception e ) {
			db.close();
			e.printStackTrace();
			return new ArrayList<>();
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
			PreparedStatement stmt = db.prepareStatement(sql);
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

	public static Note getNote(int id, String privateKey){
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			String sql = "SELECT name,isFixed,content,isArchived FROM note100 WHERE id=?";
			PreparedStatement stmt = db.prepareStatement(sql);
			stmt.setInt(1, id);
			ResultSet rs = stmt.executeQuery();
			while (rs.next()) {
				String name = rs.getString("name");
				String content = rs.getString("content");
				name = EncryptionHandler.decrypt(name, privateKey);
				content = EncryptionHandler.decrypt(content, privateKey);
				Note n = new Note (id, name, rs.getBoolean("isFixed"),content,rs.getBoolean("isArchived"));
				db.close();
				return n;
			}
			db.close();
			return null;
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return null;
		}
	}

	public static String getNoteUserID(int id) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		String result = "";
		try {
			String sql = "SELECT userID FROM note100 where id=? ";
			PreparedStatement stmt = db.prepareStatement(sql);
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

	public static void editNote(int id, String name, String content, User user, String privateKey,String isFixed,String isArchived) throws Exception{
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			System.out.println("Updating note...");
			// Encrypt content
			long startTime = System.nanoTime();
			content = EncryptionHandler.encrypt(content, privateKey);
			long ellapsedTime = System.nanoTime() - startTime;
			System.out.println("[debug] Ellapsed time to encrypt content: " + ellapsedTime );
			name = EncryptionHandler.encrypt(name, privateKey);
			// Update note
			String sql = "UPDATE note100 SET name=?, content=?, isFixed=?, isArchived=?, lastUpdate=LOCALTIME() WHERE id=? AND userID=?";
			startTime = System.nanoTime();
			PreparedStatement stmt = db.prepareStatement(sql);
			ellapsedTime = System.nanoTime() - startTime;
			System.out.println("[debug] Ellapsed time to prepare statement : " + ellapsedTime );
			stmt.setString(1, name);
			startTime = System.nanoTime();
			stmt.setString(2, content);
			ellapsedTime = System.nanoTime() - startTime;
			System.out.println("[debug] Ellapsed time to set String : " + ellapsedTime );

			if(isFixed.equals("true")) {
				stmt.setBoolean(3, true);
			}else if(isFixed.equals("false")) {
				stmt.setBoolean(3, false);
			}
			if(isArchived.equals("true")) {
				stmt.setBoolean(4, true);
			}else if(isArchived.equals("false")) {
				stmt.setBoolean(4, false);
			}
			stmt.setInt(5, id);
			stmt.setInt(6, user.getId());
			startTime = System.nanoTime();
			stmt.executeUpdate();
			ellapsedTime = System.nanoTime() - startTime;
			System.out.println("[debug] Ellapsed time to execute update : " + ellapsedTime );
			db.close();
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			throw e; //So the user receives a "error" message.
		}
	}

	public static void newEmptyNote(String username, String privateKey, String groupCodeName) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		User user = UserHandler.getUserFromUsername(username);
		int noteID = -1;
		try {
			String sql = "INSERT INTO note100 (name, content, userID, isFixed, lastUpdate) VALUES (?,?,?,false,NOW())";
			PreparedStatement stmt = db.prepareStatement(sql, Statement.RETURN_GENERATED_KEYS);
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
			PreparedStatement stmt = db.prepareStatement(sql);
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
