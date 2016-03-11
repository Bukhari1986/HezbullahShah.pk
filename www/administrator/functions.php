<?php

		//Last ordered Page in the database ----------------------------------------------------
	$sqlCommand="SELECT pageorder FROM pages ORDER BY pageorder DESC LIMIT 1";
	$query= mysql_query($sqlCommand) or die (mysql_error());
	while ($row=mysql_fetch_array($query)){
			$pageorder=$row["pageorder"]+1;
	}
	mysql_free_result($query);
	//---------------------------------------------------------------------

?>