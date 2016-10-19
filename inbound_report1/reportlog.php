<?php

session_start();
//require_once("sess.php");
include "functions.php";
include_once("dbconnect.php");
if(empty($_COOKIE['username'])){
	logout();
}else{
	$uname= $_COOKIE['username'];
}
$channeldata =array("1"=>"Fresh","6"=>"RRT","14"=>"CBS");
$listdata = array("1"=>"Missed call","2"=>"Answered Call","3"=>"Summary","4"=>"Login Detail");
$list='';
$down_label = 'display:none';
?>
<html> 
<head>
<link rel="stylesheet" href="css/style.css">
	<!-- <link rel="stylesheet" href="css/skeleton.css"
	<link rel="stylesheet" href="css/layout.css">
	<link rel="stylesheet" href="css/style.css">> -->
<!-- <link href="style/style.css" rel="stylesheet" type="text/css" media="all" /> -->
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>	
<script type="text/javascript" src="js/script.js"></script>	
<title> Inbound - <?php echo $uname?></title>
<style>
select,
input[type="text"]
{
	display:inline-block;
}
input[type="text"]
{
margin-left:60px;
width:220px;	
}
.display
{
	display:table !important;
}
.dataofajax
{
	width:100%;
	min-height:20px;
	display:table;
}
.ser
{
	border-radius: 5px;
    background: #3f556a;
    border: none;
    color: #ffffff !important;
    font-family: 'Open Sans', sans-serif;
    font-size: 16px;
    font-weight: 400;
    padding: 7px 23px 7px 23px;
	margin:0px auto;
	display:block;
	width:66px;
	text-decoration:none;
}
.search
{
	margin-left:291px;
}
.ser:hover
{
	background:#1b5388;
	color:#ffffff;
}
</style>
<script>
$(document).ready(function(){
	/* $(".ser").click(function(){
		$.ajax({
			url : "post.php",
			type : "POST",
			data : {
				address : "http://192.168.10.40/inbound_report1/crud/disp.php"
			},
			success : function(result){
				$(".dataofajax").html(result);
			}
		});
		return false;
	}); */
});
</script>
</head>
<body background="">
<div class="wrapper">
<div id="container">
<div class="header">
<div class="innerheader">
<div id="logout">
<table align="right"><tr>
<p class="oblique"><img src="images/logo.gif"/><b><span>INBOUND-REPORT</b>
<td><input type="submit" name="tit" id="tit" value="welcome <?php echo $uname ?> " /></td></span>
</p>
<td><a href="reportlog.php"><input type="button" name="home" id="home" value="Home"   class="styled-button-9"  /></a></td>
<!--<td><input type="submit" name="tit" id="tit" value="Welcome <?php echo $uname ?> " class='styled-button-9' /></td>-->
<td><a href="angularmain/index.html#/liveuser" target="_parent"><input type="button" name="liveuser" id="liveuser" value="LiveUser"   class="styled-button-9"  /></a></td>
<td><a href="angularmain/index.html#/loggeduser" target="_parent"><input type="button" name="loggedinuser" id="loggedinuser" value="Logged Users"   class="styled-button-9"  /></a></td>
<td><input type="submit" name="QueueLogout" id="stop" value="Logout"  onclick="Stop()" class='styled-button-8'/></td>
</tr>
</table>
</div>
</div>
</div>
         <div id="content1" class="datatodisplaym">
		 
		 <div class="main">
		 <form method="post" class="report">
			<!--<label class="channelvalue"><p>Select Date</p></label>
			<input type="text" name='selectdate' id='sdate'/>-->
			<div class="formblkdata">
			<label class="datevalue"><p>Channel</p></label>
			<select name='channel' class='channel' id='selectchannel'>
			<option value=''>Select Channel</option>
			<?php
				foreach($channeldata as $key=>$value)
				{
					if($_REQUEST['channel']==$key) 
					{
						echo '<option value='.$_REQUEST['channel'].' selected>'.$value.'</option>';
					}
					else
					{
						
						echo '<option value='.$key.'>'.$value.'</option>';
					}
				}
			?>
				
				
			</select>
			</div>
			<div class="formblkdata">
			<label class="listvalue"><p>Select List</p></label>
			<select name='listdata' class='listdata' id="selectlist">
			<?php
				foreach($listdata as $key1=>$value1)
				{
					if($_REQUEST['listdata']==$key1)
					{
						echo '<option value='.$_REQUEST['listdata'].' selected>'.$value1.'</option>';
					}
					else
					{
						echo '<option value='.$key1.'>'.$value1.'</option>';
					}
				}
			?>
				
			</select>
			</div>
			<input type="hidden" name="page" value="1">
			<input type="submit" name="search" value="search" class="search" onclick = 'return Validation()'>
			</form>
			<?php if($_COOKIE['username'] =='admin' || $_COOKIE['username']=='ame')
				  {	
				  ?>
			<a href="angularmain/index.html#/display" target="_parent" class="add">Add DID</a>
			<a href="angularmain/index.html#/userdetail" target="_parent" class="add">Details</a>
			<?php } ?>
			<!--<form name="download_excel" method="post">
				
			</form>-->
			</div>
			</div>
			
        
		<div class="dataofajax">
		</div>
		<div id="toPopup"> 
    	
        <div class="close"></div>
		
		<div id="popcall" style="display:none;background-color:#ffffff;height:83px;text-align:center;">
		
		</div>
		 <!--your content start-->
		<!-- <div id="popup_content"> 
            <iframe src="" frameborder="0"  name="iframe_a" width="100%" height="900"></iframe>
            <p align="center"><a href="#" class="livebox">Click Here Trigger</a></p>
        </div>  -->
		<div id="popup_content"> </div>
		<!--your content end-->
    
    </div> <!--toPopup end-->
    
	<div class="loader"></div>
   	<div id="backgroundPopup"></div>
		
		
