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
            <script src="https://code.jquery.com/jquery-3.6.3.js"
                integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>

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
                            <button type="button" class="btn btn-primary" id="reloadButton">Reload</button>
                            <!--Invisible new note button-->
                            <button type="button" class="btn btn-primary" id="newNoteButton" style="display: none;">New
                                note</button>
                        </div>
                    </div>
                    <div class="col-10"> <!-- Notes column-->
                        <div class="border border-primary" id="notesContainer"> <!-- Notes container-->

                        </div>
                    </div>
                </div>
            </div>
        </body>

        <!--When reload is clicked make an ajax call to ../code/getNoteList.jsp with the parameters user and privateKey from the input with id decryptionKeyTextArea -->
        <script>
            $("#reloadButton").click(getList);
            function getList() {
                $.ajax({
                    url: "../code/getNoteList.jsp",
                    method: "POST",
                    data: {
                        groupCodeName: $("#groupCodeName").val()
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
        </script>

        </html>