<?php 
	ob_start();
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>
<div id="body">
	 	<div id="topbar">
	 		<div id="topbartitle">LunchTrain
	 		</div>
	 		<div id="topbarlogout">
	 			<a href="logout.php">Logout</a> 
	 		</div>
	 	</div>
	 	<div id="leftsidebar">
			 <div id="leftsidebarpic">
	 		</div>
	 		<div id="name">
	 			<p><?=$_SESSION['firstName']?> <?=$_SESSION['lastName']?></p>
	 			<p> <a href="addtrain.php">Add Train</a></p>
	 			<p> <a href="viewtrains.php">View Trains</a></p>
	 		</div>
			 <div id="leftsidebarinfo">
	 		</div>
	 	</div>
	 	<div id="right">
	 		<div id="rightbody">
	 			<header id="header">
	 				<li><a href="#">Trains</a></li>
	 				<li><a href="#">About Me</a></li>
			 		<li><a href="#">Friends</a></li>
	 			</header>
	 		</div>
	 	</div>
	 </div>
</body>
</html>