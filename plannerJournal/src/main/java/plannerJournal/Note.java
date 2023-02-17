package plannerJournal;

public class Note {
    private int id;
    private String name;



    public Note(int id, String name) {
        this.id = id;
        this.name = name;
    }


    //GETTERS
    public int getId() {
        return id;
    }
    public String getName() {
        return name;
    }
}