</div>



 <input type='hidden' name='uname' id='uname' value='<?php echo $uname;?>'>
<div id="popup1" class="popup"> 

</div>


<div id="bg" class="popup_bg"></div> 

 <?php

if(isset($_REQUEST['search']))
{
	$down_label = 'display:block';
	//$dateselected=$_REQUEST['selectdate'];
	//$date('Y-m-d 23:59:59');
	$enddate = date("Y-m-d H:i:s");
	$startdate = date("Y-m-d 00:00:00", strtotime('-10 days'));
	$todate = date("Y-m-d",strtotime('now'));
	$lastdate = date("Y-m-d",strtotime('-1 days'));
	$secdate = date("Y-m-d",strtotime('-2 days'));
	$threedate = date("Y-m-d",strtotime('-3 days'));
	$lastfourday_array = array($todate,$lastdate,$secdate,$threedate);
	$split4days = implode("','",$lastfourday_array);
	$enddate_format = date("Y-m-d");
	$startdate_format = date("Y-m-d", strtotime('-10 days'));
	
	
	$channel=$_REQUEST['channel'];
	$list=$_REQUEST['listdata'];
	$systemdate = "From_".$startdate_format."_TO_".$enddate_format;
	$datatowrite=array();
	if($list==1)
	{
		$fetch_report="select channel,from_did as extension,DATE_FORMAT(createddate,'%Y-%m-%d') as createdtime,startdate as Start_time,createddate as End_time,duration as Wait_time,queue_exten from missedcall_inbound where date(createddate) between '$startdate' and '$enddate' and channel='$channel' order by createddate desc";
	}else if($list==2){
		$fetch_report="select channel,from_did as extension,DATE_FORMAT(createddate,'%Y-%m-%d') as createdtime,startdate as Start_time,createddate as End_time,duration as Spoken_time,queue_exten from answer_inbound where channel='$channel' order by createddate desc";
	}else if($list==4){
		$fetch_login_report = "select agent,date(login),count(id) as count from logindetail where date(login) in ('".$split4days."') group by agent,date(login)";
	}
	else
	{
		$fetch_report_miss_summary = "select channel,queue_exten,createddate,count(id) as count from missedcall_inbound where date(createddate) in ('".$split4days."')  and status = '0' group by queue_exten,date(createddate)";
		$fetch_report_miss_matured_summary = "select channel,queue_exten,createddate,count(id) as count from missedcall_inbound where date(createddate) in ('".$split4days."') and  status = '1' group by queue_exten,date(createddate)";
		$fetch_report_ans_summary = "select channel,queue_exten,createddate,count(id) as count from answer_inbound where date(createddate) in ('".$split4days."') group by queue_exten,date(createddate)";
	}

	$get_data=mysql_query($fetch_report,$dblink);
	$get_login=mysql_query($fetch_login_report,$dblink);
	$get_miss_sum=mysql_query($fetch_report_miss_summary,$dblink);
	$get_missmatured_sum=mysql_query($fetch_report_miss_matured_summary,$dblink);
	$get_ans_sum=mysql_query($fetch_report_ans_summary,$dblink);

	$count_records=mysql_num_rows($get_data);
	$count_login=mysql_num_rows($get_login);
	$mis_records=mysql_num_rows($get_miss_sum);
	$mismatured_records=mysql_num_rows($get_missmatured_sum);
	$ans_records=mysql_num_rows($get_ans_sum);

	if($count_records > 0)
	{
		
		while($rows=mysql_fetch_array($get_data,MYSQL_NUM))
		{
			$extension_type = $rows[1];
			if(substr($extension_type,0,1) == 7){
				$rows[1] = "SIP Based Call";
			}elseif(substr($extension_type,0,1) == 3){
				$rows[1] = "PRI Based Call";
			}elseif(substr($extension_type,0,1) == 4){
				$rows[1] = "PRI Based Call";
			}elseif(substr($extension_type,0,1) == 6 && strlen($extension_type)==8){
				$rows[1] = "PRI Based Call";
			}elseif(substr($extension_type,0,1) == 6 && strlen($extension_type)==3){
				$rows[1] = "GSM Based Call";
			}else{
				$rows[1] = $extension_type;
			}
			$datatowrite[]=$rows;
		
		}

		$getcols=mysql_num_fields($get_data);
		$reportheadcount=0;
		$header["0"]="Location";
		while($reportheadcount < $getcols)
		{
			$header[]= mysql_field_name($get_data,$reportheadcount);
			$reportheadcount++;
		}

		$test = buildreport($list,$datatowrite,$channel,$systemdate,$header,$channeldata);
		
				//echo $test;
		
	}if($count_login > 0){
		while($row_log=mysql_fetch_array($get_login,MYSQL_NUM))
		{
			$datatowrite[] = $row_log;
		}
		$getcols=mysql_num_fields($get_login);
		$reportheadcount=0;

		$header["0"]="Location";
		while($reportheadcount < $getcols)
		{
			$header[]= mysql_field_name($get_login,$reportheadcount);
			$reportheadcount++;
		}
		$test = buildreport($list,$datatowrite,$channel,$systemdate,$header,$channeldata);
	}
	if($mis_records > 0 || $ans_records > 0 || $mismatured_records > 0){
		while($row_mis=mysql_fetch_array($get_miss_sum,MYSQL_NUM))
		{
			$datatowrite['miss_sum'][] = $row_mis;
		}
		while($row_mismat=mysql_fetch_array($get_missmatured_sum,MYSQL_NUM))
		{
			$datatowrite['miss_mat'][] = $row_mismat;
		}
		while($row_ans=mysql_fetch_array($get_ans_sum,MYSQL_NUM))
		{
			$datatowrite['ans_sum'][] = $row_ans;
		}
		$getcols_mis=mysql_num_fields($get_miss_sum);
		$getcols_ans=mysql_num_fields($get_ans_sum);
		$reportcount=0;
	
		while($reportcount < $getcols_ans)
		{
			$header[]= mysql_field_name($get_ans_sum,$reportcount);
			$reportcount++;
		}
		$test = buildreport($list,$datatowrite,$channel,$systemdate,$header,$channeldata);
		
	}
	
}

