package plannerJournal;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;

public class PasswordHandler {

	//https://howtodoinjava.com/java/java-security/how-to-generate-secure-password-hash-md5-sha-pbkdf2-bcrypt-examples/
	public static String hashPassword(String passwordToHash) {
		String generatedPassword = null;

		try {
			// Create MessageDigest instance for MD5
			MessageDigest md = MessageDigest.getInstance("MD5");

			// Add password bytes to digest
			md.update(passwordToHash.getBytes());

			// Get the hash's bytes
			byte[] bytes = md.digest();

			// This bytes[] has bytes in decimal format. Convert it to hexadecimal format
			StringBuilder sb = new StringBuilder();
			for (byte element : bytes) {
				sb.append(Integer.toString((element & 0xff) + 0x100, 16).substring(1));
			}

			// Get complete hashed password in hex format
			generatedPassword = sb.toString();
			return generatedPassword;
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
			return "";
		}
	}
	//Check the database to see if the password is correct
	public static boolean checkPassword(String password, int userID) {
		String hashedPassword = hashPassword(password);
		String correctPassword = UserHandler.getHash(userID);
		if (hashedPassword.equals(correctPassword)) {
			return true;
		} else {
			return false;
		}
	}
}
