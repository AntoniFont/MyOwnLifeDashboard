<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
    pageEncoding="ISO-8859-1"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Insert title here</title>
 <!-- Import Jquery -->
 <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

</head>
<body>
<!-- Ask for username, and password two times-->
<form action="../code/verifyRegister.jsp" method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username">
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
    <label for="password">Repeat Password</label>
    <input type="password" name="password2" id="password2">
    <input type="submit" value="Register">
</form>
<script>
    $(document).ready(function(){
        //Print the error message from the parameter
        var error = "<%=request.getParameter("error")%>";
        if(error != "" && error != null){
            alert(error);
        }
    });
</script>
</body>
</html>