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
						$result = mysql_query("SELECT * FROM trains");
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
						$email = $_SESSION['Email'];
						$result = mysql_query("SELECT * FROM profiles WHERE email = '".$email."'");
						if (!$result) {
							echo "<p>Your profile has not been set up yet.</p>";
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($result)) {
							echo "<p> <b>Employment</b>: {$row['employment']} </p>";
							echo "<p> <b>Education</b>: {$row['education']} </p>";
							echo "<p> <b>Favorite Foods</b>: {$row['favoriteFood']} </p>";
							echo "<p> <b>Favorite Restaurant</b>: {$row['favoriteRestaurant']} </p>";
							echo "<br>";
						}
						?>
						<form method="post" action="profile.php?tab=editProfile" name="registerform"
						id="registerform">
						<input type="submit" name="edit" id="edit" value="Edit Profile" />
						</form>
						<?php
					} 
					elseif ($tab == "editProfile") { ?>
						<p>Please enter your information below to edit your profile.</p>
						
						<form method="post" action="profile.php?tab=submitProfile" name="registerform"
						id="registerform">
						<fieldset>
						<label for="employment">Employment:</label>
						<input type="text" name="employment" id="employment" /><br />
						<label for="education">Education:</label>
						<input type="text" name="education" id="education" /><br />
						<label for="favorite_food">Favorite Foods:</label>
						<input type="text" name="favorite_food" id="favorite_food" /><br />
						<label for="favorite_restaurant">Favorite Restaurants:</label>
						<input type="text" name="favorite_restaurant" id="favorite_restaurant" /><br />
						<input type="submit" name="edit" id="edit" value="Edit" />
						</fieldset>
						</form>
					<?php  
					}
					elseif ($tab == "submitProfile") {
						if(!empty($_POST['employment']) && !empty($_POST['education']) && !empty($_POST['favorite_food']) && !empty($_POST['favorite_restaurant']) ) {
							$email = $_SESSION['Email'];
							$employment = mysql_real_escape_string($_POST['employment']);
							$education = mysql_real_escape_string($_POST['education']);
							$favoriteFood = mysql_real_escape_string($_POST['favorite_food']);
							$favoriteRestaurant = mysql_real_escape_string($_POST['favorite_restaurant']);
							
							
							$result = mysql_query("INSERT INTO profiles (email, employment, education, favoriteFood, favoriteRestaurant)
													VALUES('".$email."', '".$employment."', '".$education."', '".$favoriteFood."', '".$favoriteRestaurant."')");
							if ($result) {
								echo "<h1>Your profile has been edited.</h1>";
								echo "<p>We are now redirecting you to your profile page.</p>";
								echo "<meta http-equiv='refresh' content='1.5;profile.php?tab=aboutMe' />";
							} else { 
								echo "<p> insert profile query failed </p>";
							}
						} else { ?>
							<form method="post" action="profile.php?tab=editProfile" name="registerform" id="registerform">
							<input type="submit" name="edit" id="edit" value="Edit Profile" />
							</form>
							<p>You did not fill in all fields.</p>
						<?php 	
						}
					}
	 				elseif ($tab == "friends") {
	 					echo "<h2>Friends</h2>";
	 					$currentFriendQuery = mysql_query("SELECT * FROM user_friends WHERE userid = '".$_SESSION['userID']."'");
	 					if(!$currentFriendQuery) {
	 						$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($currentFriendQuery)) {
							$friendID = $row['friendid'];
							$friendNameQuery = mysql_query("SELECT firstname, lastname FROM users WHERE userid = '".$friendID."'");
							if(!$friendNameQuery) {
		 						$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							if(mysql_num_rows($friendNameQuery) == 1) {
								$friendNameRow = mysql_fetch_assoc($friendNameQuery);
								$friendFirstName = $friendNameRow['firstname'];
								$friendLastName = $friendNameRow['lastname'];
								echo "<p> $friendFirstName $friendLastName </p>";
							}
						}
	 					echo "<br>";
	 					echo "<h2>These people are not your friends.</h2>";
	 					//i want all the users who are NOT this user AND are not already friends with this user
	 					//query is wrong
	 					$peopleNotFriendsQuery = mysql_query("SELECT * FROM users WHERE userid <> '".$_SESSION['userID']."' AND NOT EXISTS (SELECT friendid FROM user_friends WHERE userid = '".$_SESSION['userID']."')");
	 					if (!$peopleNotFriendsQuery) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($peopleNotFriendsQuery)) {
							echo "<p> {$row['firstname']} {$row['lastname']} </p>";
						}
	 				} 
	 				elseif ($tab == "addTrain") {
	 					if(!empty($_POST['train_name']) && !empty($_POST['meeting_time_hr']) && !empty($_POST['meeting_time_min']) && !empty($_POST['meeting_place']) && !empty($_POST['seat_available']) ) {
							$trainName = mysql_real_escape_string($_POST['train_name']);
							$meetingTimeHr = intval(mysql_real_escape_string($_POST['meeting_time_hr']));
							$meetingTimeMin = intval(mysql_real_escape_string($_POST['meeting_time_min']));
							$meetingTimeAmpm = mysql_real_escape_string($_POST['ampm']);
							$meetingPlace = mysql_real_escape_string($_POST['meeting_place']);
							$seatAvailable = intval(mysql_real_escape_string($_POST['seat_available']));
							$transportationType = mysql_real_escape_string($_POST['transportation_type']);
							$trainDescription = mysql_real_escape_string($_POST['train_description']);
							
							$meetingTime = $meetingTimeHr*100 + $meetingTimeMin; 
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
									<input type="text" name="meeting_time_hr" maxlength="2" size="4" id="meeting_time" />
									:
									<input type="text" name="meeting_time_min" maxlength="2" size="4" id="meeting_time" />
									<select name="ampm">
										<option value="am">am</option>
										<option value="pm">pm</option>
									</select>
									<br /> 
									<label for="transportation_type">Transportation Type:</label>
									<select name="transportation_type">
										<option value="Driving">Driving</option>
										<option value="Walking">Walking</option>
										<option value="Biking">Biking</option>
										<option value="Public">Public Transportation</option>
										<option value="Other">Other</option>
									</select><br />
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
