package plannerJournal;

public class Note {
    private int id;
    private String name;
    private boolean isFixed;


    public Note(int id, String name,boolean isFixed) {
        this.id = id;
        this.name = name;
        this.isFixed = isFixed;
    }
 

    //GETTERS
    public int getId() {
        return id;
    }
    public String getName() {
        return name;
    }
    public boolean isFixed() {
    	return isFixed;
    }


	@Override
	public String toString() {
		return "Note [id=" + id + ", name=" + name + ", isFixed=" + isFixed + "]";
	}
    
    
}
