<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<% 
//Read the new note content from the request
String newNoteContent = request.getParameter("noteContent");
NoteHandler.editNote(Integer.parseInt(request.getParameter("noteId")), request.getParameter("noteName"),newNoteContent);

%>