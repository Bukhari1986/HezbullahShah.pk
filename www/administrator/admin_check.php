<?php
// ini_set('display_errors', 'On');
// ini_set('session.save_handler', 'files');
// ini_set('session.use_cookies', 1);
// error_reporting(E_ALL | E_STRICT);  // can omit | E_STRICT   -- this is used for checking standards e.g. the use of deprecated functions.

$error_msg="";
$admin="yourUsername";
$adminpass="YourPassword";

$usernamePostCheck=isset($_POST['username'])?1:0;
if($usernamePostCheck){
	$username=$_POST['username'];
	$password=$_POST['password'];
	//Simple hard coded values for the correct username and password
/*	$admin="theadmin";
	$adminpass="thepass";*/
	//Connect to mysql here if you store admin username and password in your database
	//This would be the prefered method of storing the values instead of hard coding them tere into the script
	if(($username!=$admin)&&($password!= $adminpass)){
		$error_msg='<br /><font color="#FF0000"> Your login information is incorrect </font>';
	}elseif(($username==$admin)&&($password== $adminpass)){
		//session_register('admin'); // -- deprecated now. :(
		session_start();
		$_SESSION['admin']=$username;
		//require_once"index.php";
		header('Location: index.php');
		exit();
	}

}//close if post username

//$AdminSessionCheck=isset($HTTP_SESSION_VARS['admin'])?1:0;  // or 
$AdminSessionCheck=isset($_SESSION['admin'])?1:0;

$SessionRealAdminCheck=0;

if($AdminSessionCheck) {
	$SessionRealAdminCheck=($_SESSION['admin']==$admin)?1:0;  //changed from the static value to the dynamic variable.
//$SessionRealAdminCheck=(strcmp($_SESSION['admin'],"theadmin")==0)?1:0;

	}
//if(((isset($_SESSION['admin']))&&($_SESSION['admin']!="theadmin"))||(!isset($_SESSION['admin']))) { // This performs like the just below if manually.
if($SessionRealAdminCheck==0||$AdminSessionCheck==0) { // -- This performs same as the above if, but using the prechecked conditions :)
//if ($_SESSION['admin']!="theadmin"){   // -- the first time this check was implemented.
	echo '<h3> Only the administrator can view this direcotory </h3><br />
	<table width="350" border="0">
<form action="admin_check.php" method="post" target="_self">
  <tr>
    <td colspan="2">Please Log in Here ' . $error_msg . '</td>
  </tr>
  <tr>
    <td width="83">Username</td>
    <td width="257">
      <input type="text" name="username" id="username" style="width:98%" /></td>
  </tr>
  <tr>
    <td>Passowrd</td>
    <td><input type="password" name="password" id="password" style="width:98%" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center"><input type="submit" name="button" id="button" value="Log In Now"></td>
  </tr>
  </form>
</table>

<br /><br /><br />
	 <a href="../">OR Click here to head back to the homepage</a>';
	exit();
}
?>