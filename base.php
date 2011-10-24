<?php
ob_start();
session_start();
$dbhost = '127.0.0.1'; // this will ususally be 'localhost', but can sometimes differ
$dbname = 'lunchtrain'; // the name of the database that you are going to use for this project
$dbuser = 'ahuang'; // the username that you created, or were given, to access your database
$dbpass = 'password'; // the password that you created, or were given, to access your database
mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Connection Error: " . mysql_error());
mysql_select_db($dbname) or die("MySQL Database Error: " . mysql_error());
?>