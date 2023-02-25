package plannerJournal;

public class User {
    private String id;
    private String name;

    public User(String id, String name) {
        this.id = id;
        this.name = name;
    }

    public int getId() {
        return Integer.parseInt(id);
    }

    public String getName() {
        return name;
    }

}
