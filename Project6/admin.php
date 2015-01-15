<?php
	// Project 6
	// admin.php
	// HTML Table to view & interact
	// with MySQL DB

	session_start();
    if(!isset($_SESSION['username'])){
    	exit("go away");
    }

	$conn = new mysqli("localhost", "root", "vagrant", "forms");
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Form SQL Query to show table rows
	$sql = "SELECT id, name, email, message FROM email";
	$result = $conn->query($sql);
?>


<html>
	<head>
	<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
	<script>

	$(document).ready(function(){
		$(".button").click(function(event){
			var id = event.target.id;
			var button = $(this);
			var table_cell = button.parent();
			var table_row = table_cell.parent();
					
			$.post("delete.php", {'id':id}, function(response){
			   table_row.remove();
			})
		});
	});

	</script> 
	</head>

	<body>

    <?php if ($result->num_rows > 0): ?>
		<table border="1" style="width:100%">
			<tr>
				<td><strong>Name</strong></td>
				<td><strong>Email</strong></td>
				<td><strong>Message</strong></td>
				<td></td>
			</tr>

            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["name"])?></td>
                    <td><?php echo htmlspecialchars($row["email"])?></td>
                    <td><?php echo htmlspecialchars($row["message"])?></td>
                    <td><button name="id" class="button" id="<?php echo $row["id"] ?>">Delete</button></td>
                </tr>
            <?php endwhile; ?>
		</table>
        <?php else: ?>
            0 results
        <?php endif; ?>
		<a href="dash.php">Return to dashboard</a>
	</body>	
</html>
