<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>User Management System (Tom Cameron for NetTuts)</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="main">
<?php
if(!empty($_POST['train_name']))
{
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
		echo "<h1>Success</h1>";
		echo "<p>Your train was successfully created. Please <a href=\"index.php\">click here to go back to profile</a>.</p>";
	}
 
}
else
{
	?>
    
   <h1>FAIL</h1>
    
   
    
   <?php
}
?>
</div>
</body>
</html>