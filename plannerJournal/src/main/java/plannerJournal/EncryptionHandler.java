package plannerJournal;

import java.io.File;
import java.io.FileOutputStream;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.security.InvalidAlgorithmParameterException;
import java.security.InvalidKeyException;
import java.security.KeyFactory;
import java.security.KeyPair;
import java.security.KeyPairGenerator;
import java.security.NoSuchAlgorithmException;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.spec.EncodedKeySpec;
import java.security.spec.InvalidKeySpecException;
import java.security.spec.KeySpec;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Base64;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.IllegalBlockSizeException;
import javax.crypto.NoSuchPaddingException;
import javax.crypto.SecretKey;
import javax.crypto.SecretKeyFactory;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.PBEKeySpec;
import javax.crypto.spec.SecretKeySpec;

//https://www.cesarsotovalero.net/blog/encoding-encryption-hashing-and-obfuscation-in-java.html
public class EncryptionHandler {
	private static final String SALTVALUE = "what da heck aes doesnt require salt. whatever.";


	/* Encryption Method */
	public static String encrypt(String strToEncrypt,String SECRET_KEY) {
		try {
			/* Declare a byte array. */
			byte[] iv = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 };
			IvParameterSpec ivspec = new IvParameterSpec(iv);
			/* Create factory for secret keys. */
			SecretKeyFactory factory = SecretKeyFactory.getInstance("PBKDF2WithHmacSHA256");
			/* PBEKeySpec class implements KeySpec interface. */
			KeySpec spec = new PBEKeySpec(SECRET_KEY.toCharArray(), SALTVALUE.getBytes(), 65536, 256);
			SecretKey tmp = factory.generateSecret(spec);
			SecretKeySpec secretKey = new SecretKeySpec(tmp.getEncoded(), "AES");
			Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
			cipher.init(Cipher.ENCRYPT_MODE, secretKey, ivspec);
			/* Retruns encrypted value. */
			return Base64.getEncoder().encodeToString(cipher.doFinal(strToEncrypt.getBytes(StandardCharsets.UTF_8)));
		} catch (InvalidAlgorithmParameterException | InvalidKeyException | NoSuchAlgorithmException
				| InvalidKeySpecException | BadPaddingException | IllegalBlockSizeException
				| NoSuchPaddingException e) {
			System.out.println("Error occured during encryption: " + e.toString());
		}
		return null;
	}

	/* Decryption Method */
	public static String decrypt(String strToDecrypt,String SECRET_KEY) {
		try {
			/* Declare a byte array. */
			byte[] iv = { 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0 };
			IvParameterSpec ivspec = new IvParameterSpec(iv);
			/* Create factory for secret keys. */
			SecretKeyFactory factory = SecretKeyFactory.getInstance("PBKDF2WithHmacSHA256");
			/* PBEKeySpec class implements KeySpec interface. */
			KeySpec spec = new PBEKeySpec(SECRET_KEY.toCharArray(), SALTVALUE.getBytes(), 65536, 256);
			SecretKey tmp = factory.generateSecret(spec);
			SecretKeySpec secretKey = new SecretKeySpec(tmp.getEncoded(), "AES");
			Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5PADDING");
			cipher.init(Cipher.DECRYPT_MODE, secretKey, ivspec);
			/* Retruns decrypted value. */
			System.out.println(strToDecrypt);
			return new String(cipher.doFinal(Base64.getDecoder().decode(strToDecrypt)));
		} catch (InvalidAlgorithmParameterException | InvalidKeyException | NoSuchAlgorithmException
				| InvalidKeySpecException | BadPaddingException | IllegalBlockSizeException
				| NoSuchPaddingException e) {
			System.out.println("Error occured during decryption: " + e.toString());
			e.printStackTrace();
		}
		return null;
	}

}
