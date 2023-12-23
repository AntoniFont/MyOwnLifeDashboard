<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>

    <!--Check if the user is logged in-->
    <% if (request.getSession().getAttribute("user")==null) { response.sendRedirect("login.jsp"); return; } %>
        <!DOCTYPE html>
        <html>

        <head>
            <!-- Import Bootstrap v5 -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
                crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
                crossorigin="anonymous"></script>
            <!-- Import Jquery -->
            <script src="./jquery.js"></script>

            <meta charset="UTF-8">
            <title>Insert title here</title>
        </head>

        <body>
            <div class="container mt-3" id="mainMenu">
                <h1>Hello, <%= (String) request.getSession().getAttribute("user") %>
                </h1>
                <div class="row">
                    <div class="col-2"> <!-- Buttons column-->
                        <div class="mb-3">
                            <input type="text" placeholder="Insert group code name" id="groupCodeName"
                                autocomplete="off">
                            <input type="checkbox" id="archived" name="archived">
                            <label for="archived">Display archived</label>
                            <button type="button" class="btn btn-primary" id="reloadButton">Reload</button>
                            <!--Invisible new note button-->
                            <button type="button" class="btn btn-primary" id="newNoteButton" style="display: none;">New
                                note</button>
                        </div>
                        <div class="mb-3">
                            <button type="button" class="btn btn-primary" id="newGroupButton">New group</button>
                            <input type="text" placeholder="Group Name" id="newGroupText"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
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
    
    <script>
        // JavaScript code to display the selected image
        document.getElementById('imageInput').addEventListener('change', function (e) {
            var selectedImage = document.getElementById('selectedImage');
            selectedImage.src = URL.createObjectURL(e.target.files[0]);
        });
    </script>
                    	</div>
                    </div>
                    <div class="col-10"> <!-- Notes column-->
                        <div class="border border-primary" id="notesContainer"> <!-- Notes container-->

                        </div>
                    </div>
                </div>
            </div>
        </body>

        <script>
        $(document).ready(function () {
            $("#reloadButton").click(getList);
            function getList() {
                let checked = "false";
                if($("#archived").is(":checked")){
                    checked = "true";
                }
                $.ajax({
                    url: "../code/getNoteList.jsp",
                    method: "POST",
                    data: {
                        groupCodeName: $("#groupCodeName").val(),
                        archived: checked
                    },
                    success: function (data) {
                        $("#notesContainer").html(data);
                        $("#newNoteButton").show();
                    },

                })
            }
            $("#newNoteButton").click(function(){
                $.ajax({
                    url: "../code/newNote.jsp",
                    method : "POST",
                    success: function(data){
                        alert("New note created!, reload the page to see it")
                    }
                })
            })
            $("#newGroupButton").click(function(){
                $.ajax({
                    url: "../code/newGroup.jsp",
                    method: "POST",
                    data: {
                        groupCodeName: $("#newGroupText").val()
                    },
                    success: function(data){
                    	$("#newGroupText").val("");
                        alert("New group created!, search it to see it")
                    },
                    error: function (data) {
						alert("Error creating new group")
					}

                })
            });
        });
        
        </script>

        </html>