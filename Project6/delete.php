<?php
	// Project 6
	// delete.php
	// Delete method for admin.php

	session_start();
    if(!isset($_SESSION['username'])){
    	exit("go away");
    }


	$conn = new mysqli("localhost", "root", "vagrant", "forms");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	
	$sql = "DELETE FROM email WHERE id=". $_REQUEST['id'];
	$conn->query($sql);	

	header("Location: admin.php");
?>
