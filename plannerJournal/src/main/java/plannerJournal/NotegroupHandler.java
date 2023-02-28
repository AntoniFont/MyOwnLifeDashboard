package plannerJournal;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
public class NotegroupHandler {

    
    public static int getNoteGroupIDFromCodeName(String groupCodeName, int userID) {
        // Get the group ID from the groupCodeName and the user
        DatabaseManager db = new DatabaseManager();
        db.open();
        int groupID = -1;
        try {
            String sql = "SELECT id FROM notegroup WHERE codeName=? AND userID=?";
            PreparedStatement stmt = db.connection.prepareStatement(sql);
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
}
