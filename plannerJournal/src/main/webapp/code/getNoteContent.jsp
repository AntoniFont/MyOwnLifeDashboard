<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<%=NoteHandler.getNoteContent(Integer.parseInt(request.getParameter("id")), (String) request.getSession().getAttribute("aesKey"))%>
	