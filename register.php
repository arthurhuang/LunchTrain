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
if(!empty($_POST['email']) && !empty($_POST['password']))
{
	$email = mysql_real_escape_string($_POST['email']);
    $password = md5(mysql_real_escape_string($_POST['password']));
    $firstName = mysql_real_escape_string($_POST['firstName']);
    $lastName = mysql_real_escape_string($_POST['lastName']);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<h1>Error</h1>";
        echo "<p>Sorry, you gave an invalid email address. Please <a href=\"register.php\">try again</a>.</p>";  
        exit;
	}
	$checkusername = mysql_query("SELECT * FROM users WHERE email = '".$email."'");
     
     if(mysql_num_rows($checkusername) == 1)
     {
     	echo "<h1>Error</h1>";
        echo "<p>Sorry, that email is already in use. Please go back and try again.</p>";
     }
     else
     {
     	$registerquery = mysql_query("INSERT INTO users (email, password, firstname, lastname) VALUES('".$email."', '".$password."', '".$firstName."', '".$lastName."')");
        if($registerquery)
        {
        	$userIDQuery = mysql_query("SELECT userid FROM users WHERE email = '".$email."'");
        	$row = mysql_fetch_array($userIDQuery);
        	$userID = $row['userid'];
        	$allNetworkID = 1;
        	
        	$addToAllNetworkQuery = mysql_query("INSERT INTO user_in_net VALUES ('".$userID."', '".$allNetworkID."')");
        	if (!$addToAllNetworkQuery) {
							$message  = 'Invalid query: ' . mysql_error() . "\n";
							die($message);
			}
        	if($addToAllNetworkQuery) {
        		# Send confirmation email
        		$headers = "From: noreply@lunchtrain.com\r\n" . "X-Mailer: php";
        		$confirmLink = "";
        		mail($email, "Confirmation email from LunchTrain", "Hi $firstName $lastName, this is the LunchTrain team. Please click $confirmLink to finish your registration.", $headers);
        		echo "<h1>Success</h1>";
        		echo "<p>Your account was successfully created. Referring you to the login page.</p>";
        		echo "<meta http-equiv='refresh' content='1.0;index.php' />";
        	} else {
        		echo $userID;
        		echo $allNetworkID;
        		echo "<h1>Something went wrong</h1>";
        		echo "<p>Please <a href=\"index.php\">click here to try again</a>.</p>";
        	}
        }
        else
        {
     		echo "<h1>Error</h1>";
        	echo "<p>Sorry, your registration failed. Please go back and try again.</p>";    
        }    	
     }
}
else
{
	?>
    
   <h1>Register</h1>
    
   <p>Please enter your details below to register.</p>
    
	<form method="post" action="register.php" name="registerform" id="registerform">
	<fieldset>
		<label for="Firstname">First name:</label><input type="text" name="firstName" id="firstName" /><br />
		<label for="Lastname">Last name:</label><input type="text" name="lastName" id="lastName" /><br />
		<label for="email">Email:</label><input type="text" name="email" id="email" /><br />
		<label for="password">Password:</label><input type="password" name="password" id="password" /><br />
		<input type="submit" name="register" id="register" value="Register" />
	</fieldset>
	</form>
    
   <?php
}
?>
</div>
</body>
</html>