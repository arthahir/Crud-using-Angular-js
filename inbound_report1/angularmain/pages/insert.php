<?php 

// $data=$_REQUEST;
 //print_r($data);
$data = json_decode(file_get_contents("php://input",true));
//print_r($data);

$sno = $data->sno;
$name = $data->name;

$course = $data->course;
$con = mysql_connect("localhost","root","asterisk");
mysql_select_db("asterisk");
$date=date("Y-m-d H:i:s");
$existingcheck="select id,did from emp_map where did='$course'";
$data1=mysql_query($existingcheck,$con);

$rows=mysql_num_rows($data1);
if($rows=='0')
{
//$sql = "insert into students(sno,name,course) values('$sno','$name','$course')";
$sql = "insert into emp_map(channel_map,extension_map,did,created_date,added_by,status_map) values('$sno','$name','$course','$date','System','1')";

$result = mysql_query($sql,$con);
$condition="Successfully inserted";
echo($condition);
}
else
{
$condition="DID Already Exists";
echo($condition);
}
mysql_close();
?>