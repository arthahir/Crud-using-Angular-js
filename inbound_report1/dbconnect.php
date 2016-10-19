<?php
//CONFIGURATION SECTION STARTS ///

error_reporting(0);
$servername='localhost' ;  // Replace this 'localhost' with your server name 
$database_username='root'; // Replace this  with your username 
$database_password='asterisk';  // Replace this  with your password
$database_name='asterisk';  // Replace this 'db' with your database name
// CONFIGURATION SECTION ENDS ////

$dblink=mysql_connect($servername,$database_username,$database_password);
mysql_select_db($database_name);

?>