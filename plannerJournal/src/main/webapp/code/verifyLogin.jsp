<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<%@ page import="plannerJournal.*"%>
<%
    String username = request.getParameter("username");
    String password = request.getParameter("password");

    if(UserHandler.existsUser(username)){
        User user = UserHandler.getUserFromUsername(username);
        if(PasswordHandler.checkPassword(password, user.getId())){
            request.getSession().setAttribute("user", user.getName());
            response.sendRedirect("../pages/index.jsp");
        }else{
            response.sendRedirect("../pages/login.jsp?error=Wrong password");
        }
    } else {
        response.sendRedirect("../pages/login.jsp?error=Username does not exist");
    }

%>