<!-- Project 6 -->
<!-- dash.php  -->
<?php
	// Project 6
	// dash.php
	// Dashboard for Project 6

	session_start();
	if(!isset($_SESSION['username'])){
		exit("go away");
	}
?>

<html>
	<body>
		<h1>
			Project 6 Dashboard
		</h1>
		<br>
		<a href="http://10.0.0.10/feedback.php">INSERT TABLES</a>
		<br>
		<a href="http://10.0.0.10/admin.php">VIEW / DELETE TABLES</a>
	</body>
</html>
