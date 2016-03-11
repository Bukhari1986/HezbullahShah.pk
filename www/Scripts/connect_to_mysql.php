<?php 
$db_host="your db host";
$db_username="your db username";
$db_pass="your db pass";
$db_name="your db name";

mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to my sql");
mysql_select_db("$db_name") or die("could not select database");
?>