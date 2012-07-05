<?php
	session_start();
	if(isset($_COOKIE['remember']))
		setcookie("remember", "", 1, '/');
	unset($_SESSION['uid']);
?>
