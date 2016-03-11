<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Arrange Final</title>
<?php
$shownow="";
if (isset($_POST["checbx"])){
	$shownow= "Selected " . $_POST["checbx"] . " .";
}
	else{
		 $shownow= "Nothing";
}
?>
</head>

<body>
<?php echo $shownow; ?>
<form action="arrange_parse.php" method="post">
<input type="checkbox" name="'checbx" id="checbx" value="123" />
<input type="submit" value="ok" />
</form>

</body>
</html>