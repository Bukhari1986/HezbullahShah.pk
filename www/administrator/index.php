<?php
	// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
// ini_set('display_errors', 'On');
// ini_set('session.save_handler', 'files');
// ini_set('session.use_cookies', 1);
@session_start();
//session_save_path(“/tmp”); session_start();
include_once "admin_check.php";
?>
<?php
// exit the script if it is not from your site and script
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
$pagetitle = $_POST['pagetitle'];
$linklabel = $_POST['linklabel'];
$pagebody = $_POST['pagebody'];
// Filter Function -------------------------------------------------------------------
function filterFunction ($var) { 
    $var = nl2br(htmlspecialchars($var));
    $var = eregi_replace("'", "&#39;", $var);
    $var = eregi_replace("`", "&#39;", $var);
    return $var; 
} 
$pagetitle = filterFunction($pagetitle);
$linklabel = filterFunction($linklabel);
$pagebody = filterFunction($pagebody);
// End Filter Function --------------------------------------------------------------
*/
include_once "../Scripts/connect_to_mysql.php";

$MainAdminPage="index.php";
$SiteAdmin="Hezbullah Shah";
$SiteAdminEmail="Bukhari1986@gmail.com";
$SiteAdminPhone="00971 50 2023270";

$sortBy='pageorder';
$sortDirection='ASC';

if(isset($_REQUEST['action'])){
	if(isset($_REQUEST['id'])){
		$action=$_REQUEST['action'];
		$pid = intval($_REQUEST['id']);
		switch($action)
		{	
			// Deleting the record
			case "del":
				mysql_query("DELETE FROM pages WHERE id=$pid") or die (mysql_error());
				header('Location:'.$MainAdminPage);
				break;
				
			//Showing or hiding the record
			case "Show":
				mysql_query("UPDATE pages SET showing='1', lastmodified=now() WHERE id='$pid'") or die (mysql_error());
				header('Location:'.$MainAdminPage);
				break;
				
			case "Hide":
				mysql_query("UPDATE pages SET showing='0', lastmodified=now() WHERE id='$pid'") or die (mysql_error());
				header('Location:'.$MainAdminPage);
				break;
			
			case "UP":
				$pageorder=intval($_REQUEST['pageorder']);
				$Cpageorder=$pageorder-1;
				$pid=intval($_REQUEST['id']);
				$query=mysql_query("SELECT id FROM pages WHERE pageorder='$Cpageorder'");
				while($row=mysql_fetch_array($query))
					$Cpid=intval($row['id']);
				mysql_query("UPDATE pages SET pageorder='$pageorder', lastmodified=now() WHERE id='$Cpid'") or die (mysql_error());
				mysql_query("UPDATE pages SET pageorder='$Cpageorder', lastmodified=now() WHERE id='$pid'") or die (mysql_error());
				header('Location:'.$MainAdminPage);
				break;
			
			case "DOWN":
				$pageorder=intval($_REQUEST['pageorder']);
				$Cpageorder=$pageorder+1;
				$pid=intval($_REQUEST['id']);
				$query=mysql_query("SELECT id FROM pages WHERE pageorder='$Cpageorder'");
				while($row=mysql_fetch_array($query))
					$Cpid=intval($row['id']);
				mysql_query("UPDATE pages SET pageorder='$pageorder', lastmodified=now() WHERE id='$Cpid'") or die (mysql_error());
				mysql_query("UPDATE pages SET pageorder='$Cpageorder', lastmodified=now() WHERE id='$pid'") or die (mysql_error());
				header('Location:'.$MainAdminPage);
				break;
			case "LoGoUt":
				if($pid==1)
					session_destroy();
				header('Location:'.$MainAdminPage);
			default:
				echo "Error Occurred: <br /> <br />Contact Site Administrator: <br /> $SiteAdmin <br />at <br />$SiteAdminEmail <br />OR<br />$SiteAdminPhone<br />You will will be redirected soon";
				header('Location:'.$MainAdminPage);
				exit();
		}
	} else {
		echo "Error Occurred: <br /> <br />Contact Site Administrator: <br /> $SiteAdmin <br />at <br />$SiteAdminEmail <br />OR<br />$SiteAdminPhone<br />You will will be redirected soon";
			header('Location:'.$MainAdminPage);
		exit();
	}
}
else if(isset($_REQUEST['cmd'])){
	$cmd=preg_replace('#[^a-z]#','',$_REQUEST['cmd']);
	$dieMsg = 'Something is Wrong. Probably the URL is modified Manually.';
	switch($cmd){
		/*	START - Sorting	*/
		case 'sort':
			if(isset($_REQUEST['val'])){
				$val=preg_replace('#[^A-Za-z]#','',$_REQUEST['val']);
				switch($val){
					case 'id':
					case 'pagetitle':
					case 'pageorder':
					case 'showing':
					case 'lastmodified':
						$val = mysql_real_escape_string(htmlentities(htmlspecialchars(nl2br($val),ENT_QUOTES),ENT_QUOTES));
						$sortBy=$val;
						if(isset($_REQUEST['dir'])){
							$dir=preg_replace('#[^A-Z]#','',$_REQUEST['dir']);
							switch($dir){
								case 'DESC':	// $dir not escaped as it is not used anywhere. only used for cases match.
									$sortDirection='DESC';
									break;
								case 'ASC':
									//$sortDirection='ASC'; //leave ASC as default. Already initialized above. so here commented.
									break;
								default:
									///die($dieMsg);			// Do Nothing Extra!
									break;
							}
						}
						break;
					default:
						die($dieMsg);
						break;
				}
			}
			break;
		default:
			die($dieMsg);
			break;
	}
}

