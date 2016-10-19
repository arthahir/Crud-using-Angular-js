<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = mysqli_connect("localhost", "root", "asterisk", "asterisk");

$result = mysqli_query($conn,"SELECT membername,penalty,paused,time from queue_member_table where date(time)=curdate() ");


$outp = "";


while($rs = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
	if($rs["penalty"]==2){
	$live='Available';
	}else
	{
	$live='Incall';
	}
	
	if($rs["paused"]==1){
	$liveit='Paused';
	}else
	{
	$liveit='Not Paused';
	}
	
	
    $outp .= '{"agent":"'  . $rs["membername"]. '",';
    $outp .= '"penalty":"'   .$live        . '",';
    $outp .= '"paused":"'   .$liveit  . '",';
    $outp .= '"time":"'. $rs["time"]     . '"}'; 
}

$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
mysqli_close();
?>