<?php

// Project 6
// storedata.php

	$servername = "localhost";
	$username = "root";
	$password = "vagrant";
	$dbname = "forms";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Prepare to bind statements
	$stmt = $conn->prepare("INSERT INTO email (name,email,message) VALUES (?,?,?)");	
	$stmt->bind_param('sss',$_POST['name'],$_POST['email'],$_POST['message']);

	// Set parameters and execute
	$stmt->execute();

	printf("%d Row inserted.\n", $stmt->affected_rows);

	$stmt->close();
	$conn->close(); 
?>
