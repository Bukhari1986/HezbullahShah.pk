<?php
// exit the script if it is not from your site and script
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pagetitle = $_POST['pagetitle'];
$linklabel = $_POST['linklabel'];
$pagebody = $_POST['pagebody'];
// Filter Function -------------------------------------------------------------------
function filterFunction ($var) { 
    $var = nl2br(htmlspecialchars($var));
    //$var = eregi_replace("'", "&#39;", $var);
    //$var = eregi_replace("`", "&#39;", $var);
	$var = preg_replace("/'/i", "&#39;", $var);
    $var = preg_replace("/`/i", "&#39;", $var);
    return $var; 
} 
$pagetitle = filterFunction($pagetitle);
$linklabel = filterFunction($linklabel);
$pagebody = filterFunction($pagebody);
// End Filter Function --------------------------------------------------------------
include_once "../Scripts/connect_to_mysql.php";
// Add the info into the database table
		//Last ordered Page in the database ----------------------------------------------------
	$sqlCommand="SELECT pageorder FROM pages ORDER BY pageorder DESC LIMIT 1";
	$query= mysql_query($sqlCommand) or die (mysql_error());
	while ($row=mysql_fetch_array($query)){
			$lastpage=$row["pageorder"];
	}
	$pageorder=$lastpage+1;
	mysql_free_result($query);
	//---------------------------------------------------------------------
	
mysql_query("INSERT INTO pages (pagetitle, linklabel, pagebody, pageorder, lastmodified) 
        VALUES('$pagetitle','$linklabel','$pagebody', '$pageorder', now())") or die (mysql_error());

echo 'Operation Completed Successfully!<br /><font color="#FF0000">DO NOT REFRESH</font><br /><br /><a href="index.php">Click Here</a>';
exit();
?>