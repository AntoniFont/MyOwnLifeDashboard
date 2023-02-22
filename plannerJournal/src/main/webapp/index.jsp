<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*" %>
<%@ page import="plannerJournal.Note" %>
<%@ page import="plannerJournal.DatabaseManager" %>
<%@ page import="plannerJournal.NoteHandler" %>

<%@ page import="java.util.ArrayList" %>
<!DOCTYPE html>
<html>

<head>
    <!-- Import Bootstrap v5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <!-- Import Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

    <meta charset="UTF-8">
    <title>Insert title here</title>
</head>

<body>
    <div class="container mt-3" id ="mainMenu">
        <div class="row">
            <div class="col-2"> <!-- Buttons column-->
                <h1>Col 1</h1>
                <form>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Example textareaa</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1" disabled></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea2" class="form-label">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea2" rows="1" disabled></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" disabled>Submit</button>
                </form>
            </div>
            <div class="col-10"> <!-- Notes column-->
                <div class="border border-primary "> <!-- Notes container-->
                    <%
						ArrayList<Note> arr = NoteHandler.getNotes(1);
						int NCOL = 4;
						float NFILFloat = ((float) arr.size()) / ((float) NCOL)  ;
						int NFIL = (int) Math.ceil(NFILFloat);
                        int col = 0; 
                        int counter = 0;
						for (int fila= 0; fila < NFIL; fila++){
                            out.println("<div class=\"row\">");
                            while (col < NCOL && counter < arr.size()){
                                out.println("<div class=\"col-3\">");
                                out.println("<div class=\"d-flex justify-content-center\">");
                                out.println("<a id='note" +arr.get(counter).getId()+ "'><h3>" + arr.get(counter).getName() + "</h3></a>");
                                out.println("</div>");
                                out.println("</div>");
                                col++;
                                counter++;
                            }
                            col = 0;
                            out.println("</div>");
                        }
					%>
                </div>
            </div>
        </div>
    </div>
</body>
<!-- ADD NOTE ONCLICK HANDLERS -->
<%
	out.println("<script>");
    for (int i=0; i<arr.size(); i++){
        String noteSelector = "#note" + arr.get(i).getId();
        String link = "verNota.jsp?id=" + arr.get(i).getId() + "&name=" + request.getParameter("name");
        out.println("$('" + noteSelector + "').attr('href' ,'" + link +  "')");
    }
	out.println("</script>");
%>

</html>