//Last ordered Page in the database----------------------------------------------------
	$sqlCommand="SELECT pageorder FROM pages ORDER BY pageorder DESC LIMIT 1";
	$lastpageq= mysql_query($sqlCommand) or die (mysql_error());
	while ($row=mysql_fetch_array($lastpageq)){
			$lastpage=$row["pageorder"];
	}
	mysql_free_result($lastpageq);
	
//---------------------------------------------------------------------
				
				
// select the info from the database table to Display on the Control Panel Page
$sqlCommand = "SELECT id, pagetitle, linklabel, pageorder, showing, lastmodified FROM pages ORDER BY $sortBy $sortDirection";
$query = mysql_query($sqlCommand) or die (mysql_error());
$sortDirection = ($sortDirection=='ASC')?'DESC':'ASC'; // set user friendly value for Link Variables

$arrange_display = '';
while ($row=mysql_fetch_array($query)){

$pid=$row["id"];
$pagetitle=$row["pagetitle"];
$linklabel=$row["linklabel"];
$pageorder=$row["pageorder"];
$showing=$row["showing"];
$lastmodified=$row["lastmodified"];

$ShowHide='';
if($showing=='1'){ $ShowHide='Hide';}  else {$ShowHide='Show';}

//set the ordering links - start
$ChOrder='';
if($pageorder=='1')
	$ChOrder= "<a href=\"$MainAdminPage?action=DOWN&amp;id=$pid&amp;pageorder=$pageorder\">DOWN</a>";
elseif ($pageorder==$lastpage)
	$ChOrder="<a href=\"$MainAdminPage?action=UP&amp;id=$pid&amp;pageorder=$pageorder\">UP</a>";
else
	$ChOrder= "<a href=\"$MainAdminPage?action=UP&amp;id=$pid&amp;pageorder=$pageorder\">UP</a><br /><a href=\"$MainAdminPage?action=DOWN&amp;id=$pid&amp;pageorder=$pageorder\">DOWN</a>";
//set the ordering links - end

$arrange_display.='
  <tr title="' . $linklabel . '">
	<td align="center">' . $pid. '</td>
    <td>
	<!-- a href=$MainAdminPage?action=Edit&amp;id='.$pid . $pagetitle . ' title="Click to Edit">' . $pagetitle . '</a -->
	<a href="edit_page.php?id='. $pid .'" title="Click to Edit">' . $pagetitle . '</a>
	</td>
    <td align="center">' . $pageorder . '</td>
	<td align="center">' . $ChOrder . '</td>
    <td align="center">
	<a href="'.$MainAdminPage.'?action=' . $ShowHide . '&amp;id=' . $pid . '">' . $ShowHide . ' Me</a>
	</td>
	<td align="center">
	<a href="'.$MainAdminPage.'?action=del&amp;id=' . $pid . '" onclick="return confirm(\'Are you Sure You Want to Delete this Link and its contents ?\');">DELETE</a>
	</td>
    <td>' . $lastmodified . '</td>
  </tr>';
}
mysql_free_result($query);
//---------------------------------------------------------------------
//mysql_close($myConnection);
mysql_close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Control Panel</title>
</head>

<body>

<?php 
//var_dump($_SESSION);  // to show the values of array $_SESSION
echo "Welcome <b>" . $_SESSION['admin'] . "</b>.<br /><br />" ?>
<table width="100%" border="1" cellpadding="3">
<tr><td colspan="7" align="right" valign="middle" bgcolor="#DAF2FE">
	<h3>
	&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="create_page.php">Create New Page</a>
	&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="../">View Live Website</a>
	&nbsp;&nbsp;&bull;&nbsp;&nbsp;<a href="<?php echo $MainAdminPage; ?>?action=LoGoUt&amp;id=1">Log Out</a>&nbsp;&nbsp;&bull;&nbsp;&nbsp;</h3></td></tr>
<tr bgcolor="#009966">
<th colspan="7">Arranging the Display</th>
</tr>
  <tr align="center" valign="middle">
    <th><a href="<?php echo $MainAdminPage; ?>?cmd=sort&amp;val=id&amp;dir=<?php echo $sortDirection; ?>">ID</a></th>
    <th><a href="<?php echo $MainAdminPage; ?>?cmd=sort&amp;val=pagetitle&amp;dir=<?php echo $sortDirection; ?>">pagetitle</a></th>
    <th><a href="<?php echo $MainAdminPage; ?>?cmd=sort&amp;val=pageorder&amp;dir=<?php echo $sortDirection; ?>">order</a></th>
    <th>ChangeOrder</th>
    <th><a href="<?php echo $MainAdminPage; ?>?cmd=sort&amp;val=showing&amp;dir=<?php echo $sortDirection; ?>">showing</a></th>
    <th>Delete</th>
    <th><a href="<?php echo $MainAdminPage; ?>?cmd=sort&amp;val=lastmodified&amp;dir=<?php echo $sortDirection; ?>">Last modified on </a></th>
  </tr>
  <tr>
  <?php 
  echo $arrange_display;
  ?>
</table>

</body>
</html>