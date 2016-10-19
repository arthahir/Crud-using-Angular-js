<?php 
include_once("../config.php");
$data = json_decode(file_get_contents("php://input"));

$connectids=$data->connectid;
$connection=$Ipaddress[$connectids];
$con = mysql_connect("localhost","root","asterisk","asterisk");
//mysql_select_db("asterisk");

mysql_close();


//print_r($con);
?>