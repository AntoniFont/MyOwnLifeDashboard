<%@ page contentType="image/png" %>
<%@ page import="plannerJournal.*"%>
<%@ page import="java.io.OutputStream" %>
    <% if (request.getSession().getAttribute("user")==null) { response.sendRedirect("../pages/login.jsp"); return; } %>
    
    
<%

String secretKey = request.getParameter("secretKey");
String indexStr = request.getParameter("index");
Image imagen = ImageHandler.downloadImage(secretKey,Integer.parseInt(indexStr));

try (OutputStream fuera = response.getOutputStream()) {
    fuera.write(imagen.getBytes());
 }

%>

