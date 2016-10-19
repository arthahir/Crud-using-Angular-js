<?php
session_start();
include "functions.php";
if(isset($_POST) && !empty($_POST)){
	include_once("dbconnect.php");
	$login = $_POST['login'];
	$passwd = $_POST['passwd'];
	$user = stripslashes($login); 
	$passwd = stripslashes($passwd);

	 $check = mysql_query("SELECT * FROM new_auth WHERE uname='$user' and pwd='$passwd' and rights='10'");
	 $login_check=mysql_num_rows($check);
		if($login_check >= 1)
		{
				$dir = "/var/www/html/inbound_report/download";
				recursiveRemoveDirectory($dir);

				$date = date('Y-m-d H:i:s');
				$timestamp = strtotime($date);
				$timestamp.=".".rand(00,100);
				$_SESSION['sessionId'] = $timestamp;
				//$_SESSION[''] = 'none';
				$_SESSION['username'] = $login;
				/*COOKIE*/
				setcookie("username",$login, time()+7200, "/");
				header("Location:reportlog.php");
		}
		else
		{
			valueNotFound();
			exit;
		}
		$logged_in =  checklogin();
		$rak=$_GET['aa'];
		$esh="logout";
	   if($rak==$esh )
	   {   
		 $sessionid= $_SESSION['sessionId'];
		 logout();
	   }
}else{	
	
	logout();
}


 ?>
