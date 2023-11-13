package plannerJournal;

import java.util.Base64;

public class Image {

	private byte [] imageData;
	private String imageString;
	
	public Image(byte[] imageData) {
		this.imageData = imageData;
	}
	
	public Image (String imageString) {
		this.imageString=imageString;
	}
	
	public String getStringRepresentation() {
		if(imageString == null) {
			return Base64.getEncoder().encodeToString(imageData);			
		}else {
			return imageString;
		}
	}
	
	public byte [] getBytes() {
		if(imageData != null) {
			return imageData;
		}else {
			return Base64.getDecoder().decode(imageString);
		}
	}
	
}
