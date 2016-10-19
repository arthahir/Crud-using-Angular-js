<?php
#Commented: Ashok !unwanted Db call
//include("dbconnect.php"); 
?>
<html> 
<head>
	<!-- General Metas -->
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">	<!-- Force Latest IE rendering engine -->
	<title>Asterisk Call Report - Login Form</title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
	
	<!-- Stylesheets -->
	<link rel="stylesheet" href="css/base.css">
	<!-- <link rel="stylesheet" href="css/skeleton.css"> -->
	<link rel="stylesheet" href="css/layout.css">
	<!-- <script type="text/javascript" src="js/jquery.min.js"> </script> -->
	<script type="text/javascript" src="js/script.js"></script>	
	
</head>
<!--Commented: Ashok !unwanted load function
<body onload="check()">-->
<body>
<?php
#Commented: Ashok !unwanted Query
//$sql = "select distinct(queue) from queue";
//$query = mysql_query($sql);
?>
	<!-- Primary Page Layout -->
	<div class="container">
		<div class="form-bg">
			<form action="sess.php" method="POST" name="loginForm" id="loginForm">
			<?php	
				$showLabel = 'Login';
				if(!empty($_GET['sessexp'])){
					$showLabel .= '<span style="font-size:12px;color:red;padding-left:120px;">&nbsp;Successfully Logout!</span>';
				}
				elseif (!empty($_GET['invalident'])){
					$showLabel .=  '<span style="font-size:12px;color:red;padding-left:120px;">&nbsp;Authetication Error!</span>';
				}
				?>
				
				<h2><?php echo $showLabel?></h2>
				<p><input type="text"  name="login" id="fname" placeholder="Username"/></p>
				<p><input type="password" name="passwd" id="password" placeholder="Password" onblur="checkfresh();"/></p>
				<button type="submit" name="Submit" value="Login" onclick="return validate();"/>
			</form>
		</div>
	</div>
</body>
</html>


