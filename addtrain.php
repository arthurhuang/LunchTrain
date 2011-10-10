<?php include "base.php" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<?php
if(!empty($_POST['train_name']))
{
	$trainName = mysql_real_escape_string($_POST['train_name']);
	$meetingTime = mysql_real_escape_string($_POST['meeting_time']);
	$meetingPlace = mysql_real_escape_string($_POST['meeting_place']);
	$seatAvailable = intval(mysql_real_escape_string($_POST['seat_available']));
	$transportationType = mysql_real_escape_string($_POST['transportation_type']);
	$trainDescription = mysql_real_escape_string($_POST['train_description']);
	
	$trainquery = mysql_query("INSERT INTO Trains (spaceAvailable, transportType, trainDescription, 
							  meetingPlace, departureTime, trainName) 
							  VALUES('".$seatAvailable."', '".$transportationType."', '".$trainDescription."', '".$meetingPlace."', '".$meetingTime."', '".$trainName."')");
	
	
	if($trainquery)
	{
		echo "<h1>Train created</h1>";
		echo "<p>We are now redirecting you to your profile page.</p>";
       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
	}
}
elseif(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email']))
{
	 ?>
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
	 			<div id="righttitle">
	 			<header id="header">
	 				<li><a href="#">Trains</a></li>
	 				<li><a href="#">About Me</a></li>
			 		<li><a href="#">Friends</a></li>
	 			</header>
	 			</div>
	 		<div id="rightbottom">
	 		<h1>Add Train</h1>

			<p>Please enter your details below to add a train.</p>

			<form method="post" action="addtrain.php" name="registerform"
				id="registerform">
				<fieldset>
					<label for="train_name">Train Name:</label>
					<input type="text" name="train_name" id="train_name" /><br />
					<label for="meeting_time">Meeting Time:</label>
					<input type="text" name="meeting_time" id="meeting_time" /><br /> 
					<label for="transportation_type">Transportation Type:</label>
					<input type="text" name="transportation_type" id="transportation_type" /><br />
					<label for="meeting_place">Meeting Place:</label>
					<input type="text" name="meeting_place" id="meeting_place" /><br />
					<label for="seat_available">Seat Available:</label>
					<input type="text" name="seat_available" id="seat_available" /><br /> 
					<label for="train_description">Train Description:</label>
					<input type="text" name="train_description" id="train_description" /><br /> 
					<input type="submit" name="add" id="add" value="Add Train" />
				</fieldset>
			</form>
			</div>

			</div>
	 	</div>
	 </div>
    
    <?php
}