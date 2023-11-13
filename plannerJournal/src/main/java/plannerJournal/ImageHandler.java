package plannerJournal;

import java.nio.charset.Charset;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Random;
import java.util.UUID;

public class ImageHandler {
	
	/**
	 * 
	 * @param imagen
	 * @return an array with the first element the index of the image and the second element the secret key
	 * used to encrypt the image
	 */
	public static String[] uploadImage(Image imagen) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			String sql = "INSERT INTO images SET images.data=?";
			PreparedStatement stmt = db.prepareStatement(sql,Statement.RETURN_GENERATED_KEYS);
			String secretKey = UUID.randomUUID().toString();
		    String imagenEncryptada = EncryptionHandler.encrypt(imagen.getStringRepresentation(), secretKey);
			stmt.setString(1, imagenEncryptada);
			stmt.executeUpdate();
			ResultSet keys = stmt.getGeneratedKeys();
			keys.next();
			int indice = keys.getInt(1);
			String arr[] = {"" + indice,"" + secretKey}; 
			return arr;
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return null;
		}
	}
	
	public static Image downloadImage(String SECRET_KEY,int index) {
		DatabaseManager db = new DatabaseManager();
		db.open();
		try {
			String sql = "SELECT data FROM images WHERE id=?";
			PreparedStatement stmt = db.prepareStatement(sql);
			stmt.setInt(1, index);
			ResultSet rs = stmt.executeQuery();
			rs.next();
			String imagenStringEncriptada = rs.getString(1);
			String imagenStringDesencriptada = EncryptionHandler.decrypt(imagenStringEncriptada, SECRET_KEY);
			return new Image(imagenStringDesencriptada);
		} catch (Exception e) {
			db.close();
			e.printStackTrace();
			return null;
		}
	}
}
