<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@ page import="plannerJournal.*"%>
<%
    String username = request.getParameter("username");
    String password = request.getParameter("password");
    String password2 = request.getParameter("password2");
        if(password.equals(password2)){
            out.println("Your hashed password is: " + PasswordHandler.hashPassword(password) + " talk to the system admin to get registered");
            out.println("<br><a href='../pages/login.jsp'>Login page</a>");
        } else {
            response.sendRedirect("../pages/register.html?error=Passwords do not match");
        }
    
%>