function buildreport($list,$datatowrite,$channel,$systemdate,$header,$channeldata)
{
	global $filename_download;
	global $required_list;
	if($list == 1)
	{
		$required_list="missedcall";
	}else if($list == 2){
		$required_list="answercall";
	}elseif($list == 4){
		$required_list="Login Details";
	}
	else
	{
		$required_list="Summary";
	}
	//$filename = "/var/www/html/inbound_report1/download/inbound_report_".$required_list."_".$systemdate.".xls";
	//$file = fopen($filename,"w") or die("Unable to open file!");
	//$ip_address = $_SERVER['HTTP_HOST'];
	$filename_download = "http://".$ip_address."/inbound_report1/download/inbound_report_".$required_list."_".$systemdate.".xls";
	foreach($datatowrite as $dkey=> $value)
	{
		if($list != 3){
		for($i=0;$i<count($value);$i++)
		{
			
			$eachrow["0"]="CBS Mumbai";
			
			if($i == 0)
			{
				$channel_value = $value[$i];
				foreach($channeldata as $keys => $values)
				{
					
					if($channel_value == $keys)
					{
						$eachrow[] = $values;
					}
				} 
				
			}
			else
			{ 
				$eachrow[]=$value[$i];
			}	
		}
		$eachrowtofile[]=implode(',',$eachrow);
		unset($eachrow);
		}else{
			if($dkey == 'miss_sum'){
				foreach($value as $val){
					for($i=0;$i<count($val);$i++)
					{
						$eachrow["0"]="Missed Call Summary";
						if($i == 0)
						{
							$channel_value = $val[$i];
							foreach($channeldata as $keys => $values)
							{
								
								if($channel_value == $keys)
								{
									$eachrow[] = $values;
								}
							} 
						}
						else
						{ 
							$eachrow[]=$val[$i];
						}
					}
					$eachrowtofile[]=implode(',',$eachrow);
					unset($eachrow);
				}
			}else if($dkey == 'miss_mat'){
				foreach($value as $val){
					for($i=0;$i<count($val);$i++)
					{
						$eachrow["0"]="Misssed Call Matured Summary";
						if($i == 0)
						{
							$channel_value = $val[$i];
							foreach($channeldata as $keys => $values)
							{
								
								if($channel_value == $keys)
								{
									$eachrow[] = $values;
								}
							} 
						}
						else
						{ 
							$eachrow[]=$val[$i];
						}
					}
					$eachrowtofile[]=implode(',',$eachrow);
					unset($eachrow);
				}
				
			}else if($dkey == 'ans_sum'){
				foreach($value as $val){
					for($i=0;$i<count($val);$i++)
					{
						$eachrow["0"]="Answer Call Summary";
						if($i == 0)
						{
							$channel_value = $val[$i];
							foreach($channeldata as $keys => $values)
							{
								
								if($channel_value == $keys)
								{
									$eachrow[] = $values;
								}
							} 
						}
						else
						{ 
							$eachrow[]=$val[$i];
						}
					}
					$eachrowtofile[]=implode(',',$eachrow);
					unset($eachrow);
				}
				
			}
		}
		
		

	}
	$xlscols = implode(',',$header);
	$headcols = array($xlscols);
						
						
							
	foreach ($headcols as $title)
	{
		fputcsv($file,explode(',',$title));
	} 
	$dataforeachrows = 0;
	foreach ($eachrowtofile as $dataforeachrows)
	{
		fputcsv($file,explode(',',$dataforeachrows));
		$dataforeachrows++;
	}
fclose($file);

}

