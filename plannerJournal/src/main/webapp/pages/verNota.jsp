<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>
<%@ page import="plannerJournal.*" %>
<%@ page import="java.util.ArrayList" %>
<%
	String sessionUser = (String) request.getSession().getAttribute("user");

    if (sessionUser == null) {
        response.sendRedirect("login.jsp");
		return;
    }else{
    	User user = UserHandler.getUserFromUsername(sessionUser);	
    	int id = Integer.parseInt(request.getParameter("id"));
    	if(Integer.parseInt(NoteHandler.getNoteUserID(id)) != user.getId()){
    		response.sendRedirect("index.jsp");
			return;
		}
    }
	%>

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
	<script src="https://code.jquery.com/jquery-3.6.3.js"
		integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

	<meta charset="UTF-8">
	<title>Insert title here</title>
</head>

<body>
	<div class="container mt-3" id="noteContentMenu">
		<div class="row">
			<div class="col-10">
				<!--Content-->
				<h1 class="display-4" id="viewName">
					Insert decryption key to see the name
				</h1>
				<textarea class="form-control" id="editName" style="display: none;"></textarea>

				<div class="border border-primary " id="viewContent">
				<p>Introduce la clave de desencriptación</p>
					<!--  TO BE FILLED WITH CONTENT -->
				</div>
				<!--Edit content, invisible at the start-->
				<textarea class="form-control" id="editContent" style="display: none;"></textarea>

			</div>
			<div class="col-2">
				<button type="button" class="btn btn-primary" id="editButton">Edit</button>
				<button type="button" class="btn btn-primary" id="reloadButton">Reload</button>
				<a href="index.jsp"><button type="button" class="btn btn-primary">Atrás</button></a>
				<form action="">
				<input type="password" name="password" id="decryptionKeyTextArea" placeholder="Insert decryption key" autocomplete="on">
				<input type="submit" value="Guardar key en el navegador">
				</form>
				<!--Reload button-->
			</div>
		</div>
		<div class="row">
			<!--<textarea id="htmeditor"></textarea>
			<script src="https://htmeditor.com/js/htmeditor.min.js" htmeditor_textarea="htmeditor" full_screen="no" editor_height="720" run_local="no"> </script> 
			-->
		</div>
	</div>
</body>

<!-- Edit button logic-->
<script>
	$(document).ready(function () {
		$("#editButton").click(function () {

			//If we are on view content mode
			if ($("#viewContent").is(":visible")) {
				$("#editButton").text("Save");
				$("#viewContent").hide();
				$("#viewName").hide();
				$("#editName").show();
				$("#editContent").show();
				$("#editContent").val($.trim($("#viewContent").html()));
				$("#editName").val($.trim($("#viewName").html()));

			} else {
				$("#editButton").text("Edit");
				$("#viewContent").show();
				$("#viewName").show();
				$("#editName").hide();
				$("#editContent").hide();
				$("#viewContent").html($("#editContent").val());
				$("#viewName").html($("#editName").val());
				$.ajax({
					url: "../code/editNote.jsp",
					type: "GET",
					data: {
						noteId: <%=request.getParameter("id") %>,
						decriptionKey: $("#decryptionKey").val(),
						noteName: $("#editName").val(),
						noteContent: $("#editContent").val()
					},
					success: function (data) {
					},
					error: function (data) {
						alert("Error al guardar la nota editada en la base de datos")
					}
				});
			}

		});
	});
</script>
<!--Private key inserted logic-->
<script>
	//Ajax call to getNoteContent.jsp with the parameter id and privateKey from the textarea decryptionKeyTextArea
	$("#decryptionKeyTextArea").keyup(getData);
	$("#reloadButton").click(getData);
	$("#decryptionKeyTextArea").keyup(getName);
	$("#reloadButton").click(getName);
	function getData() {
		if ($("#decryptionKeyTextArea").val() != "") {
			$.ajax({
				url: "../code/getNoteContent.jsp",
				type: "GET",
				data: {
					id: <%=request.getParameter("id") %>,
					privateKey: $("#decryptionKeyTextArea").val()
				},
				success: function (data) {
					$("#viewContent").html(data);
				},
				error: function (data) {
					$("#viewContent").html("<p>Error al obtener el contenido de la nota, probablemente privateKey inválida</p>")
				}
			});
		}
	}
	
	function getName(){
		if ($("#decryptionKeyTextArea").val() != "") {
			$.ajax({
				url: "../code/getNoteName.jsp",
				type: "GET",
				data: {
					id: <%=request.getParameter("id") %>,
					privateKey: $("#decryptionKeyTextArea").val()
				},
				success: function (data) {
					console.log("Obtenido el nombre: " + data);
					$("#viewName").html(data);
				},
				error: function (data) {
					$("#viewName").html("<p>Error al obtener el texto de la nota, probablemente privateKey inválida</p>")
				}
			});
		}
	}
</script>

</html>