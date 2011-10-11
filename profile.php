<?php include "base.php";?>
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
	 		<div id="topbartitle"><a href="profile.php">LunchTrain</a>
	 		</div>
	 		<div id="topbarlogout">
	 			<a href="logout.php">Logout</a> 
	 		</div>
	 	</div>
	 	<div id="leftsidebar">
			 <div id="leftsidebarpic">
	 		</div>
	 		<div id="name">
	 			<?php echo "<p> {$_SESSION['firstName']} {$_SESSION['lastName']} </p>" ?>
	 			<p> <a href="profile.php?tab=addTrain">Add Train</a></p>
	 		</div>
			 <div id="leftsidebarinfo">
	 		</div>
	 	</div>
	 	<div id="right">
	 		<div id="rightbody">
				<div id="righttitle">
	 				<header id="header">
	 					<li><a href="profile.php?tab=viewTrains">Trains</a></li>
	 					<li><a href="profile.php?tab=aboutMe">About Me</a></li>
			 			<li><a href="profile.php?tab=friends">Friends</a></li>
	 				</header>
	 			</div>
	 			<div id="rightbottom">
	 			<?php 
					$tab = $_GET['tab'];
					if ($tab == "viewTrains" || $tab == "") {
						echo "<h2>Current trains:</h2>";
						$result = mysql_query("SELECT * FROM Trains");
						if (!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($result)) {
							echo "<p> <b>Train name</b>: {$row['trainName']} </p>";
						    echo "<p> <b>Departure time</b>: {$row['departureTime']} </p>";
						    echo "<p> <b>Meeting place</b>: {$row['meetingPlace']} </p>";
						    echo "<p> <b>Transportation</b>: {$row['transportType']} </p>";
						    echo "<p> <b>Saces available</b>: {$row['spaceAvailable']} </p>";
						    echo "<p> <b>Train description</b>: {$row['trainDescription']} </p>";
						    echo "<br>";
						}
					}
					elseif ($tab == "aboutMe") {
		 				echo "<p>About Me</p>";
					} 
	 				elseif ($tab == "friends") {
	 					echo "<p>Friends</p>";
	 				} 
	 				elseif ($tab == "addTrain") {
	 					if(!empty($_POST['train_name']) && !empty($_POST['meeting_time']) && !empty($_POST['meeting_place']) && !empty($_POST['seat_available']) ) {
							$trainName = mysql_real_escape_string($_POST['train_name']);
							$meetingTime = mysql_real_escape_string($_POST['meeting_time']);
							$meetingPlace = mysql_real_escape_string($_POST['meeting_place']);
							$seatAvailable = intval(mysql_real_escape_string($_POST['seat_available']));
							$transportationType = mysql_real_escape_string($_POST['transportation_type']);
							$trainDescription = mysql_real_escape_string($_POST['train_description']);
							
							$trainquery = mysql_query("INSERT INTO trains (spaceAvailable, transportType, trainDescription, 
													  meetingPlace, departureTime, trainName) 
													  VALUES('".$seatAvailable."', '".$transportationType."', '".$trainDescription."', '".$meetingPlace."', '".$meetingTime."', '".$trainName."')");
							
							if($trainquery)
							{
								//Set up ownership of train
								//get trainID
								$trainIDQuery = mysql_query("SELECT trainid FROM trains WHERE trainName = '".$trainName."' AND meetingPlace = '".$meetingPlace."'");
								if (!$trainIDQuery) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								if(mysql_num_rows($trainIDQuery) == 1) {
									$row = mysql_fetch_assoc($trainIDQuery);
									$trainID = $row['trainid'];
								}
								$userID = $_SESSION['userID'];
								$creator = 1;
								$attending = 1;
								$makeOwnerQuery = mysql_query("INSERT INTO user_in_train (userid, trainid, creator, attending) 
																VALUES('".$userID."', '".$trainID."', '".$creator."', '".$attending."')");
								echo "<h1>Train created</h1>";
								echo "<p>You are the owner of train $trainName.</p>";
								echo "<p>We are now redirecting you to your profile page.</p>";
						       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
							}
						}
						elseif(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
							 ?>
							 <h1>Add Train</h1>
							 <p>Please enter your details below to add a train.</p>
				
							 <form method="post" action="profile.php?tab=addTrain" name="registerform"
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
							 <?php }
	 				} ?>
	 		</div>
	 		</div>
	 	</div>
	 </div>
</body>
</html>
