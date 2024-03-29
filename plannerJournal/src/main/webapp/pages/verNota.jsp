<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<%@ page import="java.util.ArrayList"%>
<%
int id,userID;
User user;
String groupCodeName;
String sessionUser = (String) request.getSession().getAttribute("user");
if (sessionUser == null) {
	response.sendRedirect("login.jsp");
	return;
} else {
	id = Integer.parseInt(request.getParameter("id"));
	user = UserHandler.getUserFromUsername(sessionUser);
    userID = user.getId();
	groupCodeName = (String) request.getSession().getAttribute("groupCodeName");
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

<%!Note note;%>
<%
note = NoteHandler.getNote(Integer.parseInt(request.getParameter("id")), (String) request.getSession().getAttribute("aesKey"));
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
            <!-- Import Jquery -->
            <script src="./jquery.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
	integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
	crossorigin="anonymous"></script>
<script
	src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
	integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
	crossorigin="anonymous"></script>
<meta charset="UTF-8">
<title>Planner Journal Note <%=note.getId()%></title>
</head>

<body>
	<div class="container mt-3" id="noteContentMenu">
		<div class="row">
			<div class="col-10">
				<!--Content-->
				<h1 class="display-4" id="viewName">
					<%=note.getName()%>
				</h1>
				<textarea class="form-control" id="editName" style="display: none;"></textarea>

				<div class="border border-primary style="margin: 20px;">
					<div " id="viewContent">
						<%=note.getContent()%>
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
				<!--A checkbox that displays if the note is fixed or not and another one for archived-->
				<div class="form-check">
					<%
						if(note.isFixed()){
							out.println("<input class='form-check-input' type='checkbox' id='fixedNote' checked>");
						}else{
							out.println("<input class='form-check-input' type='checkbox' id='fixedNote'>");
						}					
					%>
					<label class="form-check-label" for="fixedNote"> Fixed </label>
					</div>	
						<div class="form-check">
							<%
						if(note.isArchived()){
							out.println("<input class='form-check-input' type='checkbox' id='archivedNote' checked>");
						}else{
							out.println("<input class='form-check-input' type='checkbox' id='archivedNote'>");
						}					
					%>
				
					 
					<label class="form-check-label" for="fixedNote"> Archived </label>
				</div>
				   <form action="../code/addImage.jsp" target="_blank" method="post" enctype="multipart/form-data">
        <!-- Other form elements go here -->

        <!-- Image input -->
        <label for="imageInput">Select an image:</label>
        <input class="form-control" type="file" id="imageInput" name="imageInput" accept="image/*">

        <!-- Display the selected image -->
        <img id="selectedImage" src="#" alt="Selected Image" style="max-width: 100%;">

        <!-- Submit button -->
        <input class="form-control" type="submit" value="Submit">
    </form>

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
									$("#saveButton").prop("disabled",true);
									$.ajax({
										url: "../code/editNote.jsp",
										type: "POST",
										data: {
											noteId: <%=request.getParameter("id")%>,
											decriptionKey: $("#decryptionKey").val(),
											noteName: $("#editName").val(),
											noteContent: $("#viewContent").html(),
											isFixed:  $("#fixedNote").is(":checked"),
											isArchived:  $("#archivedNote").is(":checked")
										},
										success: function (data) {
											$("#saveButton").prop("disabled",false);
											alert("Guardado correctamente!");
										},
										error: function (data) {
											$("#saveButton").prop("disabled",false);
											alert("Error al guardar la nota editada en la base de datos")
										}
									});
								}
								);
							});
							
						</script>

</html>