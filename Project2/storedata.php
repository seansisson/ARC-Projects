<?php

// Project 2
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
	$stmt = $conn->prepare("INSERT INTO email VALUES (?,?,?)");
	$stmt->bind_param("sss",$name,$email,$message);

	// Set parameters and execute
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$stmt->execute();
	
	$stmt->close();
	$conn->close();
?>
