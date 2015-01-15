<?php
// Project 6
// Sean Sisson
// OIT-ARC
// January 8th, 2015


$error = array(
	"name" => "",
	"email" => "",
	"message" => ""
);

$escaped_field = array(
	"name" => "",
	"email" => "",
	"message" => ""
);

// Check to see if fields are empty or invalid
if(!empty($_POST)){

	// Escape and populate user input fields
	$escaped_field['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES);
	$escaped_field['email'] = htmlspecialchars($_POST['email'], ENT_QUOTES);
	$escaped_field['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);

	// Verify name validity
	if(empty($_POST["name"]))
		$error["name"] = "Please enter a name!";
	else
		$name_isvalid = $_POST["name"];

	// Verify email validity
	if(empty($_POST["email"]))
		$error["email"] = "Please enter an email!";
	elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
		$error["email"] = "Email field is not valid!";
	else
		$email_isvalid = $_POST["email"];

	// Verify message validity
	if(empty($_POST["message"]))
		$error["message"] = "Please enter a message!";
	else
		$message_isvalid = $_POST["message"];

	// Once messages are valid
	if(!empty($name_isvalid) && !empty($email_isvalid) && !empty($message_isvalid)) {

		// Create and check MySQL DB connection
		$conn = new mysqli("localhost", "root", "vagrant", "forms");
		if ($conn->connect_error)
			die("Connection failed: " . $conn->connect_error);

		// Prepare to bind statements, sanitize, execute
		$stmt = $conn->prepare("INSERT INTO email (name,email,message) VALUES (?,?,?)");	
		$stmt->bind_param('sss', $name_isvalid, $email_isvalid, $message_isvalid);
		$stmt->execute();

		// Close connections, return to dash
		$stmt->close();
		$conn->close();
		header("Location: dash.php");
		exit(0);
	}
}
?>


<!-- BEGIN HTML -->
<html>
<body>
	<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">

		<b>Name:</b>  
		<small class="errorText"><?php echo $error["name"]; ?></small><br> 
		<input name="name" type="text" value='<?php echo $escaped_field['name']; ?>'><br>

		<b>Email:</b>  
		<small class="errorText"><?php echo $error["email"]; ?></small><br>
		<input name="email" type="text" value="<?php echo $escaped_field['email']; ?>"><br>

		<b>Message:</b>  
		<small class="errorText"><?php echo $error["message"]; ?></small><br>
		<textarea name="message" value="" rows="15" cols="40"><?php echo $escaped_field['message']; ?></textarea><br>

		<input type="submit" name="submit" value="Send">
	</form>
	<a href="dash.php">Return to dashboard</a>
</body>	
</html>
