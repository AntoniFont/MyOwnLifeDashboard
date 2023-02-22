<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<%@ page import="java.util.ArrayList"%>
<!DOCTYPE html>
<html>

<head>
<!-- Import Bootstrap v5 -->
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
	rel="stylesheet"
	integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
	crossorigin="anonymous">
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
	crossorigin="anonymous"></script>
<!-- Import Jquery -->
<script src="https://code.jquery.com/jquery-3.6.3.js"
	integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM="
	crossorigin="anonymous"></script>

<meta charset="UTF-8">
<title>Insert title here</title>
</head>
<body>
	<div class="container mt-3" id="noteContentMenu">
		<div class="row">
			<div class="col-10">
				<!--Content-->
				<h1 class="display-4" id ="viewName"><%=NoteHandler.getNoteName(Integer.parseInt(request.getParameter("id"))) %> </h1>
				<textarea class="form-control" id="editName" style="display: none;"></textarea>
				
				<div class="border border-primary " id="viewContent">
					<%=NoteHandler.getNoteContent(Integer.parseInt(request.getParameter("id"))) %>
				</div>
				<!--Edit content, invisible at the start-->
				<textarea class="form-control" id="editContent" style="display: none;"></textarea>
				
			</div>
			<div class="col-2">
				<!-- Edit button-->
				<button type="button" class="btn btn-primary" id="editButton">Edit</button>
				<br>
				<a href="index.jsp"><button type="button" class="btn btn-primary">Atrás</button></a>
				<!-- Insert decryption key textarea-->
				<textarea class="form-control" id="decryptionKey" placeholder="Insert decryption key"></textarea>
			</div>
		</div>
	</div>
</body>
<!-- Edit button logic-->
<script >
	$(document).ready(function() {
		$("#editButton").click(function() {
			
			//If we are on view content mode
			if($("#viewContent").is(":visible")){
				$("#editButton").text("Save");
				$("#viewContent").hide();
				$("#viewName").hide();
				$("#editName").show();
				$("#editContent").show();
				$("#editContent").val($.trim($("#viewContent").html()));
				$("#editName").val($.trim($("#viewName").html()));

			}else{
				$("#editButton").text("Edit");
				$("#viewContent").show();
				$("#viewName").show();
				$("#editName").hide();
				$("#editContent").hide();
				$("#viewContent").html($("#editContent").val());
				$("#viewName").html($("#editName").val());
				$.ajax({
					url: "editNote.jsp",
					type: "GET",
					data: {
						name: "<%=request.getParameter("name")%>",
						noteId: <%=request.getParameter("id")%>,
						decriptionKey: $("#decryptionKey").val(),
						noteName: $("#editName").val(),
						noteContent: $("#editContent").val()
					},
					success: function(data) {
					},
					error: function(data) {
						alert("Error al guardar la nota editada en la base de datos")
					}
				});
			}
			
		});
	});
</script>
</html>