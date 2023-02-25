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
            /*
            THIS IS DUMB. SINCE THIS IS A PERSONAL PAGE WITHOUT SENSITIVE 
            INFORMATION, I WILL SAVE THE PASSWORD AND USE IT AS THE AES KEY.
            
            I'M ONLY A STUDENT, I'M NOT CAPABLE (YET) OF IMPLEMENTING A REALLY
            SECURE SYSTEM / I DON'T HAVE ENOUGH TIME.
            
            AT LEAST I'M DETECTING THAT THIS IS NOT SECURE, WHICH IS A GOOD FIRST
            STEP.
            */
            session.setAttribute("aesKey", password);
            response.sendRedirect("../pages/index.jsp");
        }else{
            response.sendRedirect("../pages/login.jsp?error=Wrong password");
        }
    } else {
        response.sendRedirect("../pages/login.jsp?error=Username does not exist");
    }

%>