<?php

// Project 6

$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

if($name == ""){
	echo "Please enter a name\n";
} else {
	echo "Name field is valid\n";
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL && $email != "")) {
	echo "Email field is not valid\n";
} else if($email == "") {
	echo "Please enter an email\n";
} else {
	echo "Email field is valid\n";
}

if($message == "") {
	echo "Please enter a message\n";
} else {
	echo "Message field is valid\n";
}

?>
