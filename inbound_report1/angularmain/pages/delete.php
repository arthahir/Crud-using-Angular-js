<?php 
$data = json_decode(file_get_contents("php://input"));
$id = $data->sno;
$con = mysql_connect("localhost","root","asterisk");
mysql_select_db("asterisk");
$sql = "delete from emp_map where id=$id";
$result = mysql_query($sql,$con);
mysql_close();
?>