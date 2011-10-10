<?php include "base.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">  
<head>  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>User Management System (Tom Cameron for NetTuts)</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>  
<body>  
<div id="body">
<div id="container">
<?php
ob_start();
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Email']))
{
	 ?>
    <h1>LunchTrain works</h1>
  	<p>Thanks for logging in! You are <b><?=$_SESSION['firstName']?></b> <b><?=$_SESSION['lastName']?></b>. Your email address is <b><?=$_SESSION['Email']?></b>.</p>
    
    <ul>
        <li><a href="logout.php">Logout.</a></li>
    </ul>
    <?php
}
elseif(!empty($_POST['email']) && !empty($_POST['password']))
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
                //echo "<meta http-equiv="refresh" content='=2;index.php' />";
        
        $_SESSION['firstName'] = $firstname;
        $_SESSION['lastName'] = $lastname;
        $_SESSION['Email'] = $emailResult;
        $_SESSION['LoggedIn'] = 1;
    	echo "<h1>Success</h1>";
        echo "<p>We are now redirecting you to the member area.</p>";
       	
        header("Location: /index.php");
        exit;
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