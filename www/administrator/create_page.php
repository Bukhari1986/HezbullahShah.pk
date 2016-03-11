<?php
session_start();
include_once "admin_check.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Creating New Page</title>
<script type="text/javascript">
function validate_form(){
	valid=true;
	if(document.form.pagetitle.value==""){
		alert("Please enter the page title.");
		valid=false;
	}else if (document.form.linklabel.value==""){
		alert("Please enter ifno for the link label.");
		valid=false;
	}else if(document.form.pagebody.value==""){
		alert("Please enter some info into the page body.");
		valid=false;
	}
	return valid;
}
</script>
<style type="text/css">
<!--
body{
	margin-left:0px;
	margin-top:0px;
	margin-right:0px;
}
-->
</style>
</head>

<body>
<table width="100%" border="0">
  <tr>
    <td><h3>Creating a New Page&nbsp;&nbsp;&bull;&nbsp;&nbsp; <a href="index.php">Admin Home</a> &nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="../" target="_blank">View Live Website</a></h3></td>
  </tr>
  <tr>
    <td>Be sure to fill in all fields, they are all required</td>
  </tr>
  <tr>
    <td>
    
    <table width="100%" border="0" cellpadding="5">
    <form id="form" name="form" method="post" action="page_new_parse.php" onsubmit="return validate_form();">
      <tr bgcolor="#F5E4A9">
        <td width="30%" align="right">Page Full Title</td>
        <td width="70%"><input name="pagetitle" type="text" id="pagetitle" size="80" maxlength="64" value="" /></td>
      </tr>
      <tr bgcolor="#D7EECC">
        <td align="right">Link Label</td>
        <td><input name="linklabel" type="text" id="linklabel" maxlength="24" value="" /> (What the link to this page will display as)</td>
      </tr>
      <tr bgcolor="#DAFAFA">
        <td align="right">Page Body</td>
        <td><textarea name="pagebody" id="pagebody" cols="88" rows="16" value="" > </textarea></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td><input type="submit" name="button" id="button" value="Create this page now"/></td>
      </tr>
	  </form>
    </table>
    
    </td>
  </tr>
</table>
</body>
</html>