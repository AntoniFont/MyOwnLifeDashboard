package plannerJournal;

public class Note {
    private int id;
    private String name;
    private String content;



    public Note(int id, String name, String content) {
        this.id = id;
        this.name = name;
        this.content = content;
    }


    //GETTERS
    public int getId() {
        return id;
    }
    public String getName() {
        return name;
    }
    public String getContent() {
        return content;
    }
}
