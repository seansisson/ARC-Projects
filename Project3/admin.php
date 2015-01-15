<?php
	session_start();
	echo 'Welcome, ' . $_SESSION['username'];
	session_unset();
	session_destroy();
?>
