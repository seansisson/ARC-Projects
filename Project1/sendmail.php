<?php
	// Gets the values submitted via POST from feedback.html
	$name = $_POST['name'];
	$visitor_email = $_POST['email'];
	$message = $_POST['message'];

	// Validate
	if(empty($name)||empty($visitor_email))
	{
		echo "name and email are mandatory!";
		exit;
	}

	// Uses the above variables to compose an email
	$email_from = $_POST['email']
	$email_subject = "New Form Submission";
	$email_body = "You have recieved a new message from $name.\n".
			"Here is the message:\n\t$message \n".

	// Sends the email to the specified user via the mail(); method
	$to = "sisson@pdx.edu, $visitor_email";
	$headers = "From: $email_from \r\n";
	mail($to,$email_subject,$email_body, $headers);
	header('Location: thanks.html');

?>
