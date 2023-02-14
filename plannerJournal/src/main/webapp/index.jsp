<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.DatabaseManager" %>
<%@ page import="java.util.ArrayList" %>
<!DOCTYPE html>
<html>

<head>
    <!-- Import Bootstrap v5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>


    <meta charset="UTF-8">
    <title>Insert title here</title>
</head>

<body>

<% 
DatabaseManager db = new DatabaseManager();
ArrayList<String> arr = db.getNicknames();
for (int i = 0; i < arr.size(); i++) {
    out.println(arr.get(i));
}
%>
    <div class="container mt-3">
        <div class="row">
            <div class="col-2"> <!-- Buttons column-->
                <h1>Col 1</h1>
                <form>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Example textareaa</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="1"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlTextarea2" class="form-label">Example textarea</label>
                        <textarea class="form-control" id="exampleFormControlTextarea2" rows="1"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-10"> <!-- Notes column-->

                <div class="border border-primary "> <!-- Notes container-->
                    <div class="row">
                        <div class="col-3">
                            <div class="d-flex justify-content-center">
                                <h1>1</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">

                                <h1>2</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">

                                <h1>3</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">
                                <h1>4</h1>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="d-flex justify-content-center">
                                <h1>1</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">

                                <h1>2</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">

                                <h1>3</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">
                                <h1>4</h1>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <div class="d-flex justify-content-center">
                                <h1>1</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">

                                <h1>2</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">

                                <h1>3</h1>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-center">
                                <h1>4</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>