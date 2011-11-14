<?php include "base.php"; ?>
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
if(!empty($_GET['user']) && !empty($_GET['hash'])) {
	$userID = mysql_real_escape_string($_GET['user']);
	$hashKey = mysql_real_escape_string($_GET['hash']);
	$checkHash = mysql_query("SELECT * FROM validation WHERE userid = '".$userID."' AND hash = '".$hashKey."'");
	if(mysql_num_rows($checkHash) == 1) {
		//Validation successful. Log in user and remove this user from the validation table
		$remove = mysql_query("DELETE FROM validation WHERE userid = '".$userID."' AND hash = '".$hashKey."'");
		if(!$remove) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			die($message);
		}
		echo "<h1>Success</h1>";
        echo "<p>Your account was successfully validated. Referring you to the login page.</p>";
        echo "<meta http-equiv='refresh' content='1.5;index.php' />";
	} else {
		echo "<h1>Error</h1>";
        echo "<p>Invalid confirmation key $hashKey or user ID $userID. Please try again.</p>";
	}
} else {
	echo "<meta http-equiv='refresh' content='0;profile.php' />";
}
?>
</div>
</body>