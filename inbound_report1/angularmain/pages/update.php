<?php 
$data = json_decode(file_get_contents("php://input"));
$sno = $data->sno;
$name = $data->name;
$course = $data->course;
$id=$data->id;
$check=$data->check;
$con = mysql_connect("localhost","root","asterisk");
mysql_select_db("asterisk");
if($check=='1')
{
echo $sql = "update emp_map set status_map='1',update_date=now() where id=$id";
}
elseif($check=='0')
{
echo $sql = "update emp_map set status_map='0',update_date=now() where id=$id";
}
else{
$sql = "update emp_map set did='$course',update_date=now() where id=$id";
}
$result = mysql_query($sql);
mysql_close();
?>