if(!empty($datatowrite)){
?>
<div class="overalltable">
<div  class="datatodisplayn" style="<?php echo $down_label; ?>">
<table class="datan" width="80%" align="center" border="0" cellspacing="0" cellpadding="0">
	<?php if($_REQUEST['listdata']== 1 or $_REQUEST['listdata']== 2) {?>
	<tr><th colspan="7" style="border-bottom:1px solid #ffffff;border-right:1px solid #ffffff;"><h3><?php echo ucwords($required_list);?></h3></th><th align="center" style="border-bottom:1px solid #ffffff;"><u><a href="<?php echo $filename_download;?>" class="download" style="color:#bb120d">Download</a></u></th></tr>
	<?php
	}else{ ?>
	<tr><th colspan="4" style="border-bottom:1px solid #ffffff;"><h3><?php echo ucwords($required_list);?></h3></th></tr>
	<?php } ?>
	<tr>
	<?php
	$per_page=50;

		if (isset($_REQUEST["page"]))
		{

			$page = $_REQUEST["page"];

		}

		else 
		{

			$page=1;

		}

		$start_from = ($page-1) * $per_page;
		if($_REQUEST['listdata']==1)
	{
		$fetch_report_pagination="select channel,from_did as extension,DATE_FORMAT(createddate,'%Y-%m-%d') as createdtime,startdate as Start_time,createddate as End_time,duration as Wait_time,queue_exten from missedcall_inbound where date(createddate) between '$startdate' and '$enddate' and channel='$channel' order by createddate desc limit $start_from,$per_page";
	}else if($_REQUEST['listdata']==2){
		$fetch_report_pagination="select channel,from_did as extension,DATE_FORMAT(createddate,'%Y-%m-%d') as createdtime,startdate as Start_time,createddate as End_time,duration as Spoken_time,queue_exten from answer_inbound where  channel='$channel' order by createddate desc limit $start_from,$per_page";
	}else if($_REQUEST['listdata']==4){
		$fetch_login_pagination = "select agent,date(login),count(id) as count from logindetail where date(login) in ('".$split4days."') group by agent,date(login)";
	}
	else
	{
		$fetch_report_miss_pagination = "select channel,queue_exten,date(createddate),count(id) as count from missedcall_inbound where date(createddate) in ('".$split4days."') and channel in ('$channel') group by queue_exten,date(createddate) order by createddate desc";
		$fetch_report_miss_unmat_pagination = "select channel,queue_exten,date(createddate),count(id) as count from missedcall_inbound where date(createddate) in ('".$split4days."') and status = '0' and channel in ('$channel') group by queue_exten,date(createddate) order by createddate desc";
		$fetch_report_miss_matured_pagination = "select channel,queue_exten,date(createddate),count(id) as count from missedcall_inbound where date(createddate) in ('".$split4days."') and status = '1' and channel in ('$channel') group by queue_exten,date(createddate) order by createddate desc";
		$fetch_report_ans_pagination = "select channel,queue_exten,date(createddate),count(id) as count from answer_inbound where date(createddate) in ('".$split4days."') and channel in ('$channel') group by queue_exten,date(createddate) ";
	}

		$get_data_pagination=mysql_query($fetch_report_pagination,$dblink);
		$get_login_pagination=mysql_query($fetch_login_pagination,$dblink);
		$get_mis_pagination=mysql_query($fetch_report_miss_pagination,$dblink);
		$get_mis_unmat_pagination=mysql_query($fetch_report_miss_unmat_pagination,$dblink);
		$get_mis_mat_pagination=mysql_query($fetch_report_miss_matured_pagination,$dblink);
		$get_ans_pagination=mysql_query($fetch_report_ans_pagination,$dblink);
		//print_r($get_mis_mat_pagination);
			
		$count_records_pagination=mysql_num_rows($get_data_pagination);
		$count_login_pagination=mysql_num_rows($get_login_pagination);
		$count_records_mis_pagination=mysql_num_rows($get_mis_pagination);
		$count_records_mis_mat_pagination=mysql_num_rows($get_mis_mat_pagination);
		$count_records_mis_unmat_pagination=mysql_num_rows($get_mis_unmat_pagination);
		$count_records_ans_pagination=mysql_num_rows($get_ans_pagination);
		
		$total_pages = ceil($count_records / $per_page);
		
		if($count_records_pagination > 0)
		{	
		
			while($rows_page=mysql_fetch_array($get_data_pagination,MYSQL_NUM))
			{
				$datatowrite_pagination[]=$rows_page;
		
			}
		}else if($count_records_mis_pagination > 0 || $count_records_ans_pagination>0 || $count_records_mis_mat_pagination > 0 || $count_records_mis_unmat_pagination > 0){
			while($rows_mis_page=mysql_fetch_array($get_mis_pagination,MYSQL_NUM))
			{
				$datatowrite_pagination['miss_sum'][]=$rows_mis_page;
			}
			if($count_records_mis_mat_pagination == 0){
				mysql_data_seek($get_mis_pagination, 0);
				while($rows_mis_mat_page=mysql_fetch_array($get_mis_pagination,MYSQL_NUM))
				{
					$datatowrite_pagination['miss_mat'][]=$rows_mis_mat_page;
				}
			} else{
				while($rows_mis_mat_page=mysql_fetch_array($get_mis_mat_pagination,MYSQL_NUM))
				{
					$datatowrite_pagination['miss_mat'][]=$rows_mis_mat_page;
				}
			}
		
			while($rows_mis_unmat_page=mysql_fetch_array($get_mis_unmat_pagination,MYSQL_NUM))
			{
				$datatowrite_pagination['miss_unmat'][]=$rows_mis_unmat_page;
		
			}
			while($rows_ans_page=mysql_fetch_array($get_ans_pagination,MYSQL_NUM))
			{
				$datatowrite_pagination['ans_sum'][]=$rows_ans_page;
		
			}
		}elseif($count_login_pagination > 0){
			while($rows_logpage=mysql_fetch_array($get_login_pagination,MYSQL_NUM))
			{
				$datatowrite_pagination[]=$rows_logpage;
		
			}
		}
		foreach($header as $hkey=>$hvalue)
		{
			?>
		<th><?php echo ucwords(str_replace("_"," ",$hvalue)); ?></th>
		<?php } ?>
		
	</tr>
	<?php
		
		foreach($datatowrite_pagination as $ckey => $cvalue)
		{
			if($_REQUEST['listdata']!= 3){
		?>
	<tr>
		<td>CBS Mumbai</td>
			<?php 
			if($_REQUEST['listdata'] == 4){ ?>
				<td><?php echo str_replace("SIP/","",$cvalue['0']); ?></td>
				<td><?php echo $cvalue['1']; ?></td>
				<td><?php echo $cvalue['2']; ?></td>
			</tr>
			<?php }else{ ?>
			<td><?php foreach($channeldata as $keys => $values)
			{
				if($cvalue['0'] == $keys)
				{
					echo $values;
				} 
			}
			
			?></td>
			<td><?php 
			$ext_type = $cvalue['1'];
			if(substr($ext_type,0,1) == 7){
				$cvalue['1'] = "SIP Based Call";
			}elseif(substr($ext_type,0,1) == 3){
				$cvalue['1'] = "PRI Based Call";
			}elseif(substr($ext_type,0,1) == 4){
				$cvalue['1'] = "PRI Based Call";
			}elseif(substr($ext_type,0,1) == 6 && strlen($ext_type)==8){
				$cvalue['1'] = "PRI Based Call";
			}elseif(substr($ext_type,0,1) == 6 && strlen($ext_type)==3){
				$cvalue['1'] = "GSM Based Call";
			}else{
				$cvalue['1'] = $ext_type;
			}
		echo $cvalue['1']; ?></td>
		<td><?php echo $cvalue['2']; ?></td>
		<td><?php echo $cvalue['3']; ?></td>
		<td><?php echo $cvalue['4']; ?></td>
		<td><?php echo $cvalue['5']; ?></td>
		<td><?php echo $cvalue['6']; ?></td>
	
	</tr>
	<?php
		} 
		}else{
			if($ckey == 'miss_sum'){ ?>
					<tr><th colspan="4">Missed Call Summary</th></tr> 
			<?php 
			} else if($ckey == 'miss_mat'){ ?>
					<tr><th colspan="4">Matured Missed Calls Summary</th></tr>
					<tr>
					<?php } else if($ckey == 'miss_unmat'){ ?>
					<tr><th colspan="4">UnMatured Missed Calls Summary</th></tr>
					<tr>
					<?php }else{ ?>
					<tr><th colspan="4">Answer Call Summary</th></tr>
					<tr>
				<?php }
			foreach($cvalue as $ck=>$cv){  ?>
				<tr>
					
				<?php  ?>
				<td><?php foreach($channeldata as $keys => $values)
					{
						if($cv['0'] == $keys)
						{
							echo $values;
						} 
					}
					?></td>
				<td><?php echo $cv['1']; ?></td>
				<td><?php echo $cv['2']; ?></td>
				<td><?php if($count_records_mis_mat_pagination == 0 and $ckey == 'miss_mat'){
					echo 0;
				}else{
					echo $cv['3'];
				}	?></td>
			<?php } ?>
		<tr> <?php 
		} 
	}
	?>
		
		
</table>
</div>
<?php
$postchannel=$_REQUEST['channel'];
$postlist=$_REQUEST['listdata']; 
if($postlist == 1 or $postlist == 2){
$pre=$_REQUEST['page']-1;
$next=$_REQUEST['page']+1;
echo '<div class="pagination">';

echo "<center><a href='reportlog.php?page=1&channel=$postchannel&listdata=$postlist&search=search'>".'<span style="font-weight:bold">First</span>'."</a> ";
if($_REQUEST['page']!=1)
echo "<a href='reportlog.php?page=$pre&channel=$postchannel&listdata=$postlist&search=search'>".'<span style="font-weight:bold">Pre</span>'."</a> ";
for ($i=$_REQUEST['page']; $i<$_REQUEST['page']+3; $i++) {

		
		echo "<a href='reportlog.php?page=".$i."&channel=$postchannel&listdata=$postlist&search=search'><span style='font-weight:bold'>".$i."</span></a> ";
		if($_REQUEST['page']==$total_pages)
			break;
};

if($_REQUEST['page']!=$total_pages)
{
	echo "<a href='reportlog.php?page=$next&channel=$postchannel&listdata=$postlist&search=search'>".'<span style="font-weight:bold">Next</span>'."</a> ";
}
echo "<a href='reportlog.php?page=$total_pages&channel=$postchannel&listdata=$postlist&search=search'>".'<span style="font-weight:bold">Last</span>'."</a></center> </div>";
?>
<?php 
	}
}
else{ 
?>
<div class="overalltable"><div class="datatodisplayn" style="<?php echo $down_label; ?>"><p class="recordn">No Record Found</p></div></div>
<?php
 }
 ?>
</div>
			
<div class="footer">
<div class="innerfooter">
<p class="copyrights">Copyright &copy; 2016</p>
</div><!---------------------------------End of innerfooter----------------------->
</div><!---------------------------------End of footer---------------------------->
</div>
</div>
</body>

</html>