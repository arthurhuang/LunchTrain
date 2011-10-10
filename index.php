<?php include "base.php";
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
        
        $_SESSION['firstName'] = $firstname;
        $_SESSION['lastName'] = $lastname;
        $_SESSION['Email'] = $emailResult;
        $_SESSION['LoggedIn'] = 1;
    	echo "<h1>Login successful.</h1>";
        echo "<p>We are now redirecting you to your profile page.</p>";
       	echo "<meta http-equiv='refresh' content='1.5;profile.php' />";
    }
    else
    {
    	echo "<h1>Error</h1>";
        echo "<p>Sorry, your account could not be found. Please <a href=\"index.php\">click here to try again</a>.</p>";
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
				<label for="email">Email:</label><input type="text" name="email" id="email" /><br />
				<label for="password">Password:</label><input type="password" name="password" id="password" /><br />
				<input type="submit" name="login" id="login" value="Login" />
				<a href="register.php">Register</a>
			</fieldset>
		</form>
		</div>

		<div id="contentbottom">
		</div>
	</div>
   <?php
}
?>
</div>
</div>
</body>
</html>
