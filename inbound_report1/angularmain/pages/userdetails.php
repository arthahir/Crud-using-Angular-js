<?php
$data = json_decode(file_get_contents("php://input"));
$team=$data->team;
$fromdate = $data->fromdate;

include_once ("/var/www/html/ami/selectsipassisted.php");
include_once ("pandbconnect.php");
print_r($con);
$extension=$sipphone[$team];
foreach ($extension as $data)
{
$myextension=$data;
$sipextension.= "'".$myextension."',";
}
$sipstatus=rtrim($sipextension,",");
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//$conn = mysql_connect("localhost", "root", "asterisk", "asterisk");

	if($fromdate !='' && $sipstatus!='')
	{
	$result = mysql_query($con,"SELECT count(1) as answered from answer_inbound where date(createddate)='$fromdate' and agent in ($sipstatus) ");
	}
	else
	{	
	$result = mysql_query($con,"SELECT queue_exten,count(1) as answered from answer_inbound group by queue_exten ");	
	}
$outp = "";
//$row=mysqli_affected_rows($conn); 


while($rs = mysql_fetch_assoc($result)) {
	//print_r($rs);
    if ($outp != "") {$outp .= ",";}
	$outp .= '{"answered":"'.$rs["answered"].'",';
	$outp .= '"queue_exten":"'.$rs["queue_exten"].'"}';


}
//print_r($answer);

 $result1 = mysql_query($con,"SELECT queue_exten,count(1) as missed from missedcall_inbound group by queue_exten");	
while($rs1 = mysql_fetch_assoc($result1)) {
//print_r($rs);
   if ($outp1 != "") {$outp1 .= ",";}
	$outp1 .= '{"missed":"'.$rs1["missed"].'",';
	$outp1 .= '"queue_exten":"'.$rs1["queue_exten"].'"}';
}  
	
	
$outp ='{"records1":['.$outp.']}';
$outp1 ='{"records2":['.$outp1.']}';
$answer=json_decode($outp,true);
$missed=json_decode($outp1,true);

print_r($answer['records1']);
print_r($missed['records2']);
foreach($answer['records1'] as $myanswer)
{
	foreach($missed['records2'] as $mymissed)
	{
		
		if($mymissed['queue_exten']==$myanswer['queue_exten'])
		{
		 if ($finalarray != "") {$finalarray .= ",";}
		$finalarray .='{"count":"'.$myanswer["queue_exten"].'",';
		$finalarray .= '"answer":"'.$myanswer["answered"].'",';		
		$finalarray .= '"missed":"'.$mymissed["missed"].'"}';		
		}
		else if($mymissed['queue_exten']!=$myanswer['queue_exten'])
		{
		echo $mymissed['queue_exten'];
		 if ($finalarray1 != "") {$finalarray1 .= ",";}
		 $finalarray1 .='{"count":"'.$mymissed["queue_exten"].'",';
		$finalarray1 .= '"missed":"'.$mymissed["missed"].'",';		
		$finalarray1 .= '"answer":"'.'0'.'"}';		 
		}
		/* elseif(!in_array($mymissed['queue_exten'],$myanswer))
		{
		$finalarray2 .='{"count":"'.$mymissed["queue_exten"].'",';
		$finalarray2 .= '"answer":"'.'0'.'",';		
		$finalarray2 .= '"missed":"'.$mymissed["missed"].'"}';		
		}  */
		
		
	}
	
	
}
print_r($finalarray);
	echo "////////////////////////////";
	print_r($finalarray1);
	echo "**************************";
	print_r($finalarray2);


//echo($outp);

mysql_close();
?>