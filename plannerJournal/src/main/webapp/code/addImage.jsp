<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="org.apache.commons.fileupload.servlet.ServletFileUpload"%>
<%@ page import="org.apache.commons.fileupload.disk.DiskFileItemFactory, org.apache.commons.fileupload.FileItem" %>
<%@ page import="plannerJournal.*"%>
<%@ page import="java.util.List, java.io.InputStream, java.io.ByteArrayOutputStream, java.util.Base64" %>
<!--Check if the user is logged in-->
    <% if (request.getSession().getAttribute("user")==null) { response.sendRedirect("../pages/login.jsp"); return; } %>
    
<html>
<head>
    <title>File Upload</title>
</head>
<body>

<%
// Check if the request is a file upload
if (ServletFileUpload.isMultipartContent(request)) {
    try {
        // Create a factory for disk-based file items
        DiskFileItemFactory factory = new DiskFileItemFactory();

        // Create a new file upload handler
        ServletFileUpload upload = new ServletFileUpload(factory);

        // Parse the request to get file items
        List<FileItem> items = upload.parseRequest(request);

        // Iterate over the file items
        for (FileItem item : items) {
            if (!item.isFormField()) {
                // Process file upload
                String fileName = item.getName();
                InputStream fileContent = item.getInputStream();

                // Convert the image to Base64
                ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                byte[] buffer = new byte[8192];
                int bytesRead;
                while ((bytesRead = fileContent.read(buffer, 0, 8192)) != -1) {
                    byteArrayOutputStream.write(buffer, 0, bytesRead);
                }

                byte[] imageData = byteArrayOutputStream.toByteArray();
                Image imagen = new Image(imageData);
                String datos[] = ImageHandler.uploadImage(imagen);
                String indice = datos[0];
                String secretKey = datos[1];
                String currentURL = request.getRequestURL().toString();
                // Find the last occurrence of '/'
                int lastSlashIndex = currentURL.lastIndexOf('/');
                // If '/' is found, extract the substring until that index
                String result = (lastSlashIndex != -1) ? currentURL.substring(0, lastSlashIndex) : currentURL;
                result = result + "/getImage.jsp?index=" + indice +"&secretKey="+ secretKey;
                out.println(result);
            }
        }
    } catch (Exception e) {
        // Handle exceptions
        out.println("<p>Error uploading file: " + e.getMessage() + "</p>");
    }
} else {
    // The request is not a file upload
    out.println("<p>The request is not a file upload</p>");
}
%>

</body>
</html>