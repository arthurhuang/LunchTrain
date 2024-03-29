<?php 
	include "base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
<script src="validate.js" type="text/javascript"></script>
<script src="calendar.js" type="text/javascript"></script>

</head>  
<body>
<div id="crate">
		<div id="topbar">
	 		<div id="topbartitle">
	 		</div>
	 		<div id="searchbar">
	 			<form method="post" action="profile.php?tab=search" name="searchTrain" id="search">
					<input type="text" style="height:20px; float:left; width: 300px; border: 1px solid #BBB" name="query" id="query" />
					<input type="image" style='float:left' src="images/search.png" name="image" width="30" height="30">
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
	 			<br></br>
	 		</div>
			<div id="leftsidebarinfo">
				<p><b>My Networks:</b></p>
				<?php 
				$userId = $_COOKIE['userID'];
				$networksImIn = mysql_query("SELECT * FROM user_in_net WHERE userid = '".$userId."'");
				
				while ($row = mysql_fetch_assoc($networksImIn)) {
					$netId = $row['netid'];
					$net = mysql_query("SELECT * FROM network WHERE netid = '".$netId."'");
					$netrow = mysql_fetch_assoc($net);
					echo "<p> {$netrow['networkName']} </p>";
				}
				?>
				<form method="post" action="profile.php?tab=viewNetwork" name="joinnetwork" id="joinnetwork">
				<input type="image"  src="images/joinnetwork.png" name="network" width="104" height="23">
				</form>
				<br></br>
				
				
				<p><b>Trains I'm In:</b>  </p>
	 			<?php 
	 			$userId = $_COOKIE['userID'];
	 			$trainsImIn = mysql_query("SELECT * FROM user_in_train WHERE userid = '".$userId."' AND attending='1'");
	 			
	 			while ($row = mysql_fetch_assoc($trainsImIn)) {
	 				$trainId = $row['trainid'];
	 				$train = mysql_query("SELECT * FROM trains WHERE trainid = '".$trainId."'");
	 				$trainrow = mysql_fetch_assoc($train);
	 				$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainId"; ?>
	 				<p> <a href=<?php echo $trainProfileHref ?>> <b><?php echo $trainrow['trainName'] ?></b> </a> </p>
				<?php 
				}?>
				
				<form method="post" action="profile.php?tab=addTrain" name="addtrain" id="addtrain">
				<input type="image"  src="images/createtrain.png" name="train" width="99" height="23">
				</form>
				
	 		</div>
			 
	 	</div>
	 	<div id="right">
	 		<div id="rightbody">
				
				<div id="righttitle">
	 				<header id="header">
	 					<?php 
	 					
	 					$tabValue = $_GET['tab'];
	 					if ($tabValue == "myTrains" || $tabValue == "") {
	 						$link = "profile.php?tab=myTrains";
	 						echo "<li><a href=$link style='background-color:#ddd'>My Trains</a></li>";
	 					} else {
	 						$link = "profile.php?tab=myTrains";
	 						echo "<li><a href=$link >My Trains</a></li>";
	 					}
	 					if ($tabValue == "viewTrains") {
	 						$link = "profile.php?tab=viewTrains";
	 						echo "<li><a href=$link style='background-color:#ddd'>Search Trains</a></li>";
	 					} else {
	 						$link = "profile.php?tab=viewTrains";
	 						echo "<li><a href=$link >Search Trains</a></li>";
	 					}
	 					if ($tabValue == "aboutMe") {
	 						$link = "profile.php?tab=aboutMe";
	 						echo "<li><a href=$link style='background-color:#ddd'>About Me</a></li>";
	 					} else {
	 						$link = "profile.php?tab=aboutMe";
	 						echo "<li><a href=$link >About Me</a></li>";
	 					}
	 					if ($tabValue == "friends") {
	 						$link = "profile.php?tab=friends";
	 						echo "<li><a href=$link style='background-color:#ddd'>Friends</a></li>";
	 					} else {
	 						$link = "profile.php?tab=friends";
	 						echo "<li><a href=$link >Friends</a></li>";
	 					}
	 					
			 			$result = mysql_query("SELECT * FROM train_invite WHERE destid = '".$userId."'"); 
			 			$num = mysql_num_rows($result);
			 			if ($tabValue == "inbox") {
			 				if ($num > 0) {
			 					?>
			 					<li><a href="profile.php?tab=inbox" style='background-color:#ddd'>Inbox (<?php echo $num ?>)</a></li>
			 					<?php 
			 				} else {
			 					?>
			 					<li><a href="profile.php?tab=inbox" style='background-color:#ddd'>Inbox</a></li>
			 				<?php 
			 				}
			 			} else {
			 				if ($num > 0) {
			 					?>
			 					<li><a href="profile.php?tab=inbox">Inbox (<?php echo $num ?>)</a></li> 
			 				<?php 
			 				} else { ?>
			 					<li><a href="profile.php?tab=inbox">Inbox</a></li>
			 				<?php 
			 				}
			 			}?>
			 			
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
					elseif($tab == "search") {
						$query = mysql_real_escape_string($_POST['query']);
						echo "<p><b> Search results for: $query </b></p>";
						$searchQuery = mysql_query("SELECT * FROM trains WHERE trainName LIKE '%".$query."%' OR trainDescription LIKE '%".$query."%' OR meetingPlace LIKE '%".$query."%'");
						if(!$searchQuery) {
							echo "<p>Search failed.</p>";
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						} 
						if(mysql_num_rows($searchQuery) == 0) {
							echo "<p>Sorry, no trains were found matching your query. </p>";
						}
						while($searchRow = mysql_fetch_assoc($searchQuery)) {
							$trainID = $searchRow['trainid'];
							$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainID";
							$netQuery = mysql_query("SELECT networkName, netid FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");	
							if(!$netQuery) {
						    	$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
						    }
							$netQueryRow = mysql_fetch_assoc($netQuery);
						    $networkName = $netQueryRow['networkName'];
						    $networkID = $netQueryRow['netid'];
						    
						    $checkNetworkUserTrain = mysql_query("SELECT * FROM user_in_net WHERE userid='".$userId."' AND netid = '".$networkID."'");
						    if(mysql_num_rows($checkNetworkUserTrain) != 1) {
						    	continue;
						    }
						    ?>
								<div id="trainslot">
									<div id="slotinfo">
										
										<p> <a href=<?php echo $trainProfileHref ?>> <b><?php echo $searchRow['trainName'] ?></b> </a> </p>
										<?php
										$mysqldate = $searchRow['departureDateTime'];
										$deptTime = date('h:i a', strtotime( $mysqldate)).' on '.date('l, F jS, Y', strtotime( $mysqldate));
							    		echo "<p> Departing at $deptTime from {$searchRow['meetingPlace']}</p>";
							    		echo "<p> {$searchRow['transportType']} with {$searchRow['spaceAvailable']} spaces available </p>";
							    		echo "<p> Comments: {$searchRow['trainDescription']} </p>";
							    		echo "<p>Network: $networkName"; 
							    		echo "</p>";
							    		echo "<br>"
							    		 ?>
							    	</div> <?php 
						    $checkUserInTrain = mysql_query("SELECT * FROM user_in_train WHERE userid='".$userId."' AND trainid = '".$trainID."' AND attending='1'");
						    if(mysql_num_rows($checkUserInTrain) == 1) {
						    	$checkUserInTrainRow = mysql_fetch_assoc($checkUserInTrain);
								?>
							 		<div id="slotoptions">
										<?php 
										$trainId = $searchRow['trainid'];
										$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainId";
										$href = "profile.php?tab=viewTrains&leaveTrain=$trainId";
										$invHref = "profile.php?tab=invite&trainID=$trainId"; ?>
										<form method="post" action="<?php echo $invHref ?>" name="invite" id="invite">
										<input type="image"  src="images/addfriend.png" name="invite" width="99" height="23">
										</form>
										<form method="post" action="<?php echo $href ?>" name="leave" id="leavetrain">
										<input type="image"  src="images/leavetrain.png" name="image" width="97" height="23">
										</form>
										<?php 
										if (1 == $checkUserInTrainRow['creator']) { 
											$delHref = "profile.php?tab=delete&trainID=$trainId"; ?>
											<form method="post" action="<?php echo $delHref ?>" name="leave" id="leavetrain">
											<input type="image"  src="images/deletetrain.png" name="image" width="97" height="23">
											</form>
										
										<?php 
										}?>
									</div>
										<?php 
										if (1 == $checkUserInTrainRow['creator']) { ?>
										<div>
											<p> <a href=<?php echo $editHref ?>>Edit</a> </p>
										</div>
									<?php 
									}?>
									</div>
							<?php
						    } else {
						    	$href = "profile.php?tab=viewTrains&joinTrain=$trainId";
								?>
								<form method="post" action="<?php echo $href ?>" name="join" id="jointrain">
								<input type="image" style='float:left' src="images/join.png" name="image" width="83" height="23">
								</form>
								</div>
								<br>
						    	<?php 
						    }
						}
					}
					elseif ($tab == "myTrains") {
						$leave = $_GET['leaveTrain'];
						if ($leave != null) {
							$trainId = $leave;
							$leaveTrain = mysql_query("UPDATE user_in_train SET attending='0' WHERE userid='".$userId."' AND trainid='".$trainId."'");
							if (!$leaveTrain) {
								echo "<p>Unable to leave train.</p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
						}
						
						$result = mysql_query("SELECT * FROM user_in_train WHERE userid='".$userId."' AND attending='1'");
						if (!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						if(mysql_num_rows($result) == 0) {
						   	echo "You have not joined any trains. Look at <a href=\"profile.php?tab=viewTrains\">Search Trains</a> for a list of trains you can join.";
					    }
						while ($row = mysql_fetch_assoc($result)) {
							$trainID = $row['trainid'];
							$netQuery = mysql_query("SELECT networkName FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");
							$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainID";
							
							$trainq = mysql_query("SELECT * FROM trains WHERE trainid = '".$trainID."'");
							$trainr = mysql_fetch_assoc($trainq);
							?>
							<div id="trainslot">
								<div id="slotinfo">
									
									<p> <a href=<?php echo $trainProfileHref ?>> <b><?php echo $trainr['trainName'] ?></b> </a> </p>
									<?php
									$mysqldate = $trainr['departureDateTime'];
									$deptTime = date('h:i a', strtotime( $mysqldate)).' on '.date('l, F jS, Y', strtotime( $mysqldate));
						    		echo "<p> Departing at $deptTime from {$trainr['meetingPlace']}</p>";
						    		echo "<p> {$trainr['transportType']} with {$trainr['spaceAvailable']} spaces available </p>";
						    		echo "<p> Comments: {$trainr['trainDescription']} </p>";
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
									$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainId";
									$href = "profile.php?tab=viewTrains&leaveTrain=$trainId";
									$invHref = "profile.php?tab=invite&trainID=$trainId";
									$editHref = "profile.php?tab=editTrain&trainID=$trainId" ?>
									<form method="post" action="<?php echo $invHref ?>" name="invite" id="invite">
									<input type="image"  src="images/addfriend.png" name="invite" width="99" height="23">
									</form>
									<form method="post" action="<?php echo $href ?>" name="leave" id="leavetrain">
									<input type="image"  src="images/leavetrain.png" name="image" width="97" height="23">
									</form>
									<?php 
									if (1 == $row['creator']) { 
										$delHref = "profile.php?tab=delete&trainID=$trainId"; ?>
										<form method="post" action="<?php echo $delHref ?>" name="leave" id="leavetrain">
										<input type="image"  src="images/deletetrain.png" name="image" width="97" height="23">
										</form>
										
									<?php 
									}?>
								</div>
									<?php 
									if (1 == $row['creator']) { ?>
										<div>
											<p> <a href=<?php echo $editHref ?>>Edit</a> </p>
										</div>
									<?php 
									}?>
							</div>
							<br>
						<?php
						} 
					}
					elseif ($tab == "delete"){
						$delete = $_GET['trainID'];
						if ($delete != null) {
							$trainId = intval($delete);
							$delUserInTrain = mysql_query("DELETE FROM user_in_train WHERE trainid = '".$trainId."'");
							$delTrainInNet = mysql_query("DELETE FROM train_in_net WHERE trainid = '".$trainId."'");
							$delTrainInvite = mysql_query("DELETE FROM train_invite WHERE trainid = '".$trainId."'");
							$delTrain = mysql_query("DELETE FROM trains WHERE trainid = '".$trainId."'");
							if (!$delUserInTrain || !$delTrainInNet || !$delTrainInNet || !$delTrain) {
								echo "<p> Unable to delete train. </p>";
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=myTrains' />";
						}
					}
					elseif ($tab == "viewTrains") {
						$join = $_GET['joinTrain'];
						if ($join != null) {
							$trainId = intval($join);
							//check if there are still spaces available
							$spacesAvailableQuery = mysql_query("SELECT spaceAvailable FROM trains WHERE trainid = $trainId");
							if(!$spacesAvailableQuery) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							$row = mysql_fetch_assoc($spacesAvailableQuery);
							$spacesAvailable = $row['spaceAvailable'];
							if($spacesAvailable < 1) {
								echo "<p>Sorry, train is already full. Unable to join</p>";
							} else {
								$attending = 1;
								$check = mysql_query("SELECT * FROM user_in_train WHERE userid='".$userId."' AND trainid='".$trainId."'");
								if(!$check) {
									die("Check failed");
								}
								
								if(mysql_num_rows($check)) {
									$joinTrain = mysql_query("UPDATE user_in_train SET attending='1' WHERE userid='".$userId."' AND trainid='".$trainId."'");
								} else {
									$joinTrain = mysql_query("INSERT INTO user_in_train (userid, trainid, attending)
																		VALUES('".$userId."', '".$trainId."', '".$attending."')");
								}
								$updateSpaceAvai = mysql_query("update trains SET spaceAvailable = spaceAvailable - 1 WHERE trainid = $trainId");
								if (!$joinTrain || !$updateSpaceAvai) {
									echo "<p>Unable to join train. </p>";
									$message  = 'Invalid query: '.mysql_error($joinTrain)."\n";
									die($message);
								}
								echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
							}
						}
						
						$leave = $_GET['leaveTrain'];
						if ($leave != null) {
							$trainId = intval($leave);
							$leaveTrain = mysql_query("UPDATE user_in_train SET attending='0' WHERE userid='".$userId."' AND trainid='".$trainId."'");
							$updateSpaceAvai = mysql_query("update trains SET spaceAvailable = spaceAvailable + 1 WHERE trainid = $trainId");
							if (!$leaveTrain || !$updateSpaceAvai) {
								echo "<p>Unable to leave train.</p>";
								$message  = "Invalid query: " .mysql_error(). "\n";
								die($message);
							}
							echo "<meta http-equiv='refresh' content='0;profile.php?tab=viewTrains' />";
						}
						
						$result = mysql_query("SELECT * FROM trains WHERE trainid NOT IN (SELECT trainid FROM user_in_train WHERE userid='".$userId."' AND attending='1')");
						if (!$result) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						if(mysql_num_rows($result) == 0) {
						   	echo "There are no trains in your network that you have not already joined. <a href=\"profile.php?tab=addTrain\">Create a train</a> to start planning your lunch.";
					    }
						while ($row = mysql_fetch_assoc($result)) {
							$trainID = $row['trainid'];
							$netQuery = mysql_query("SELECT networkName, netid FROM network WHERE netid IN (SELECT netid FROM train_in_net WHERE trainid = '".$trainID."')");	
							if(!$netQuery) {
						    	$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
						    }
							$netQueryRow = mysql_fetch_assoc($netQuery);
						    $networkName = $netQueryRow['networkName'];
						    $networkID = $netQueryRow['netid'];
						    
						    $checkNetworkUserTrain = mysql_query("SELECT * FROM user_in_net WHERE userid='".$userId."' AND netid = '".$networkID."'");
						    if(mysql_num_rows($checkNetworkUserTrain) != 1) {
						    	continue;
						    }
							$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainID";
							?>
							<div id="trainslot">
								<div id="slotinfo">
									
									<p> <a href=<?php echo $trainProfileHref ?>> <b><?php echo $row['trainName'] ?></b> </a> </p>
									<?php
						    		$mysqldate = $row['departureDateTime'];
									$deptTime = date('h:i a', strtotime( $mysqldate)).' on '.date('l, F jS, Y', strtotime( $mysqldate));
						    		echo "<p> Departing at $deptTime from {$row['meetingPlace']}</p>";
						    		echo "<p> {$row['transportType']} with {$row['spaceAvailable']} spaces available </p>";
						    		echo "<p> Comments: {$row['trainDescription']} </p>";
						    		echo "<p>Network: $networkName"; 
						    		echo "</p>";
						    		echo "<br>";
						    		
						    		 ?>
						    		
						    	</div>
						 		<div id="slotoptions">
									<?php 
									$trainId = $row['trainid'];
									$userAlreadyInTrain = mysql_query("SELECT * FROM user_in_train WHERE userid = '".$userId."' AND trainid = '".$trainId."' AND attending='1'");
									$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainId";
									if (mysql_num_rows($userAlreadyInTrain) == 1) {
										$href = "profile.php?tab=viewTrains&leaveTrain=$trainId";
										$invHref = "profile.php?tab=invite&trainID=$trainId"; 
										?>
										<form method="post" action="<?php echo $invHref ?>" name="invite" id="invite">
										<input type="image" style='float:left' src="images/addfriend.png" name="invite" width="99" height="23">
										</form>
										</div>
										<div id="slotexit">
											<form method="post" action="<?php echo $href ?>" name="leave" id="leavetrain">
											<input type="image"  src="images/leave.png" name="image" width="20" height="20">
											</form>
									<?php
									} else { 
										$href = "profile.php?tab=viewTrains&joinTrain=$trainId";
										?>
										<form method="post" action="<?php echo $href ?>" name="join" id="jointrain">
										<input type="image" style='float:left' src="images/join.png" name="image" width="83" height="23">
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
									$mysqldate = $trainInfo['departureDateTime'];
									$deptTime = date('h:i a', strtotime( $mysqldate)).' on '.date('l, F jS, Y', strtotime( $mysqldate));
									echo "<p> <b>{$trainInfo['trainName']}</b> </p>";
									echo "<p> Created by {$trainCreator['firstname']} {$trainCreator['lastname']} </p>";
						    		echo "<p> Departing at $deptTime from {$trainInfo['meetingPlace']}</p>";
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
						 		<div id="slotoptions">
						 		<?php 
									$trainId = $trainID;
									$userAlreadyInTrain = mysql_query("SELECT * FROM user_in_train WHERE userid = '".$userId."' AND trainid = '".$trainId."' AND attending='1'");
									$trainProfileHref = "profile.php?tab=trainProfile&trainID=$trainId";
									if (mysql_num_rows($userAlreadyInTrain) == 1) {
										$href = "profile.php?tab=viewTrains&leaveTrain=$trainId";
										$invHref = "profile.php?tab=invite&trainID=$trainId"; 
										?>
										<form method="post" action="<?php echo $invHref ?>" name="invite" id="invite">
										<input type="image" style='float:left' src="images/addfriend.png" name="invite" width="99" height="23">
										</form>
										<form method="post" action="<?php echo $href ?>" name="leave" id="leavetrain">
										<input type="image"  src="images/leavetrain.png" name="image" width="97" height="23">
										</form>
										<?php 
										$row = mysql_fetch_assoc($userAlreadyInTrain);
										if ($row['creator'] == 1) { 
											$delHref = "profile.php?tab=delete&trainID=$trainId"; ?>
											<form method="post" action="<?php echo $delHref ?>" name="leave" id="leavetrain">
											<input type="image"  src="images/deletetrain.png" name="image" width="97" height="23">
											</form>
										<?php 
										}?>
									</div>
										<?php
										if (1 == $row['creator']) { 
											$editHref = "profile.php?tab=editTrain&trainID=$trainId"; ?>
											<div>
												<p> <a href=<?php echo $editHref ?>>Edit</a> </p>
											</div>
										<?php 
										}?>
										
									<?php
									} else { 
										$href = "profile.php?tab=viewTrains&joinTrain=$trainId";
										?>
										<form method="post" action="<?php echo $href ?>" name="join" id="jointrain">
										<input type="image" style='float:left' src="images/join.png" name="image" width="83" height="23">
										</form>
									<?php 
									}
									$row = mysql_fetch_assoc($userAlreadyInTrain);
									if (1 == $row['creator']) { 
										$delHref = "profile.php?tab=delete&trainID=$trainId"; ?>
										<form method="post" action="<?php echo $delHref ?>" name="leave" id="leavetrain">
										<input type="image"  src="images/deletetrain.png" name="image" width="97" height="23">
										</form>
										<form method="post" action="<?php echo $editHref ?>" name="edit" id="edittrain">
										<input type="image"  src="images/edittrain.png" name="image" width="97" height="23">
										</form>
									<?php 
									}
									?>
									
						 		
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
							?>
							<p style="font-size:15px; font-weight:bold">Invite friends to join <?php echo $row['trainName'] ?>:</p>
							<?php 
							//check if there are still spaces available
							$spacesAvailableQuery = mysql_query("SELECT spaceAvailable FROM trains WHERE trainid = $trainID");
							if(!$spacesAvailableQuery) {
								$message  = 'Invalid query: ' . mysql_error() . "\n";
								die($message);
							}
							$row = mysql_fetch_assoc($spacesAvailableQuery);
							$spacesAvailable = $row['spaceAvailable'];
							if($spacesAvailable < 1) {
								echo "<p>Sorry, train is already full. Please choose another train.</p>";
								break;
							}
							$result = mysql_query("SELECT * FROM users WHERE userid <> '".$userId."' 
													AND userid IN (SELECT friendid FROM user_friends WHERE userid = '".$userId."')
													AND userid NOT IN (select destid FROM train_invite WHERE trainid = '".$trainID."')
													AND userid NOT IN (select userid FROM user_in_train WHERE trainid = '".$trainID."' AND attending='1')");
							if (mysql_num_rows($result) == 0) {
								echo "<p>All your friends have already been invited on this train.</p>";
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
								$check = mysql_query("SELECT * FROM user_in_train WHERE userid='".$userId."' and trainid='".$trainID."'");
								if(mysql_num_rows($check) == 1) {
									$checkAlreadyInTrain = mysql_query("SELECT * FROM user_in_train WHERE userid='".$userId."' and trainid='".$trainID."' AND attending='1'");
									if(mysql_num_rows($checkAlreadyInTrain)) $alreadyIn = True;
									$joinTrain = mysql_query("UPDATE user_in_train set attending='1' WHERE userid='".$userId."' and trainid='".$trainID."'");
								} else {
									$joinTrain = mysql_query("INSERT INTO user_in_train (userid, trainid, attending)
																		VALUES('".$userId."', '".$trainID."', '".$attending."')");
								}
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
								if($alreadyIn) {
									echo "You have already joined this train. Dismissing invite.";
									echo "<meta http-equiv='refresh' content='2;profile.php?tab=inbox' />";
								} else {
								echo "<meta http-equiv='refresh' content='0;profile.php?tab=inbox' />";
								}
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
							$result = mysql_query("SELECT * FROM train_invite WHERE destid = '".$userId."'");
							if (!$result) {
									$message  = 'Invalid query: ' . mysql_error() . "\n";
									die($message);
								}
							if (mysql_num_rows($result) == 0) echo "You have no messages in your inbox.";
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
							    		$mysqldate = $trainName['departureDateTime'];
										$deptTime = date('h:i a', strtotime( $mysqldate)).' on '.date('l, F jS, Y', strtotime( $mysqldate));
						    			echo "<p> Departing at $deptTime from {$trainName['meetingPlace']}</p>";
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
								<input type="image" style='float:left' src="images/accept.png" name="invite" width="64" height="23">
								</form>
								<form method="post" action="<?php echo $declineLink ?>" name="dec" id="dec">
								<input type="image" style='float:left' src="images/decline.png" name="dec" width="67" height="23">
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
							die($message);
						}
						if(mysql_num_rows($result) == 0) {
							echo "<p>Your profile has not been set up yet. Please click below to start editing your profile. </p>";
						}
						else {
							while ($row = mysql_fetch_assoc($result)) {
								echo "<p> <b>Employment</b>: {$row['employment']} </p>";
								echo "<p> <b>Education</b>: {$row['education']} </p>";
								echo "<p> <b>Favorite Foods</b>: {$row['favoriteFood']} </p>";
								echo "<p> <b>Favorite Restaurant</b>: {$row['favoriteRestaurant']} </p>";
							}
						}
						?>
						<form method="post" action="profile.php?tab=editProfile" id="registerform">
							<input type="image" name="edit" src="images/editprofile.png" width="90" height="23" />
						</form>
						<?php
					} 
					elseif ($tab == "editProfile") {
						$getProfile = mysql_query("SELECT * FROM profiles WHERE userid = '".$userId."'");
						if(mysql_num_rows($getProfile) == 1) {
							$profileRow = mysql_fetch_assoc($getProfile);
							?>
							<p>Please enter your information below to edit your profile.</p>
							<br></br>
								<form method="post" action="profile.php?tab=submitProfile" id="registerform">
									<fieldset>
										<label for="employment">Employment:</label>
											<input type="text" name="employment" id="employment" value="<?php echo $profileRow['employment']?>"/><br />
											<label for="education">Education:</label>
										  	<input type="text" name="education" id="education" value="<?php echo $profileRow['education']?>"/><br />
											<label for="favorite_food">Favorite Foods:</label>
											<input type="text" name="favorite_food" id="favorite_food" value="<?php echo $profileRow['favoriteFood']?>"/><br />
											<label for="favorite_restaurant">Favorite Restaurants:</label>
											<input type="text" name="favorite_restaurant" id="favorite_restaurant" value="<?php echo $profileRow['favoriteRestaurant']?>" /><br />
											<input type="submit" name="edit" id="edit" value="Save changes" />
										</fieldset>
								</form>
							<?php 
						} else {
							?>
							<p>Please enter your information below to edit your profile.</p>
							<br></br>
								<form method="post" action="profile.php?tab=submitProfile" id="registerform">
									<fieldset>
										<label for="employment">Employment:</label>
										<input type="text" name="employment" id="employment" /><br />
										<label for="education">Education:</label>
										<input type="text" name="education" id="education" /><br />
										<label for="favorite_food">Favorite Foods:</label>
										<input type="text" name="favorite_food" id="favorite_food" /><br />
										<label for="favorite_restaurant">Favorite Restaurants:</label>
										<input type="text" name="favorite_restaurant" id="favorite_restaurant" /><br />
										<input type="submit" name="edit" id="edit" value="Save changes" />
									</fieldset>
							</form>
							<?php 
						}
					}
					elseif ($tab == "submitProfile") {
						if(!empty($_POST['employment']) || !empty($_POST['education']) || !empty($_POST['favorite_food']) || !empty($_POST['favorite_restaurant']) ) {
							$employment = mysql_real_escape_string($_POST['employment']);
							$education = mysql_real_escape_string($_POST['education']);
							$favoriteFood = mysql_real_escape_string($_POST['favorite_food']);
							$favoriteRestaurant = mysql_real_escape_string($_POST['favorite_restaurant']);
							
							$getProfile = mysql_query("SELECT * FROM profiles WHERE userid = '".$userId."'");
							if(mysql_num_rows($getProfile) == 1) {
								$result = mysql_query("UPDATE profiles SET employment='".$employment."', education='".$education."', favoriteFood='".$favoriteFood."', favoriteRestaurant='".$favoriteRestaurant."' WHERE userid = '".$userId."'");
							} else {
								$result = mysql_query("INSERT INTO profiles (userid, employment, education, favoriteFood, favoriteRestaurant)
													VALUES('".$userId."', '".$employment."', '".$education."', '".$favoriteFood."', '".$favoriteRestaurant."')");
							}
							if ($result) {
								echo "<h1>Your profile has been updated.</h1>";
								echo "<p>We are now redirecting you to your profile page.</p>";
								echo "<meta http-equiv='refresh' content='1.5;profile.php?tab=aboutMe' />";
							} else { 
								echo "<p> insert profile query failed </p>";
								$message  = 'Invalid query: ' . mysql_error() . '\n';
								echo ($message);
							}
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
	 					$isFriend = mysql_query("SELECT * FROM users WHERE userid <> '".$userId."' AND userid IN 
	 					                      (SELECT friendid FROM user_friends WHERE userid='".$userId."' ORDER BY userid ASC)");
	 					$isNotFriend = mysql_query("SELECT * FROM users WHERE userid <> '".$userId."' AND userid NOT IN 
	 					                      (SELECT friendid FROM user_friends WHERE userid='".$userId."' ORDER BY userid ASC)");
						if (!$isFriend || !$isNotFriend) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
						}
						echo "<p><b>Your friends:</b></p>";
						if(mysql_num_rows($isFriend) == 0) {
							echo "<p> You have not added any friends yet :( </p>";
							echo "<br>";
						}
						while($friendRow = mysql_fetch_assoc($isFriend)) {
							$fID = $friendRow['userid'];
							$fFirstName = $friendRow['firstname'];
							$fLastName = $friendRow['lastname'];
							$userProfileHref = "profile.php?tab=viewUser&id=$fID";
							$leavehref = "profile.php?tab=friends&leaveFriend=$fID";
							?>
							<div>
									<a href=<?php echo $userProfileHref ?> style='float:left; width:100px' > <b><?php echo "$fFirstName $fLastName" ?> </b> </a> 
									<form method="post" action="<?php echo $leavehref ?>" name="leaveF" id="leaveFriend">
										<input type="image"  src="images/removefriend.png" name="leaveF" width="117" height="23" />
									</form>
								</div>
							<?php 
						}
						echo "<p><b>Add friends!</b></p>";
	 					if(mysql_num_rows($isNotFriend) == 0) {
							echo "<p> You have already added everyone... </p>";
							echo "<br>";
						}
						while($notFriendRow = mysql_fetch_assoc($isNotFriend)) {
							$fID = $notFriendRow['userid'];
							$fFirstName = $notFriendRow['firstname'];
							$fLastName = $notFriendRow['lastname'];
							$userProfileHref = "profile.php?tab=viewUser&id=$fID";
							$addhref = "profile.php?tab=friends&addFriend=$fID";
							?>
								<div>
									<a href=<?php echo $userProfileHref ?> style='float:left; width:100px' > <b><?php echo "$fFirstName $fLastName" ?> </b> </a> 
									<form method="post" action="<?php echo $addhref ?>" name="joinF" id="addFriend">
										<input type="image"  src="images/friend.png" name="joinF" width="93" height="23" />
									</form>
								</div>
							<?php 
						}
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
							echo "<h2> Trains $userFirstname $userLastname is on: </h2> ";
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
						    		$mysqldate = $trainInfo['departureDateTime'];
									$deptTime = date('h:i a', strtotime( $mysqldate)).' on '.date('l, F jS, Y', strtotime( $mysqldate));
						    		echo "<p> Departing at $deptTime from {$trainInfo['meetingPlace']}</p>";
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
	 					echo "<p><b>Your Networks:</b></p>";
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
							$href = "profile.php?tab=viewNetwork&leaveN=$netID";  ?>
							
							<div style="border-bottom:1px dotted;width:525px">
								<div style='float:left; width:400px'>
									<b><?php echo $networkName ?></b>
									<p><?php echo $networkDescription ?></p>
								</div>
								<div>
									<form method="post" action="<?php echo $href ?>" name="leaveN" id="leaveN">
										<input type="image"  src="images/leavenetwork.png" name="leaveN" width="117" height="23" />
									</form>
								</div>
							</div>
							
							
							<?php 
						}
						echo "<br>";
						echo "<p><b>Join Network:</b></p>";
						$notMemberNetworkIDQuery = mysql_query("SELECT netid FROM network WHERE netid NOT IN (SELECT netid FROM user_in_net WHERE userid = '".$userId."')");
						if (mysql_num_rows($notMemberNetworkIDQuery) == 0) {
							echo "<p> There are currently no networks for you to join. </p>";
						}
						while ($row = mysql_fetch_assoc($notMemberNetworkIDQuery)) {
							$netID = $row['netid'];
							$networkQuery = mysql_query("SELECT * from network WHERE netid = '".$netID."'");
							$network = mysql_fetch_assoc($networkQuery);
							$networkName = $network['networkName'];
							$networkDescription = $network['description'];
							$href = "profile.php?tab=viewNetwork&joinN=$netID" ?>
							
							<div style="border-bottom:1px dotted;width:525px">
								<div style='float:left; width:400px'>
									<b><?php echo $networkName ?></b>
									<p><?php echo $networkDescription ?></p>
								</div>
								<div>
									<form method="post" action="<?php echo $href ?>" name="joinN" id="joinN">
										<input type="image"  src="images/joinnetwork.png" name="joinN" width="104" height="23" />
									</form>
								</div>
							</div>
							
							<?php 
						}
						echo "<br>";
						?>
						<form method="post" action="profile.php?tab=addNetwork" name="registerform"
						id="registerform">
						<input type="image" src="images/addnetwork.png" name="addNetwork" width="103" height="23" />
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
								die("A network with that name already exists. Please try again.");
							}
						} else { ?>
							<form method="post" action="profile.php?tab=editProfile" name="registerform" id="registerform">
							<input type="submit" name="edit" id="edit" value="Add Network" />
							</form>
							<p>You did not fill in all fields.</p>
						<?php 	
						}
	 				}
	 				elseif ($tab == "editTrain") {
	 					$trainID = $_GET['trainID'];
	 					if(empty($trainID)) die("No train ID specified");
	 					$trainID = intval($trainID);
	 					if(!empty($_POST['train_name']) && !empty($_POST['meeting_time_hr']) && !empty($_POST['meeting_time_min']) && !empty($_POST['meeting_place']) && !empty($_POST['seat_available']) && !empty($_POST['network']) && !empty($_POST['meeting_date_Month_ID']) ) {
							$trainName = mysql_real_escape_string($_POST['train_name']);
							$meetingTimeHr = intval(mysql_real_escape_string($_POST['meeting_time_hr']));
							$meetingTimeMin = intval(mysql_real_escape_string($_POST['meeting_time_min']));
							$meetingTimeAmpm = mysql_real_escape_string($_POST['ampm']);
							$meetingPlace = mysql_real_escape_string($_POST['meeting_place']);
							$seatAvailable = intval(mysql_real_escape_string($_POST['seat_available']));
							$transportationType = mysql_real_escape_string($_POST['transportation_type']);
							$trainDescription = mysql_real_escape_string($_POST['train_description']);
							$networkName = mysql_real_escape_string($_POST['network']);
							$meetingTimeMonth = mysql_real_escape_string($_POST['meeting_date_Month_ID']);
							$meetingTimeDay = mysql_real_escape_string($_POST['meeting_date_Day_ID']);
							$meetingTimeYear = mysql_real_escape_string($_POST['meeting_date_Year_ID']);
							
							if ($meetingTimeHr > 12 || $meetingTimeHr < 1) {
								die("Invalid hour inputted");
							}
							if ($meetingTimeMin > 59 || $meetingTimeMin < 0) {
								die("Invalid minute inputted");
							}
							$meetingTimeHr = date("H", strtotime($meetingTimeHr.' '.$meetingTimeAmpm));
							$mysqldate = date('Y-m-d H:i:s', mktime($meetingTimeHr, $meetingTimeMin, 0, $meetingTimeMonth+1, $meetingTimeDay, $meetingTimeYear));
							if(strtotime($mysqldate) < strtotime('now')) {
								print "<p> mysqlTime: ". strtotime($mysqldate) ."</p>";
								print "<p> currTime: ". strtotime('now') ."</p>";
								die("Our trains cannot travel through time and space. Please plan for a date in the future.");
							}
							$trainquery = mysql_query("UPDATE trains SET spaceAvailable='".$seatAvailable."', transportType='".$transportationType."', trainDescription='".$trainDescription."', meetingPlace='".$meetingPlace."', departureDateTime='".$mysqldate."', trainName='".$trainName."' WHERE trainid='".$trainID."'");

							if($trainquery)
							{
								echo "<h1>Train $trainName successfully edited.</h1>";
								echo "<p>We are now redirecting you to your profile page.</p>";
						       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
							} else {
								$message  = 'Invalid query: '.mysql_error($trainquery)."\n";
								die($message);
							}
						}
						else {
							$trainInfoQuery = mysql_query("SELECT * FROM trains WHERE trainid='".$trainID."'");
							if(!$trainInfoQuery) {
								$message  = 'Invalid query: '.mysql_error($trainquery)."\n";
								die($message);
							}
							if(mysql_num_rows($trainInfoQuery) == 1) {
								$trainInfo = mysql_fetch_assoc($trainInfoQuery);
							} else {
								die("Invalid train ID given.");
							}
							 ?>
							 <h2>Edit Train</h2>
							 <p>Please enter your details below to edit the train.</p>
				
							 <form method="post" onsubmit="return validateAddTrain();" action="profile.php?tab=editTrain&trainID=<?php echo $trainID?>" name="addTrain" id="addTrain" >
								<fieldset>
									<label for="train_name">Train Name:</label>
									<input type="text" name="train_name" id="train_name" value="<?php echo $trainInfo['trainName']?>" /><br /> 
									<label for="meeting_time">Meeting Time:</label>
									<script>DateInput("meeting_date", true, "YYYY-MM-DD")</script>
									<label for="meeting_time_hr"></label>
									<input style="margin-left:175px" type="text" name="meeting_time_hr" maxlength="2" size="4" id="meeting_time" />
									:
									<input type="text" name="meeting_time_min" maxlength="2" size="4" id="meeting_time" />
									<select name="ampm" id="meeting_time">
										<option value="am">am</option>
										<option value="pm">pm</option>
									</select>
									<br /> 
									<label for="transportation_type">Transportation Type:</label>
									<select name="transportation_type" >
										<option value="Driving"<?php echo($trainInfo['transportType'] == 'Driving'?' selected="selected"':null) ?>>Driving</option>
										<option value="Walking"<?php echo($trainInfo['transportType'] == 'Walking'?' selected="selected"':null) ?>>Walking</option>
										<option value="Biking"<?php echo($trainInfo['transportType'] == 'Biking'?' selected="selected"':null) ?>>Biking</option>
										<option value="Public"<?php echo($trainInfo['transportType'] == 'Public'?' selected="selected"':null) ?>>Public Transportation</option>
										<option value="Other"<?php echo($trainInfo['transportType'] == 'Other'?' selected="selected"':null) ?>>Other</option>
									</select><br />
									</script>
									<label for="meeting_place">Meeting Place:</label>
									<input type="text" name="meeting_place" id="meeting_place" value="<?php echo $trainInfo['meetingPlace']?>" /><br />
									<label for="seat_available">Spots Available:</label>
									<input type="text" name="seat_available" id="seat_available" value="<?php echo $trainInfo['spaceAvailable']?>"/><br /> 
									<label for="train_description">Train Description:</label>
									<textarea rows="6" cols = "50" name="train_description" id="train_description"><?php echo $trainInfo['trainDescription']?></textarea>
									<br /> 
									<label for="network">Network:</label>
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
									</select><br />
									<input type="submit" name="add" id="add" value="Edit Train" />
								</fieldset>
							</form>
					</div>
					<?php 
						}
	 				}
	 				elseif ($tab == "addTrain") {
	 					if(!empty($_POST['train_name']) && !empty($_POST['meeting_time_hr']) && !empty($_POST['meeting_time_min']) && !empty($_POST['meeting_place']) && !empty($_POST['seat_available']) && !empty($_POST['network']) && !empty($_POST['meeting_date_Month_ID']) ) {
							$trainName = mysql_real_escape_string($_POST['train_name']);
							$meetingTimeHr = intval(mysql_real_escape_string($_POST['meeting_time_hr']));
							$meetingTimeMin = intval(mysql_real_escape_string($_POST['meeting_time_min']));
							$meetingTimeAmpm = mysql_real_escape_string($_POST['ampm']);
							$meetingPlace = mysql_real_escape_string($_POST['meeting_place']);
							$seatAvailable = intval(mysql_real_escape_string($_POST['seat_available']));
							$transportationType = mysql_real_escape_string($_POST['transportation_type']);
							$trainDescription = mysql_real_escape_string($_POST['train_description']);
							$networkName = mysql_real_escape_string($_POST['network']);
							$meetingTimeMonth = mysql_real_escape_string($_POST['meeting_date_Month_ID']);
							$meetingTimeDay = mysql_real_escape_string($_POST['meeting_date_Day_ID']);
							$meetingTimeYear = mysql_real_escape_string($_POST['meeting_date_Year_ID']);
							
							if ($meetingTimeHr > 12 || $meetingTimeHr < 1) {
								die("Invalid hour inputted");
							}
							if ($meetingTimeMin > 59 || $meetingTimeMin < 0) {
								die("Invalid minute inputted");
							}
							$meetingTimeHr = date("H", strtotime($meetingTimeHr.' '.$meetingTimeAmpm));
							$mysqldate = date('Y-m-d H:i:s', mktime($meetingTimeHr, $meetingTimeMin, 0, $meetingTimeMonth+1, $meetingTimeDay, $meetingTimeYear));
							if(strtotime($mysqldate) < strtotime('now')) {
								print "<p> mysqlTime: ". strtotime($mysqldate) ."</p>";
								print "<p> currTime: ". strtotime('now') ."</p>";
								die("Our trains cannot travel through time and space. Please plan for a date in the future.");
							}
							$trainquery = mysql_query("INSERT INTO trains (spaceAvailable, transportType, trainDescription, 
													  meetingPlace, departureDateTime, trainName) 
													  VALUES('".$seatAvailable."', '".$transportationType."', '".$trainDescription."', '".$meetingPlace."', '".$mysqldate."', '".$trainName."')");

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
							} else {
								$message  = 'Invalid query: '.mysql_error($trainquery)."\n";
								die($message);
							}
						}
						else {
							 ?>
							 <h2>Add Train</h2>
							 <p>Please enter your details below to add a train.</p>
				
							 <form method="post" onsubmit="return validateAddTrain();" action="profile.php?tab=addTrain" name="addTrain" id="addTrain" >
								<fieldset>
									<label for="train_name">Train Name:</label>
									<input type="text" name="train_name" id="train_name" /><br /> 
									<label for="meeting_time">Meeting Time:</label>
									<script>DateInput("meeting_date", true, "YYYY-MM-DD")</script>
									<label for="meeting_time_hr"></label>
									<input style="margin-left:175px" type="text" name="meeting_time_hr" maxlength="2" size="4" id="meeting_time" />
									:
									<input type="text" name="meeting_time_min" maxlength="2" size="4" id="meeting_time" />
									<select name="ampm" id="meeting_time">
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
									</script>
									<label for="meeting_place">Meeting Place:</label>
									<input type="text" name="meeting_place" id="meeting_place" /><br />
									<label for="seat_available">Spots Available:</label>
									<input type="text" name="seat_available" id="seat_available" /><br /> 
									<label for="train_description">Train Description:</label>
									<textarea rows="6" cols = "50" name="train_description" id="train_description"></textarea>
									<br /> 
									<label for="network">Network:</label>
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



