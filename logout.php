<?php include "base.php"; $_SESSION = array(); session_destroy();
	setcookie("userID", "", time()-3600);
    setCookie("LoggedIn", 0, time()-3600); ?>
<meta http-equiv="refresh" content="0;index.php">