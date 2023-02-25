package plannerJournal;

import java.io.File;
import java.io.FileOutputStream;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.security.KeyFactory;
import java.security.KeyPair;
import java.security.KeyPairGenerator;
import java.security.PrivateKey;
import java.security.PublicKey;
import java.security.spec.EncodedKeySpec;
import java.security.spec.PKCS8EncodedKeySpec;
import java.security.spec.X509EncodedKeySpec;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.util.Base64;

import javax.crypto.Cipher;

//https://www.cesarsotovalero.net/blog/encoding-encryption-hashing-and-obfuscation-in-java.html
public class EncryptionHandler {

	/*
	 * public static void createRSAKeys(File publicKeyFile, File privateKeyFile)
	 * throws Exception { KeyPairGenerator generator =
	 * KeyPairGenerator.getInstance("RSA"); generator.initialize(2048); KeyPair pair
	 * = generator.generateKeyPair(); try (FileOutputStream fos = new
	 * FileOutputStream(publicKeyFile)) { byte[] salida =
	 * pair.getPublic().getEncoded(); fos.write(Base64.getEncoder().encode(salida));
	 * } try (FileOutputStream fos = new FileOutputStream(privateKeyFile)) { byte[]
	 * salida = pair.getPrivate().getEncoded();
	 * fos.write(Base64.getEncoder().encode(salida)); } }
	 */

	public static String encryptMessage(String secretMessage, User user) throws Exception {
		Cipher encryptCipher = Cipher.getInstance("RSA");
		encryptCipher.init(Cipher.ENCRYPT_MODE, getRSAPublicKey(user));
		byte[] secretMessageBytes = secretMessage.getBytes(StandardCharsets.UTF_8);
		byte[] encryptedMessageBytes = encryptCipher.doFinal(secretMessageBytes);
		return Base64.getEncoder().encodeToString(encryptedMessageBytes);
	}

	public static String decryptMessage(String encryptedMessage, String privateKeyString) throws Exception {
		Cipher decryptCipher = Cipher.getInstance("RSA");
		decryptCipher.init(Cipher.DECRYPT_MODE, createRSAPrivateKeyObject(privateKeyString));
		byte[] decryptedMessageBytes = decryptCipher.doFinal(Base64.getDecoder().decode(encryptedMessage));
		return new String(decryptedMessageBytes, StandardCharsets.UTF_8);
	}

	// PRIVATE
	private static PublicKey getRSAPublicKey(User user) throws Exception {
		byte[] publicKeyBytes = Base64.getDecoder().decode(user.getPublicKey().getBytes());
		KeyFactory keyFactory = KeyFactory.getInstance("RSA");
		EncodedKeySpec publicKeySpec = new X509EncodedKeySpec(publicKeyBytes);
		return keyFactory.generatePublic(publicKeySpec);
	}

	private static PrivateKey createRSAPrivateKeyObject(String privateKeyString) throws Exception {
		byte[] privateKeyBytes = Base64.getDecoder().decode(privateKeyString.getBytes());
		KeyFactory keyFactory = KeyFactory.getInstance("RSA");
		EncodedKeySpec privateKeySpec = new PKCS8EncodedKeySpec(privateKeyBytes);
		return keyFactory.generatePrivate(privateKeySpec);
	}

}
