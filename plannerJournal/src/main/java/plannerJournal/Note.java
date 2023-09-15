package plannerJournal;

public class Note {
    private int id;
    private String name;
    private boolean isFixed;
    private String content;
    private boolean isArchived;


    public Note(int id, String name,boolean isFixed) {
        this.id = id;
        this.name = name;
        this.isFixed = isFixed;
    }
    
    
    public Note(int id, String name,boolean isFixed,String content) {
        this.id = id;
        this.name = name;
        this.isFixed = isFixed;
        this.content = content;
    }
    
    public Note(int id, String name,boolean isFixed,String content,boolean isArchived) {
        this.id = id;
        this.name = name;
        this.isFixed = isFixed;
        this.content = content;
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
    public String getContent() {
    	return content;
    }
    public boolean isArchived() {
    	return isArchived;
    }
    

	@Override
	public String toString() {
		return "Note [id=" + id + ", name=" + name + ", isFixed=" + isFixed + "]";
	}
    
    
}
