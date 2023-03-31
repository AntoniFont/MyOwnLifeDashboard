package plannerJournal;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
public class NotegroupHandler {

    private static boolean groupCodeNameExists(String groupCodeName, int userID) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        try {
            String sql = "SELECT id FROM notegroup WHERE codeName=? AND userID=?";
            PreparedStatement stmt = db.prepareStatement(sql);
            stmt.setString(1, groupCodeName);
            stmt.setInt(2, userID);
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


    public static int getNoteGroupIDFromCodeName(String groupCodeName, int userID) {
        // Get the group ID from the groupCodeName and the user
        DatabaseManager db = new DatabaseManager();
        db.open();
        int groupID = -1;
        try {
            String sql = "SELECT id FROM notegroup WHERE codeName=? AND userID=?";
            PreparedStatement stmt = db.prepareStatement(sql);
            stmt.setString(1, groupCodeName);
            stmt.setInt(2, userID);
            ResultSet rs = stmt.executeQuery();
            while (rs.next()) {
                groupID = rs.getInt("id");
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return groupID;

    }

    //create new note group
    public static void createNoteGroup(String groupCodeName, String username,String privateKey) {
        DatabaseManager db = new DatabaseManager();
        db.open();
        try {
            User user = UserHandler.getUserFromUsername(username);
            groupCodeName = EncryptionHandler.encrypt(groupCodeName, privateKey);
            if(groupCodeNameExists(groupCodeName, user.getId())){
                return;
            }else{
                String sql = "INSERT INTO notegroup (codeName, userID) VALUES (?, ?)";
                PreparedStatement stmt = db.prepareStatement(sql);
                stmt.setString(1, groupCodeName);
                stmt.setInt(2, user.getId());
                stmt.executeUpdate();
                NoteHandler.newEmptyNote(user.getName(), privateKey, groupCodeName);
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
    }
}
