<?php 
	include "base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>
<div id="crate">
		<div id="topbar">
	 		
	 		<div id="topbartitle">
	 		</div>
	 		<div id="searchbar">
	 			<form method="post" action="profile.php?tab=search" name="searchTrain" id="search">
					<input type="text" style="height:20px; width: 300px; border: 1px solid #BBB" name="train" id="train" />
					<input type="image" src="images/search.png" name="image" width="30" height="30">
				</form>
	 		</div>
	 	</div>
	 	
	 	<div id="leftsidebar">
			<div id="leftsidebarpic">
	 		</div>
	 		<div id="name">
	 			<?php
	 			if ($_COOKIE['LoggedIn'] != 1 || $_COOKIE['userID'] == null) {
	 				echo "<meta http-equiv='refresh' content='0;logout.php' />";
	 			}
	 			echo "<p><b> {$_SESSION['firstName']} {$_SESSION['lastName']} </b></p>" ?>
	 			<p> <a href="profile.php?tab=viewNetwork">Join Network</a></p>
	 			<br></br>
	 		</div>
			<div id="leftsidebarinfo">
				<p><b>Trains I'm In:</b>  </p>
	 			<?php 
	 			$userId = $_COOKIE['userID'];
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
			 			
			 			<?php 
			 			$result = mysql_query("SELECT * FROM train_invite WHERE destid = '".$userId."'"); 
			 			$num = mysql_num_rows($result);
			 			if ($num > 0) {
			 				?>
			 				<li><a href="profile.php?tab=inbox">Inbox (<?php echo $num ?>)</a></li>
			 				<?php 
			 			} else {
			 				?>
			 				<li><a href="profile.php?tab=inbox">Inbox</a></li>
			 			<?php }?>
	 				</header>
	 				<div id="logout">
	 					<form method="post" action="logout.php" name="logout" id="logout">
							<input style='border:1px solid #ccc' type="submit" name="logout" id="logout" value="Logout" />
						</form>
	 				</div>
	 			</div>
	 			
	 			<div id="rightbottom">
	 			<?php 
					$tab = $_GET['tab'];
					$userId = $_SESSION['userID'];
					if ($tab == "") {
						echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
					}
					elseif ($tab == "viewTrains") {
						$join = $_GET['joinTrain'];
						if ($join != null) {
							$trainId = $join;
							$attending = 1;
							$joinTrain = mysql_query("INSERT INTO user_in_train (userid, trainid, attending)
																	VALUES('".$userId."', '".$trainId."', '".$attending."')");
							if (!$joinTrain) {
								echo "<p>Unable to join train.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
						}
						
						$leave = $_GET['leaveTrain'];
						if ($leave != null) {
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
							$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainID";
							?>
							<div id="trainslot">
								<div id="slotinfo">
									
									<p> <a href=<?php echo $trainProfileHref ?>> <b><?php echo $row['trainName'] ?></b> </a> </p>
									<?php
						    		echo "<p> Departing at {$row['departureTimeHr']}:{$row['departureTimeMin']} {$row['departureTimeAMPM']} from {$row['meetingPlace']}</p>";
						    		echo "<p> {$row['transportType']} with {$row['spaceAvailable']} spaces available </p>";
						    		echo "<p> Comments: {$row['trainDescription']} </p>";
						    		echo "<p>Networks: "; 
						    		if(!$netQuery) {
						    			$message  = 'Invalid query: ' . mysql_error() . "\n";
										die($message);
						    		}
						    		while($netQueryRow = mysql_fetch_assoc($netQuery)) {
						    			$networkName = $netQueryRow['networkName'];
						    			echo "$networkName. ";
						    		}
						    		echo "</p>";
						    		echo "<br>";
						    		
						    		 ?>
						    		
						    	</div>
						 		<div id="slotoptions">
									<?php 
									$trainId = $row['trainid'];
									$userAlreadyInTrain = mysql_query("SELECT * FROM user_in_train WHERE userid = '".$userId."' AND trainid = '".$trainId."'");
									$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainId";
									if (mysql_num_rows($userAlreadyInTrain) == 1) {
										$href = "profile.php?tab=viewTrains&leaveTrain=$trainId";
										$invHref = "profile.php?tab=invite&trainID=$trainId"; ?>
										<form method="post" action="<?php echo $href ?>" name="leave" id="leavetrain">
										<input type="image" src="images/leave.png" name="image" width="40" height="45">
										</form>
										
										<form method="post" action="<?php echo $invHref ?>" name="invite" id="invite">
										<input type="image" src="images/addfriend.png" name="invite" width="40" height="45">
										</form>
									<?php
									} else { 
										$href = "profile.php?tab=viewTrains&joinTrain=$trainId";
										?>
										<form method="post" action="<?php echo $href ?>" name="join" id="jointrain">
										<input type="image" src="images/join.png" name="image" width="40" height="45">
										</form>
									<?php 
									}
									?>
									
						 		</div>
						 	</div>
						 	<br>
						<?php 
						}
					}
					elseif ($tab == "trainProfile") {
						$trainID = $_GET['trainID'];
						if($trainID == null) {
							echo "<p>Error: No train ID provided. </p>";
						}
						else {
							$getTrainInfo = mysql_query("SELECT * FROM trains WHERE trainid = '".$trainID."'");
							$getTrainNetworkInfo = mysql_query("SELECT * FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");
							$getTrainUserAttendingInfo =  mysql_query("SELECT * FROM users WHERE userid in (SELECT userid FROM user_in_train WHERE trainid = '".$trainID."' AND attending = 1)");
							$getTrainUserCreatorInfo =  mysql_query("SELECT * FROM users WHERE userid in (SELECT userid FROM user_in_train WHERE trainid = '".$trainID."' AND creator = 1)");
							if(!$getTrainInfo || !$getTrainNetworkInfo || !$getTrainUserAttendingInfo || !$getTrainUserCreatorInfo) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							$trainInfo = mysql_fetch_assoc($getTrainInfo);
							$trainCreator = mysql_fetch_assoc($getTrainUserCreatorInfo);
							?>
							<div id="trainslot2">
								<div id="slotinfo">
									<?php 
									echo "<p> <b>{$trainInfo['trainName']}</b> </p>";
									echo "<p> Created by {$trainCreator['firstname']} {$trainCreator['lastname']} </p>";
						    		echo "<p> Departing at {$trainInfo['departureTimeHr']}:{$trainInfo['departureTimeMin']} {$trainInfo['departureTimeAMPM']} from {$trainInfo['meetingPlace']}</p>";
						    		echo "<p> {$trainInfo['transportType']} with {$trainInfo['spaceAvailable']} spaces available </p>";
						    		echo "<p> Comments: {$trainInfo['trainDescription']} </p>";
						    		echo "<p> Networks: "; 
						    		while($trainNetwork = mysql_fetch_assoc($getTrainNetworkInfo)) {
						    			$networkName = $trainNetwork['networkName'];
						    			echo "$networkName. ";
						    		}
						    		echo "</p>";
						    		echo "<p> Attending: ";
									while($trainUsersAttending = mysql_fetch_assoc($getTrainUserAttendingInfo)) {
						    			echo "{$trainUsersAttending['firstname']} {$trainUsersAttending['lastname']}. ";
						    		}
						    		echo "</p>";
						    		echo "<br>";
						    		
						    		 ?>
						    	</div>
						    </div> <?php 
						}
					}
					elseif ($tab == "invite") {
						$trainID = $_GET['trainID'];
						$friendID = $_GET['friendID'];
						if($trainID != null && $friendID == null) {
							//Display friends to invite
							//Get all users who are NOT this user, and who are friends, and who are NOT already invited, and who are NOT already attending on this train
							$trainNameQuery = mysql_query("SELECT trainName FROM trains WHERE trainid = '".$trainID."'");
							$row = mysql_fetch_assoc($trainNameQuery);
							
							echo "<h2>Invite friends to join {$row['trainName']} </h2>";
							$result = mysql_query("SELECT * FROM users WHERE userid <> '".$userId."' 
													AND userid IN (SELECT friendid FROM user_friends WHERE userid = '".$userId."')
													AND userid NOT IN (select destid FROM train_invite WHERE trainid = '".$trainID."')
													AND userid NOT IN (select userid FROM user_in_train WHERE trainid = '".$trainID."')");
							if (!$result) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							while ($row = mysql_fetch_assoc($result)) {
								$friendid = $row['userid'];
								$friendFirstName = $row['firstname'];
								$friendLastName = $row['lastname'];
								$href = "profile.php?tab=invite&trainID=$trainID&friendID=$friendid";
								?>
								<form method="post" action="<?php echo $href ?>" name="invF" id="invF">
								<input type="submit" name="invF" id="invF" value="<?php echo "$friendFirstName $friendLastName" ?>" />
								</form>
								<?php 
							}
						} elseif($trainID != null && $friendID != null) {
							//Add friend
							$add_train_inv_query = mysql_query("INSERT INTO train_invite (sourceid, destid, trainid) 
																VALUES ('".$userId."', '".$friendID."', '".$trainID."')");
							if (!$add_train_inv_query) {
								echo "<p>Unable to send invite.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=invite&trainID=$trainID' />";
						} else {
							echo "Error. TrainID not specified.";
						}
					}
					elseif ($tab == "inbox") {
						$response = $_GET['accept'];
						if($response != null) {
							$trainID = $_GET['trainID'];
							$sourceID = $_GET['sourceID'];
							if($response == "True") {
								#Accepted the invitation.
								#Add the user to the train 
								$attending = 1;
								$joinTrain = mysql_query("INSERT INTO user_in_train (userid, trainid, attending)
																		VALUES('".$userId."', '".$trainID."', '".$attending."')");
								if (!$joinTrain) {
									echo "<p>Unable to join train.</p>";
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								$removeInvite = mysql_query("DELETE from train_invite WHERE sourceid = '".$sourceID."' AND trainid = '".$trainID."' AND destid = '".$userId."'");
								if(!$removeInvite) {
									echo "<p>Unable to remove invite.</p>";
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								echo "<meta http-equiv='refresh' content='0;profile.php?tab=inbox' />";
							} elseif ($response == "False") {
								#Declined the invitation. Just delete this invitation. Maybe let sender know that invitation was declined
								$declineInvite = mysql_query("DELETE from train_invite WHERE sourceid = '".$sourceID."' AND trainid = '".$trainID."' AND destid = '".$userId."'");
								if (!$declineInvite) {
									echo "<p>Unable to decline invite.</p>";
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								echo "<meta http-equiv='refresh' content='0;profile.php?tab=inbox' />";
							} else {
								die("Unknown response: $response");
							}
						} else {
							echo "<h2> Invites to join trains from your friends: </h2>";
							$result = mysql_query("SELECT * FROM train_invite WHERE destid = '".$userId."'");
							if (!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
							while ($row = mysql_fetch_assoc($result)) {
								//Get source name
								$sourceID = $row['sourceid'];
								$getSourceNameQuery = mysql_query("SELECT firstname, lastname FROM users WHERE userid = '".$sourceID."'");
								if(!$getSourceNameQuery) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								$sourceName = mysql_fetch_assoc($getSourceNameQuery);
								echo "<p>From: {$sourceName['firstname']} {$sourceName['lastname']}</p>";
								//Get train name
								$trainID = $row['trainid'];
								$getTrainNameQuery = mysql_query("SELECT * from trains WHERE trainid = '".$trainID."'");
								if(!$getTrainNameQuery) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
								$trainName = mysql_fetch_assoc($getTrainNameQuery);
								$netQuery = mysql_query("SELECT networkName FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");
								?>
								<div id="trainslot">
									<div id="slotinfo">
									<?php 
									
										echo "<p> <b>{$trainName['trainName']}</b> </p>";
							    		echo "<p> Departing at {$trainName['departureTimeHr']}:{$trainName['departureTimeMin']} {$trainName['departureTimeAMPM']} from {$trainName['meetingPlace']}</p>";
							    		echo "<p> {$trainName['transportType']} with {$trainName['spaceAvailable']} spaces available </p>";
							    		echo "<p> Comments: {$trainName['trainDescription']} </p>";
							    		echo "<p>Networks: "; 
							    		if(!$netQuery) {
							    			$message  = 'Invalid query: ' . mysql_error() . "\n";
											die($message);
							    		}
							    		while($netQueryRow = mysql_fetch_assoc($netQuery)) {
							    			$networkName = $netQueryRow['networkName'];
							    			echo "$networkName. ";
							    		}
							    		echo "</p>";
							    		echo "<br>";
							    		?>
							    	</div>
							    	<?php 
					    		$acceptLink = "profile.php?tab=inbox&trainID=$trainID&sourceID=$sourceID&accept=True";
					    		$declineLink = "profile.php?tab=inbox&trainID=$trainID&sourceID=$sourceID&accept=False";
								?>
								<div id="slotoptions">
								
								<form method="post" action="<?php echo $acceptLink ?>" name="invite" id="invite">
								<input type="image" src="images/accept.png" name="invite" width="40" height="45">
								</form>
								<form method="post" action="<?php echo $declineLink ?>" name="dec" id="dec">
								<input type="image" src="images/decline.png" name="dec" width="40" height="45">
								</form>
								
								</div>
								</div>
								<br>
								<?php 
							}
						}
					}
					elseif ($tab == "aboutMe") {
						$result = mysql_query("SELECT * FROM profiles WHERE userid = '".$userId."'");
						if (!$result) {
							echo "<p>Your profile has not been set up yet.</p>";
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							
						}
						while ($row = mysql_fetch_assoc($result)) {
							echo "<p> <b>Employment</b>: {$row['employment']} </p>";
							echo "<p> <b>Education</b>: {$row['education']} </p>";
							echo "<p> <b>Favorite Foods</b>: {$row['favoriteFood']} </p>";
							echo "<p> <b>Favorite Restaurant</b>: {$row['favoriteRestaurant']} </p>";
						}
						?>
						<form method="post" action="profile.php?tab=editProfile" name="registerform" id="registerform">
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
							$employment = mysql_real_escape_string($_POST['employment']);
							$education = mysql_real_escape_string($_POST['education']);
							$favoriteFood = mysql_real_escape_string($_POST['favorite_food']);
							$favoriteRestaurant = mysql_real_escape_string($_POST['favorite_restaurant']);
							
							$result = mysql_query("INSERT INTO profiles (userid, employment, education, favoriteFood, favoriteRestaurant)
													VALUES('".$userId."', '".$employment."', '".$education."', '".$favoriteFood."', '".$favoriteRestaurant."')");
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
	 					$result = mysql_query("SELECT * FROM users WHERE userid <> '".$userId."'");
						if (!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						while ($row = mysql_fetch_assoc($result)) {
							$friendID = $row['userid'];
							$friendFirstName = $row['firstname'];
							$friendLastName = $row['lastname'];
							$userProfileHref = "profile.php?tab=viewUser&id=$friendID";	
							?>
							<p> <a href=<?php echo $userProfileHref ?>> <b><?php echo "$friendFirstName $friendLastName" ?> </b> </a> </p>
							<?php
							$friendQuery = mysql_query("SELECT * FROM user_friends WHERE userid = '".$userId."' AND friendid = '".$friendID."' ORDER BY userid ASC ");
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
	 				elseif ($tab == "viewUser") {
	 					$viewID = $_GET['id'];
	 					if ($viewID != null && is_numeric($viewID)) {
	 						//print profile
	 						$getUserInfo = mysql_query("SELECT firstname, lastname FROM users WHERE userid = '".$viewID."'");
	 						if(!$getUserInfo) {
	 							$message  = 'Invalid query: ' . mysql_error() . "\n";
	 							echo "$message";
								die($message);
	 						} else {
	 							$row = mysql_fetch_assoc($getUserInfo);
	 							$userFirstname = $row['firstname'];
	 							$userLastname = $row['lastname'];
	 						}
		 					$viewProfile = mysql_query("SELECT * FROM profiles WHERE userid = '".$viewID."'");
							if (!$viewProfile) {
								echo "<p>$userFirstname $userLastname's profile has not been set up yet.</p>";
							} else {
								$row = mysql_fetch_assoc($viewProfile);
									echo "<h2> Profile for $userFirstname $userLastname: </h2>";
									echo "<p> <b>Employment</b>: {$row['employment']} </p>";
									echo "<p> <b>Education</b>: {$row['education']} </p>";
									echo "<p> <b>Favorite Foods</b>: {$row['favoriteFood']} </p>";
									echo "<p> <b>Favorite Restaurant</b>: {$row['favoriteRestaurant']} </p>";
								
							}
							echo "<br>";
							//print trains
							$getTrainInfo = mysql_query("SELECT * FROM trains WHERE trainid in 
														(SELECT trainid FROM user_in_train WHERE userid = '".$viewID."' 
														AND attending = 1)");
							echo "<h2> Trains $userFirstname $userLastname are on: </h2> ";
							if (!$getTrainInfo) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message); 
							}
							while($trainInfo = mysql_fetch_assoc($getTrainInfo)) {
								$trainID = $trainInfo['trainid'];
								$netQuery = mysql_query("SELECT networkName FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");
								$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainID";
								?>
								<div id="trainslot">
								<div id="slotinfo">
									
									<p> <a href=<?php echo $trainProfileHref ?>> <b><?php echo $trainInfo['trainName'] ?></b> </a> </p>
									<?php
						    		echo "<p> Departing at {$trainInfo['departureTimeHr']}:{$trainInfo['departureTimeMin']} {$trainInfo['departureTimeAMPM']} from {$trainInfo['meetingPlace']}</p>";
						    		echo "<p> {$trainInfo['transportType']} with {$trainInfo['spaceAvailable']} spaces available </p>";
						    		echo "<p> Comments: {$trainInfo['trainDescription']} </p>";
						    		echo "<p>Networks: "; 
						    		if(!$netQuery) {
						    			$message  = 'Invalid query: ' . mysql_error() . "\n";
										die($message);
						    		}
						    		while($netQueryRow = mysql_fetch_assoc($netQuery)) {
						    			$networkName = $netQueryRow['networkName'];
						    			echo "$networkName. ";
						    		}
						    		echo "</p>";
						    		echo "<br>";
						    		
						    		 ?>
						    		
						    	</div>
						    	</div>
						    	<?php 
							}
	 					}
	 				}
	 				elseif ($tab == "viewNetwork") {
	 					$join = $_GET['joinN'];
						if ($join != null) {
							$networkID = $join;
							$joinNetwork = mysql_query("INSERT INTO user_in_net (userid, netid) VALUES('".$userId."', '".$networkID."')");
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
							$leaveNetwork = mysql_query("DELETE FROM user_in_net WHERE userid = '".$userId."' AND netid = '".$networkID."'");
							if (!$leaveNetwork) {
								echo "<p>Unable to leave network.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewNetwork' />";
						}
	 					//display all networks
	 					echo "<h2>Your networks</h2>";
	 					$networkIDQuery = mysql_query("SELECT * FROM user_in_net WHERE userid = '".$userId."'");
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
						$notMemberNetworkIDQuery = mysql_query("SELECT netid FROM network WHERE netid NOT IN (SELECT netid FROM user_in_net WHERE userid = '".$userId."')");
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
							$networkName = mysql_real_escape_string($_POST['networkName']);
							$networkDescription = mysql_real_escape_string($_POST['networkDescription']);
							$result = mysql_query("INSERT INTO network (networkName, description)
													VALUES('".$networkName."', '".$networkDescription."')");
							if ($result) {
								$networkIDQuery = mysql_query("SELECT * FROM network WHERE networkName = '".$networkName."' AND description = '".$networkDescription."'");
					        	$row = mysql_fetch_array($networkIDQuery);
					        	$networkID = $row['netid'];
					        	
					        	$networkInsertQuery = mysql_query("INSERT INTO user_in_net (userid, netid) VALUES ('".$userId."', '".$networkID."')");
					        	if(!$networkInsertQuery) {
					        		die("Cannot insert into network");
					        	}
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
							
							if ($meetingTimeHr > 12 || $meetingTimeHr < 1) {
								die("Invalid hour inputted");
							}
							if ($meetingTimeMin > 59 || $meetingTimeMin < 1) {
								die("Invalid minute inputted");
							}
							$trainquery = mysql_query("INSERT INTO trains (spaceAvailable, transportType, trainDescription, 
													  meetingPlace, departureTimeHr, departureTimeMin, departureTimeAMPM, trainName) 
													  VALUES('".$seatAvailable."', '".$transportationType."', '".$trainDescription."', '".$meetingPlace."', '".$meetingTimeHr."', '".$meetingTimeMin."', '".$meetingTimeAmpm."', '".$trainName."')");

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
								$creator = 1;
								$attending = 1;
								$makeOwnerQuery = mysql_query("INSERT INTO user_in_train (userid, trainid, creator, attending) 
																VALUES('".$userId."', '".$trainID."', '".$creator."', '".$attending."')");
								$addTrainNetworkQuery = mysql_query("INSERT INTO train_in_net (trainid, netid) VALUES ('".$trainID."', '".$netID."')");
								if (!$makeOwnerQuery || !$addTrainNetworkQuery) {
									$message  = "Invalid Insert query: " . mysql_error() . "\n";
									die($message);
								}
								echo "<h1>Train created</h1>";
								echo "<p>You are the owner of train $trainName.</p>";
								echo "<p>We are now redirecting you to your profile page.</p>";
						       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
							}
						}
						else {
							 ?>
							 <h2>Add Train</h2>
							 <p>Please enter your details below to add a train.</p>
				
							 <form method="post" action="profile.php?tab=addTrain" name="registerform"
								id="registerform">
								<fieldset>
									<p><label for="train_name">Train Name:</label>
									<input type="text" name="train_name" id="train_name" /><br /> </p>
									<p><label for="meeting_time">Meeting Time:</label>
									<input type="text" name="meeting_time_hr" maxlength="2" size="4" id="meeting_time" />
									:
									<input type="text" name="meeting_time_min" maxlength="2" size="4" id="meeting_time" />
									<select name="ampm">
										<option value="am">am</option>
										<option value="pm">pm</option>
									</select>
									<br /> </p>
									<p><label for="transportation_type">Transportation Type:</label>
									<select name="transportation_type">
										<option value="Driving">Driving</option>
										<option value="Walking">Walking</option>
										<option value="Biking">Biking</option>
										<option value="Public">Public Transportation</option>
										<option value="Other">Other</option>
									</select><br /></p>
									<p><label for="meeting_place">Meeting Place:</label>
									<input type="text" name="meeting_place" id="meeting_place" /><br /></p>
									<p><label for="seat_available">Seat Available:</label>
									<input type="text" name="seat_available" id="seat_available" /><br /> </p>
									<p><label for="train_description">Train Description:</label>
									<input type="text" name="train_description" id="train_description" /><br /> </p>
									<p><label for="network">Network:</label>
									<select name="network">
										 <?php 
									        $result = mysql_query("SELECT * FROM network WHERE netid in 
									        					(SELECT netid FROM user_in_net WHERE userid = '".$userId."') ORDER BY netid ASC");
											if (!$result) {
												$message  = 'Invalid query: ' . mysql_error() . "\n";
												die($message);
											}
									        while ($row = mysql_fetch_assoc($result)) { 
									            echo '<option value="'.$row['networkName'].'">'.$row['networkName'].'</option>';
									        } 
									    ?> 
									</select><br /></p>
									<p><input type="submit" name="add" id="add" value="Add Train" /></p>
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



