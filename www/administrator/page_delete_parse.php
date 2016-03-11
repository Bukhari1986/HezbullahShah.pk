<?php
// You may want to obtain refering site name that this post came from for security purposes here
// exit the script if it is not from your site and script
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$pid = $_POST['pid'];
// End Filter Function --------------------------------------------------------------
include_once "../Scripts/connect_to_mysql.php";
// Add the updated info into the database table
mysql_query("DELETE FROM pages WHERE id='$pid'") or die (mysql_error($myConnection));

echo 'Page has been deleted successfully. <br /><br /><a href="index.php">Click Here</a>';
exit();
?>