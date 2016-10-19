<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

$conn = mysqli_connect("localhost", "root", "asterisk", "asterisk");

$result = mysqli_query($conn,"SELECT id,channel_map,extension_map,did,status_map from emp_map where did!='' order by channel_map asc");


$outp = "";
while($rs = mysqli_fetch_array($result)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"sno":"'  . $rs["channel_map"] . '",';
    $outp .= '"name":"'   .$rs["extension_map"]        . '",';
    $outp .= '"id":"'   .$rs["id"]        . '",';
    $outp .= '"status":"'   .$rs["status_map"]        . '",';
    $outp .= '"course":"'. $rs["did"]     . '"}'; 
}
$outp ='{"records":['.$outp.']}';
$conn->close();

echo($outp);
mysqli_close();
?>