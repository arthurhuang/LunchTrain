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
	 		<div id="topbarline">
	 		</div>
	 		<div id="topbartitle">
	 		</div>
	 	</div>
	 	<div id="leftsidebar">
			<div id="leftsidebarpic">
	 		</div>
	 		<div id="name">

	 			<?php echo "<p><b> {$_SESSION['firstName']} {$_SESSION['lastName']} </b></p>" ?>
	 			<p> <a href="profile.php?tab=viewNetwork">Join Network</a></p>
	 			<br></br>
	 		</div>
			<div id="leftsidebarinfo">
				<p><b>Trains I'm In:</b>  </p>
	 			<?php 
	 			$userId = $_SESSION['userID'];
	 			$trainsImIn = mysql_query("SELECT * FROM user_in_train WHERE userid = '".$userId."'");
	 			
	 			while ($row = mysql_fetch_assoc($trainsImIn)) {
	 				$trainId = $row['trainid'];
	 				$train = mysql_query("SELECT * FROM trains WHERE trainid = '".$trainId."'");
	 				$trainrow = mysql_fetch_assoc($train);
	 				echo "<p> {$trainrow['trainName']}  </p>"; 
				}?>

	 			<form method="post" action="profile.php?tab=addTrain" name="add" id="addtrain">
				<input type="image" src="images/add.png" name="image" width="101" height="27">
				</form>
	 		</div>
			 
	 	</div>
	 	<div id="right">
	 		<div id="rightbody">
				
				<div id="righttitle">
	 				<header id="header">
	 					<li><a href="profile.php?tab=viewTrains">Trains</a></li>
	 					<li><a href="profile.php?tab=aboutMe">About Me</a></li>
			 			<li><a href="profile.php?tab=friends">Friends</a></li>
			 			<li><a href="profile.php?tab=inbox">Inbox</a></li>
	 				</header>
	 				<div id="logout">
	 					<form method="post" action="logout.php" name="logout" id="logout">
							<input type="submit" name="logout" id="logout" value="Logout" />
						</form>
	 				</div>
	 			</div>
	 			
	 			<div id="rightbottom">
	 				<?php 
					$tab = $_GET['tab'];
					if ($tab == "viewTrains" || $tab == "") {
						$join = $_GET['joinTrain'];
						if ($join != null) {
							$userId = $_SESSION['userID'];
							$trainId = $join;
							$joinTrain = mysql_query("INSERT INTO user_in_train (userid, trainid)
																	VALUES('".$userId."', '".$trainId."')");
							if (!$joinTrain) {
								echo "<p>Unable to join train.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
						}
						
						$leave = $_GET['leaveTrain'];
						if ($leave != null) {
							$userId = $_SESSION['userID'];
							$trainId = $leave;
							$leaveTrain = mysql_query("DELETE FROM user_in_train WHERE userid='".$userId."' AND trainid='".$trainId."'");
							if (!$leaveTrain) {
								echo "<p>Unable to leave train.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
						}
						
						$result = mysql_query("SELECT * FROM trains");
						if (!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($result)) {
							$trainID = $row['trainid'];
							$netQuery = mysql_query("SELECT networkName FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");	
							?>
							<div id="trainslot">
								<div id="slotinfo">
									<?php 
									echo "<p> <b>{$row['trainName']}</b> </p>";
						    		echo "<p> Departing at {$row['departureTime']} at location {$row['meetingPlace']}</p>";
						    		echo "<p> {$row['transportType']} with {$row['spaceAvailable']} spaces available </p>";
						    		echo "<p> Comments: {$row['trainDescription']} </p>";
						    		echo "<p> <b>Networks</b>: "; ?>
						    		
						    		/*if(!$netQuery) {
						    			$message  = 'Invalid query: ' . mysql_error() . "\n";
										die($message);
						    		}
						    		while($netQueryRow = mysql_fetch_assoc($netQuery)) {
						    			$networkName = $netQueryRow['networkName'];
						    			echo "$networkName. ";
						    		}
						    		echo "</p>";
						    		echo "<br>"; ?>*/
						    	</div>
						    	
						 		<div id="slotoptions">
									<?php 
									$userId = $_SESSION['userID'];
									$trainId = $row['trainid'];
									$userAlreadyInTrain = mysql_query("SELECT * FROM user_in_train WHERE userid = '".$userId."' AND trainid = '".$trainId."'");
									if (mysql_num_rows($userAlreadyInTrain) == 1) {
										$href = "profile.php?tab=viewTrains&leave=".$trainId; ?>
										<form method="post" action="<?= $href ?>" name="leave" id="leavetrain">
										<input type="image" src="images/leave.png" name="image" width="71" height="27">
										</form>
									<?php
									} else { 
										$href = "profile.php?tab=viewTrains&joinTrain=$trainId";
										?>
										<form method="post" action="<?= $href ?>" name="join" id="jointrain">
										<input type="image" src="images/join.png" name="image" width="56" height="27">
										</form>
									<?php 
									}
									?>
						 		</div>
						 	</div>
						 	<p>.</p>
						<?php 
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
	 					$join = $_GET['addFriend'];
						if ($join != null) {
							$userId = $_SESSION['userID'];
							$friendID = $join;
							$addFriend = mysql_query("INSERT INTO user_friends (userid, friendid)
																	VALUES('".$userId."', '".$friendID."')");
							if (!$addFriend) {
								echo "<p>Unable to add friend.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=friends' />";
						}
						
						$delete = $_GET['leaveFriend'];
						if ($delete != null) {
							$userId = $_SESSION['userID'];
							$friendID = $delete;
							$leaveTrain = mysql_query("DELETE FROM user_friends WHERE userid='".$userId."' AND friendid='".$friendID."'");
							if (!$leaveTrain) {
								echo "<p>Unable to leave train.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=friends' />";
						}
						
	 					echo "<h2>Friends</h2>";
	 					$result = mysql_query("SELECT * FROM users WHERE userid <> '".$_SESSION['userID']."'");
						if (!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($result)) {
							$friendID = $row['userid'];
							$friendFirstName = $row['firstname'];
							$friendLastName = $row['lastname'];
							echo "<p> $friendFirstName $friendLastName </p>";
							$friendQuery = mysql_query("SELECT * FROM user_friends WHERE userid = '".$_SESSION['userID']."' AND friendid = '".$friendID."' ORDER BY userid ASC ");
							if (mysql_num_rows($friendQuery) == 1) {
								$href = "profile.php?tab=friends&leaveFriend=$friendID"; ?>
								<form method="post" action="<?php echo $href ?>" name="leaveF" id="leaveFriend">
								<input type="submit" name="leaveF" id="leaveF" value="Unfriend" />
								</form>
				 			<?php
							} else { 
								$href = "profile.php?tab=friends&addFriend=$friendID";
								?>
								<form method="post" action="<?php echo $href ?>" name="joinF" id="addFriend">
								<input type="submit" name="joinF" id="joinF" value="Friend" />
								</form>
							<?php 
							}
						}
						/*
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
						*/
	 				} 
	 				elseif ($tab == "viewNetwork") {
						$userID = $_SESSION['userID'];
	 					$join = $_GET['joinN'];
						if ($join != null) {
							$networkID = $join;
							$joinNetwork = mysql_query("INSERT INTO user_in_net (userid, netid) VALUES('".$userID."', '".$networkID."')");
							if (!$joinNetwork) {
								echo "<p>Unable to join network.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewNetwork' />";
						} 
						$leave = $_GET['leaveN'];
						if ($leave != null) {
							$networkID = $leave;
							$leaveNetwork = mysql_query("DELETE FROM user_in_net WHERE userid = '".$userID."' AND netid = '".$networkID."'");
							if (!$leaveNetwork) {
								echo "<p>Unable to leave network.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewNetwork' />";
						}
	 					//display all networks
	 					echo "<h2>Your networks</h2>";
	 					$networkIDQuery = mysql_query("SELECT * FROM user_in_net WHERE userid = '".$_SESSION['userID']."'");
	 					if (!$networkIDQuery) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($networkIDQuery)) {
							$netID = $row['netid'];
							$networkQuery = mysql_query("SELECT * from network WHERE netid = '".$netID."'");
							$network = mysql_fetch_assoc($networkQuery);
							$networkName = $network['networkName'];
							$networkDescription = $network['description'];
							echo "<b>$networkName</b>:";
							echo "<p> $networkDescription </p>";
							$href = "profile.php?tab=viewNetwork&leaveN=$netID";
							?>
							<form method="post" action="<?php echo $href ?>" name="leaveN" id="leaveN">
								<input type="submit" name="leaveN" id="leaveN" value="Leave" />
							</form>
							<?php 
						}
						echo "<br>";
						echo "<h2>Networks you can join</h2>";
						$notMemberNetworkIDQuery = mysql_query("SELECT netid FROM network WHERE netid NOT IN (SELECT netid FROM user_in_net WHERE userid = '".$_SESSION['userID']."')");
						if (!$notMemberNetworkIDQuery) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($notMemberNetworkIDQuery)) {
							$netID = $row['netid'];
							$networkQuery = mysql_query("SELECT * from network WHERE netid = '".$netID."'");
							$network = mysql_fetch_assoc($networkQuery);
							$networkName = $network['networkName'];
							$networkDescription = $network['description'];
							echo " <b>$networkName</b>:";
							echo "<p> $networkDescription </p>";
							$href = "profile.php?tab=viewNetwork&joinN=$netID";
							?>
							<form method="post" action="<?php echo $href ?>" name="joinN" id="joinN">
								<input type="submit" name="joinN" id="joinN" value="Join" />
							</form>
							<?php 
						}
						echo "<br>";
						?>
						<form method="post" action="profile.php?tab=addNetwork" name="registerform"
						id="registerform">
						<input type="submit" name="addNetwork" id="addNetwork" value="Add network" />
						</form>
						<?php 
	 				}
	 				elseif ($tab == "addNetwork") { ?>
						<p>Create a new network.</p>
						
						<form method="post" action="profile.php?tab=submitNetwork" name="registerform"
						id="registerform">
						<fieldset>
						<label for="networkName">Network name:</label>
						<input type="text" name="networkName" id="networkName" /><br />
						<label for="networkDescription">Description:</label>
						<textarea name="networkDescription" cols=16 rows=4></textarea> 
						<input type="submit" name="edit" id="edit" value="Add" />
						</fieldset>
						</form>
					<?php
	 				}
	 				elseif ($tab == "submitNetwork") {
	 					if(!empty($_POST['networkName']) && !empty($_POST['networkDescription'])) {
							$userid = $_SESSION['userID'];
							$networkName = mysql_real_escape_string($_POST['networkName']);
							$networkDescription = mysql_real_escape_string($_POST['networkDescription']);
							
							$result = mysql_query("INSERT INTO network (networkName, description)
													VALUES('".$networkName."', '".$networkDescription."')");
							if ($result) {
								$networkIDQuery = mysql_query("SELECT * FROM network WHERE networkName = '".$networkName."' AND description = '".$networkDescription."'");
					        	$row = mysql_fetch_array($networkIDQuery);
					        	$networkID = $row['netid'];
					        	
					        	$networkInsertQuery = mysql_query("INSERT INTO user_in_net VALUES ('".$userid."', '".$networkID."')");
					        	
								echo "<h1>A new network has been created.</h1>";
								echo "<p>We are now redirecting you to the network page.</p>";
								echo "<meta http-equiv='refresh' content='1.5;profile.php?tab=viewNetwork' />";
							} else { 
								echo "<p> insert profile query failed </p>";
							}
						} else { ?>
							<form method="post" action="profile.php?tab=editProfile" name="registerform" id="registerform">
							<input type="submit" name="edit" id="edit" value="Add Network" />
							</form>
							<p>You did not fill in all fields.</p>
						<?php 	
						}
	 				}
	 				elseif ($tab == "addTrain") {
	 					if(!empty($_POST['train_name']) && !empty($_POST['meeting_time_hr']) && !empty($_POST['meeting_time_min']) && !empty($_POST['meeting_place']) && !empty($_POST['seat_available']) && !empty($_POST['network']) ) {
							$trainName = mysql_real_escape_string($_POST['train_name']);
							$meetingTimeHr = intval(mysql_real_escape_string($_POST['meeting_time_hr']));
							$meetingTimeMin = intval(mysql_real_escape_string($_POST['meeting_time_min']));
							$meetingTimeAmpm = mysql_real_escape_string($_POST['ampm']);
							$meetingPlace = mysql_real_escape_string($_POST['meeting_place']);
							$seatAvailable = intval(mysql_real_escape_string($_POST['seat_available']));
							$transportationType = mysql_real_escape_string($_POST['transportation_type']);
							$trainDescription = mysql_real_escape_string($_POST['train_description']);
							$networkName = mysql_real_escape_string($_POST['network']);
							
							$meetingTime = $meetingTimeHr*100 + $meetingTimeMin; 
							$trainquery = mysql_query("INSERT INTO trains (spaceAvailable, transportType, trainDescription, 
													  meetingPlace, departureTime, trainName) 
													  VALUES('".$seatAvailable."', '".$transportationType."', '".$trainDescription."', '".$meetingPlace."', '".$meetingTime."', '".$trainName."')");

							if($trainquery)
							{
								//Set up ownership of train
								//get trainID
								$trainIDQuery = mysql_query("SELECT trainid FROM trains WHERE trainName = '".$trainName."' AND meetingPlace = '".$meetingPlace."'");
								$netIDQuery = mysql_query("SELECT netid FROM network WHERE networkName = '".$networkName."'");
								if (!$trainIDQuery || !$netIDQuery) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								if(mysql_num_rows($trainIDQuery) == 1) {
									$row = mysql_fetch_assoc($trainIDQuery);
									$trainID = $row['trainid'];
								}
								if(mysql_num_rows($netIDQuery) == 1) {
									$netrow = mysql_fetch_assoc($netIDQuery);
									$netID = $netrow['netid'];
								}
								$userID = $_SESSION['userID'];
								$creator = 1;
								$attending = 1;
								$makeOwnerQuery = mysql_query("INSERT INTO user_in_train (userid, trainid, creator, attending) 
																VALUES('".$userID."', '".$trainID."', '".$creator."', '".$attending."')");
								echo "train: $trainID, net: $netID";
								$addTrainNetworkQuery = mysql_query("INSERT INTO train_in_net (trainid, netid) VALUES ('".$trainID."', '".$netID."')");
								if (!$makeOwnerQuery || !$addTrainNetworkQuery) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								echo "<h1>Train created</h1>";
								echo "<p>You are the owner of train $trainName.</p>";
								echo "<p>We are now redirecting you to your profile page.</p>";
						       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
							}
						}
						elseif(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email'])) {
							 ?>
							 <h2>Add Train</h2>
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
									<label for="network">Network:</label>
									<select name="network">
										 <?php 
										 	$userid = $_SESSION['userID'];
									        $result = mysql_query("SELECT * FROM network WHERE netid in 
									        					(SELECT netid FROM user_in_net WHERE userid = '".$userid."') ORDER BY netid ASC");
											if (!$result) {
												$message  = 'Invalid query: ' . mysql_error() . "\n";
												die($message);
											}
									        while ($row = mysql_fetch_assoc($result)) { 
									            echo '<option value="'.$row['networkName'].'">'.$row['networkName'].'</option>';
									        } 
									    ?> 
									</select><br />
									<input type="submit" name="add" id="add" value="Add Train" />
								</fieldset>
							</form>
					</div>
					<?php 
						}
	 				}
	 			 ?>
	 		</div>
	 		</div>
	 	</div>
</body>
</html>




