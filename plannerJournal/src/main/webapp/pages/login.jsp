<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- Import Jquery -->
     <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

</head>
<body>
    <!-- HTML FORM THAT ASKS FOR USERNAME AND PASSWORD-->
    <form action="../code/verifyLogin.jsp" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Login">
    </form>
    <!-- SIGN UP LINK -->
    <a href="./register.jsp">Sign up</a>
    <!-- SCRIPT TO PRINT ERROR MESSAGE -->
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
