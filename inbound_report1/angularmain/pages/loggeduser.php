<?php
$data = json_decode(file_get_contents("php://input"));
$team=$data->team;
$fromdate = $data->fromdate;

include_once ("/var/www/html/ami/selectsipassisted.php");
$extension=$sipphone[$team];
foreach ($extension as $data)
{
$myextension=$data;
$sipextension.= "'".$myextension."',";
}
$sipstatus=rtrim($sipextension,",");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$conn = mysqli_connect("localhost", "root", "asterisk", "asterisk");

	if($fromdate !='' && $sipstatus!='')
	{
	$result = mysqli_query($conn,"SELECT agent,login,logout,status from logindetail where date(login)='$fromdate' and agent in ($sipstatus) ");
	}
	else
	{	
	$result = mysqli_query($conn,"SELECT agent,login,logout,status from logindetail where date(login)='2016-07-26' ");	
	}
$outp = "";
$row=mysqli_affected_rows($conn);
if($row==0)
{ 
	$outp .= '{"agent":"'  .''. '",';
	$outp .= '"login":"'   .''. '",';
	$outp .= '"logout":"'  .''. '",';
	$outp .= '"duration":"'.''. '",';
	$outp .= '"status":"'  .''. '"}';
	$outp ='{"records1":['.$outp.']}';
}
else{ 
while($rs = mysqli_fetch_assoc($result)) {
	//print_r($rs);
    if ($outp != "") {$outp .= ",";}
	
	$outp .= '{"agent":"'.$rs["agent"].'",';
	$outp .= '"login":"' .$rs["login"].'",';
	$outp .= '"logout":"'.$rs["logout"].'",';
	if($rs["logout"]!='0000-00-00 00:00:00')
	{
	$duration=caldur_at($rs["login"],$rs["logout"]);
	}
	if($rs["logout"]=='0000-00-00 00:00:00')
	{
	$duration='00:00:00';
	}
	$outp .= '"duration":"'.$duration. '",';
	$outp .= '"status":"'.$rs["status"].'"}';
}
$outp ='{"records1":['.$outp.']}';

}
$conn->close();
function caldur_at($starttime,$endtime){
		$fromdate = $starttime;
		$todate = $endtime;
		$duration = strtotime($todate) - strtotime($fromdate);
		$duration_calc = gmdate("H:i:s",$duration);
		return $duration_calc;
	}
echo($outp);
mysqli_close();
?>