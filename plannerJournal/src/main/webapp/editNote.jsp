<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<% 
//Read the new note content from the request
String newNoteContent = request.getParameter("noteContent");
User user = UserHandler.getUserFromUsername(request.getParameter("name"));
int noteID = Integer.parseInt(request.getParameter("noteId"));
String noteName = request.getParameter("noteName");
NoteHandler.editNote(noteID,noteName, newNoteContent,user);
%>