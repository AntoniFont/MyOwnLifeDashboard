package plannerJournal;

public class User {
    private String id;
    private String name;
    private String publicKey;

    public User(String id, String name, String publicKey) {
        this.id = id;
        this.name = name;
        this.publicKey = publicKey;
    }

    public String getPublicKey() {
        return publicKey;
    }

    public int getId() {
        return Integer.parseInt(id);
    }

    public String getName() {
        return name;
    }

}
