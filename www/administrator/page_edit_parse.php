<?php
// You may want to obtain refering site name that this post came from for security purposes here
// exit the script if it is not from your site and script
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pid = $_POST['pid'];
$pagetitle = $_POST['pagetitle'];
$linklabel = $_POST['linklabel'];
$pagebody = $_POST['pagebody'];
// Filter Function -------------------------------------------------------------------
/*function filterFunction ($var) { 
    $var = nl2br(htmlspecialchars($var));
    $var = eregi_replace("'", "&#39;", $var);
    $var = eregi_replace("`", "&#39;", $var);		
    return $var; 
} */
function filterFunction ($var) { 
    //$var = preg_replace("/(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)/i", "<a href="\\1">\\1</a>", $var);
	$var = nl2br(htmlspecialchars($var));
    $var = preg_replace("/'/i", "&#39;", $var);
    $var = preg_replace("/`/i", "&#39;", $var);
	
    return $var; 
} 
$pagetitle = filterFunction($pagetitle);
$linklabel = filterFunction($linklabel);
$pagebody = filterFunction($pagebody);
// End Filter Function --------------------------------------------------------------
include_once "../Scripts/connect_to_mysql.php";
// Add the updated info into the database table
mysql_query("UPDATE pages SET pagetitle='$pagetitle', linklabel='$linklabel', pagebody='$pagebody', lastmodified=now() WHERE id='$pid'") or die (mysql_error($myConnection));

echo 'Operation Completed Successfully! <br /><br /><a href="index.php">Click Here</a>';
exit();
?>