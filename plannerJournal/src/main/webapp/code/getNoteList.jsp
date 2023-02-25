<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<%@ page import="java.util.ArrayList"%>
<%@ page import="java.net.URLDecoder" %>
<%
//URL decode the private key
//String privateKey = URLDecoder.decode(request.getParameter("privateKey"),"UTF-8" );
String privateKey = request.getParameter("privateKey");
ArrayList<Note> arr = NoteHandler.getNotes((String) request.getSession().getAttribute("user"),privateKey);
int NCOL = 4;
float NFILFloat = ((float) arr.size()) / ((float) NCOL);
int NFIL = (int) Math.ceil(NFILFloat);
int col = 0;
int counter = 0;
for (int fila = 0; fila < NFIL; fila++) {
	out.println("<div class=\"row\">");
	while (col < NCOL && counter < arr.size()) {
		out.println("<div class=\"col-3\">");
		out.println("<div class=\"d-flex justify-content-center\">");
		out.println("<a id='note" + arr.get(counter).getId() + "'><h4>" + arr.get(counter).getName() + "</h4></a>");
		out.println("</div>");
		out.println("</div>");
		col++;
		counter++;
	}
	col = 0;
	out.println("</div>");
}
%>
<!-- ADD NOTES ON CLICK HANDLERS -->
<%
out.println("<script>");
for (int i = 0; i < arr.size(); i++) {
	String noteSelector = "#note" + arr.get(i).getId();
	String link = "verNota.jsp?id=" + arr.get(i).getId();
	out.println("$('" + noteSelector + "').attr('href' ,'" + link + "')");
}
out.println("</script>");
%>