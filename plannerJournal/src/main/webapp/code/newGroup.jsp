<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ page import="plannerJournal.*"%>
<% 
String groupCodeName = request.getParameter("groupCodeName");
String username = (String) request.getSession().getAttribute("user");
String privateKey = (String) request.getSession().getAttribute("aesKey");

NotegroupHandler.createNoteGroup(groupCodeName,username,privateKey);
%>