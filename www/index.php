<?php
ob_start("ob_gzhandler");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="google-site-verification" content="QA7i_NnMfqGGl0oZcMmeP9dA_I-Bxj2pyoVuceMX324" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link href="style/sidemenustyle.css" rel="stylesheet" type="text/css" />
	
<!-- Server Side Code START -->
<?php
@session_start();
require_once "Scripts/connect_to_mysql.php";

//Determine which page ID to use in our query below ----------------------------------------------------
//$pidCheck=isset($_GET['pid'])?1:0;
//if(!$pidCheck){
if(!isset($_GET['pid'])){
	//First Allowed Page ----------------------------------------------------
	$sqlCommand="SELECT id FROM pages WHERE showing='1' ORDER BY pageorder ASC LIMIT 1";
	$query= mysql_query($sqlCommand) or die (mysql_error());
	while ($row=mysql_fetch_array($query)){
			$pageid=$row["id"];
	}
	mysql_free_result($query);
	//---------------------------------------------------------------------
}else{
	//$pageid=$_GET['pid'];
	//$pageid=ereg_replace("[^0-9a-zA-Z]","",$_GET['pid']);
	// the above not work in latest php 5... -> ereg_replace("[^0-9]","",$_GET['pid']); // only numbers for security
	// $pageid=preg_replace("[^0-9]","",$_GET['pid']);
	// $pageid=preg_replace("[^0-9]","",html_entity_decode($_GET['pid'], ENT_QUOTES));
	
	$quotes = array('\'', '"');
	
	$pageid=preg_replace("[^0-9]","",str_replace($quotes, '', $_GET['pid']));
	// echo $pageid;
}

//Query the body section for the proper page
$sqlCommand="SELECT pagebody, pagetitle FROM pages WHERE id='$pageid' AND showing='1' LIMIT 1";
$query= mysql_query($sqlCommand) or die (mysql_error());


if(mysql_num_rows($query)==0){
					
	$body="<br /><br /><br /><font color=\"#FF0000\" size=\"+1\"><b>You have reached a Wrong Place.<br /><br />Contact the Site Administrator if this looks a problem to you.</b></font><br /><br /><br />";
	$pagetitle="Page Not Found!";
}
else {
while ($row=mysql_fetch_array($query)){

	$body=$row["pagebody"];
	$pagetitle=$row["pagetitle"];
}
mysql_free_result($query);
}



//--------------------------------------------------------------------

//Query Module data for Display
$sqlCommand="SELECT id,modulebody FROM modules WHERE showing='1' AND name='footer' LIMIT 1";
$query= mysql_query($sqlCommand) or die (mysql_error());
while ($row=mysql_fetch_array($query)){
	$footer=$row["modulebody"];
}
mysql_free_result($query);
//--------------------------------------------------------------------

//Query Module data for Display
$sqlCommand="SELECT id,modulebody FROM modules WHERE showing='1' AND name='custom1' LIMIT 1";
$query= mysql_query($sqlCommand) or die (mysql_error());
while ($row=mysql_fetch_array($query)){
	$custom1=$row["modulebody"];
}
mysql_free_result($query);
//--------------------------------------------------------------------

//Side Menu ----------------------------------------------------
$sqlCommand="SELECT id,linklabel FROM pages WHERE showing='1' ORDER BY pageorder ASC";
$query= mysql_query($sqlCommand) or die (mysql_error());

//  $menuDisplay='';
$i=1;
$menuDisplay='
						<!-- link href="style/sidemenustyle.css" rel="stylesheet" type="text/css" / -->
						<div
							id="vertmenu">
								<ul>';
while ($row=mysql_fetch_array($query)){
	$pid=$row["id"];
	$linklabel=$row["linklabel"];
//	$menuDisplay.='<a href="index.php?pid=' . $pid . '">' . $linklabel . '</a><br />';
	$menuDisplay.='
									<li>
										<a href="index.php?pid=' . $pid . '" tabindex="' . $i . '" title="' . $linklabel . '">
												' . $linklabel . '
										</a>
									</li>';
	$i++;
}
$menuDisplay.='
								</ul>
						</div>
						';
mysql_free_result($query);
//---------------------------------------------------------------------

//mysql_close($myConnection);
mysql_close();
?>
<!-- Server Side Code END -->


	
    <title><?php echo $pagetitle; ?></title>
    
	<link rel="stylesheet" href="style/style.css" type="text/css" media="screen" />
	
</head>

<body>

	<div align="center" id="mainWrapper">
			
        <!-- Header Start -->
		<?php include_once("template_header.php"); ?>
        <!-- Header End -->
        
        <!-- Page Content Start -->
		<div id="pageContent">
			<table width="100%" border="0">
			<tr>
				<td width="20%" align="left" valign="top" bgcolor="#55f5a5"> <!-- #B0b0b0 -->
                	<div style="margin-left:5px;margin-top:5px;">

						<!-- Menu Start -->
						<?php echo $menuDisplay; ?>
                    	<!-- Menu End -->
                    
                    </div>
                </td>
				<td>
                	<div style="width:656px; height:100%; margin:5px; overflow:visible; text-align: justify;">
                    
                    	<!-- Body Start -->
						<?php echo $body; ?>
						<!-- Body End -->
                    
                    </div>
                </td>
			</tr>
			</table>
		</div>
        <!-- Page Content End -->
        
		<!-- Footer Start -->
        <?php include_once("template_footer.php"); ?>
        <!-- Footer End -->
            
	</div>

	<div align="center">
    	<a href="administrator">Admin</a>
    </div>
	 <p align="center">
    <a href="http://validator.w3.org/check?uri=referer"><img
      src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a>
  </p>
    
</body>

</html>