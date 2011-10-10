<?php include "base.php" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<?php
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email']))
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

			<h2>Current trains:</h2>

			<?php 
				$result =mysql_query("SELECT * FROM Trains");
				if (!$result) {
				    $message  = 'Invalid query: ' . mysql_error() . "\n";
				    $message .= 'Whole query: ' . $query;
				    die($message);
				}
				while ($row = mysql_fetch_assoc($result)) {
				    echo "<p> <b>Train name</b>: {$row['trainName']}, departure time: {$row['departureTime']}, meeting place: {$row['meetingPlace']}, transportation: {$row['transportType']},spaces available: {$row['spaceAvailable']} </p>";
				    echo "<p> <b>Train description</b>: {$row['trainDescription']} </p>";
				    echo "<br>";
				}
				?>
			</div>

			</div>
	 	</div>
	 </div>
    
    <?php
}