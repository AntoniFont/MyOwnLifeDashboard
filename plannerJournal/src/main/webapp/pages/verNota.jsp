<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<%@ page import="java.util.ArrayList"%>
<%
String sessionUser = (String) request.getSession().getAttribute("user");
int id = Integer.parseInt(request.getParameter("id"));
User user = UserHandler.getUserFromUsername(sessionUser);
int userID = user.getId();
String groupCodeName = (String) request.getSession().getAttribute("groupCodeName");
if (sessionUser == null) {
	response.sendRedirect("login.jsp");
	return;
} else {
	if (Integer.parseInt(NoteHandler.getNoteUserID(id)) != userID) {
		response.sendRedirect("index.jsp");
		return;
	}
}
if (!NoteHandler.noteBelongsToGroup(id, groupCodeName, userID)) {
	response.sendRedirect("index.jsp");
	return;
}
%>

<%!String noteName;%>
<%
noteName = NoteHandler.getNoteName(Integer.parseInt(request.getParameter("id")),
		(String) request.getSession().getAttribute("aesKey"));
%>

<!DOCTYPE html>
<html>

<head>
<!-- Import Bootstrap v5 -->
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
	integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z"
	crossorigin="anonymous">
<!-- Bootstrap JS libraries -->
<script
			  src="https://code.jquery.com/jquery-3.5.1.min.js"
			  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
			  crossorigin="anonymous"></script>
<script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
	integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
	crossorigin="anonymous"></script>
<script
	src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
	crossorigin="anonymous"></script>
<meta charset="UTF-8">
<title><%=noteName%></title>
</head>

<body>
	<div class="container mt-3" id="noteContentMenu">
		<div class="row">
			<div class="col-10">
				<!--Content-->
				<h1 class="display-4" id="viewName">
					<%=noteName%>
				</h1>
				<textarea class="form-control" id="editName" style="display: none;"></textarea>

				<div class="border border-primary style="margin: 20px;">
					<div " id="viewContent">
						<%=NoteHandler.getNoteContent(Integer.parseInt(request.getParameter("id")),
		(String) request.getSession().getAttribute("aesKey"))%>
					</div>
				</div>
				<!--Edit content, invisible at the start-->
				<textarea class="form-control" id="editContent"
					style="display: none;"></textarea>

			</div>
			<div class="col-2">
				<button type="button" class="btn btn-primary" id="togglehtmeditor">Toggle
					editor</button>
				<button type="button" class="btn btn-primary" id="saveButton">Save
					All</button>
				<a href="index.jsp"><button type="button"
						class="btn btn-primary">Atrás</button></a>
				<!--A checkbox that displays if the note is fixed or not-->
				<div class="form-check">
					<input class="form-check-input" type="checkbox" value=""
						id="fixedNote"> <label class="form-check-label"
						for="fixedNote"> Fixed </label>
				</div>

			</div>
			<div class="row">
				<!--Invisible text area with id htmeditor-->
				<textarea id="htmeditor"></textarea>
				<script src="https://htmeditor.com/js/htmeditor.min.js"
					htmeditor_textarea="htmeditor" full_screen="no" editor_height="720"
					run_local="no"> 
				</script>
			</div>
		</div>
</body>
<script>

								let editMode = false;
</script>
<script>
							$(document).ready(function () {
								//wait 0.5 seconds before doing this
								setTimeout(function () {
									$("[role=application]").hide();
								}, 1500);
								function swapEdit() {	
									if(editMode == false){ //you where not editing
										//editor
										$("[role=application]").show();
										$("#viewContent").hide();
										tinymce.activeEditor.setContent($("#viewContent").html());										
										//name
										$("#viewName").hide();
										$("#editName").show();
										$("#editName").val($.trim($("#viewName").html()));
									}else{ //you where editing
										//editor
										$("[role=application]").hide();
										$("#viewContent").html(tinymce.activeEditor.getContent())
										$("#viewContent").show()
										//name
										$("#viewName").show();
										$("#editName").hide();
										$("#viewName").html($("#editName").val());
									}
									editMode = !editMode;
								}
								
								$("#togglehtmeditor").click(swapEdit);
								//save button on click
								$("#saveButton").click(function () {
									swapEdit(); 
									swapEdit();
									$.ajax({
										url: "../code/editNote.jsp",
										type: "POST",
										data: {
											noteId: <%=request.getParameter("id")%>,
											decriptionKey: $("#decryptionKey").val(),
											noteName: $("#editName").val(),
											noteContent: $("#viewContent").html(),
											isFixed:  $("#fixedNote").is(":checked")
										},
										success: function (data) {
											alert("Guardado correctamente!");
										},
										error: function (data) {
											alert("Error al guardar la nota editada en la base de datos")
										}
									});
								}
								);
							});
							
						</script>

</html>