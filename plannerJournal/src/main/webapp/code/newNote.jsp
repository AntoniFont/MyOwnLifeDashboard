<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<% 
NoteHandler.newEmptyNote((String) request.getSession().getAttribute("user"),(String) request.getSession().getAttribute("aesKey") ,(String) request.getSession().getAttribute("groupCodeName"));
%>