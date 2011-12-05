<?php include "base.php";
	include("Mobile_Detect.php");
	$detect = new Mobile_Detect(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>  
<div id="main">
<?php 
	if (True) {
    	// any mobile platform
    	if(!empty($_GET['userid'])) {
    		$userID = $_GET['userid'];
    		$getUpdate = mysql_query("SELECT * FROM train_invite WHERE destid = '".$userID."'");
    		$jsonRow = array();
    		if(mysql_num_rows($getUpdate) >= 1) {
    			//create JSON Object
    			while ($row = mysql_fetch_assoc($getUpdate)) {
    				$jsonRow[] = array( 
    					'notification' => '1',
    					'notificationType' => 'TrainInvite',
    					'inviteSource' => $row['sourceid'],
    					'inviteTrain' => $row['trainid']);
    			}
    		} else {
    			$jsonRow[] = array('notification' => '0');
    		}
    		echo json_encode($jsonRow);
    	} else {
    		//Do something if userID not given. 
    	}
	} else {
		echo "<meta http-equiv='refresh' content='0;index.php' />";
	}
?>
</div>
</body>