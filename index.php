<?php include "base.php";
	ob_start();
	ini_set('session.bug_compat_warn', 0);
	ini_set('session.bug_compat_42', 0); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>LunchTrain</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<?php
if($_COOKIE['LoggedIn'] == 1 && $_COOKIE['userID'] != null) {
	echo "<meta http-equiv='refresh' content='0;profile.php' />";
}
if(!empty($_POST['email']) && !empty($_POST['password']))
{
	$email = mysql_real_escape_string($_POST['email']);
    $password = md5(mysql_real_escape_string($_POST['password']));   
	$checklogin = mysql_query("SELECT * FROM users WHERE email = '".$email."' AND password = '".$password."'");
    
    if(mysql_num_rows($checklogin) == 1)
    {
    	
    	$row = mysql_fetch_array($checklogin);
        $emailResult = $row['email'];
        $firstName = $row['firstname'];
        $lastName = $row['lastname'];
        $userid = $row['userid'];
        #Check validation
        #$checkValidation = myqsl_query("SELECT * FROM validation WHERE userid = '".$userid."'");
        
        #Set Session 
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['Email'] = $emailResult;
        $_SESSION['LoggedIn'] = 1;
        $_SESSION['userID'] = $userid;
        #Set Cookies
        setcookie("userID", $userid, time()+3600);
        setcookie("LoggedIn", 1, time()+3600);
    	echo "<h1>Login successful for $firstName $lastName.</h1>";
        echo "<p>We are now redirecting you to your profile page.</p>";
       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
    }
    else
    {
    	echo "<h1>Error</h1>";
        echo "<p>Sorry, either your account could not be found or you gave a wrong password. Please <a href=\"index.php\">click here to try again</a>.</p>";
    }
}
else
{
	?>
	<div id="body">
	<div id="container">
	<div id="title">
	</div>
	<div id="content">
		<div id="contenttop">
			<p> Collaborative lunch planning <p>
		</div>
		<div id="contentmiddle">
		<form method="post" action="index.php" name="loginform" id="loginform">
			<fieldset>
				<label for="email">Email:</label><input style='border:1px solid #ccc' type="text" name="email" id="email" /><br />
				<label for="password">Password:</label><input style='border:1px solid #ccc' type="password" name="password" id="password" /><br />
				<br />
				<input type="submit" style='border:1px solid #ccc' name="login" id="login" value="Login" /> 
				<a href="register.php">Register</a>
			</fieldset>
		</form>
		</div>

	
	</div>
   <?php
}
?>
</div>
</div>
</body>
</html>
