<?php
	session_start();

	// Fields for obtaining CAS auth
	$vhost_url = "http://10.0.0.10/login.php";
	$cas_url = "https://sso.pdx.edu/cas/proxyValidate?ticket=" . $_GET['ticket'] . "&service=" . urlencode($vhost_url);

	// Set URL to scrape
	$ch = curl_init($cas_url);

	// Execute curl retrieval, return page as a string, exit
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$page = curl_exec($ch);

	if(curl_errno($ch)) // Check for exec errrors
	{
		echo 'Scraper error: ' . curl_error($ch);
		exit;
	}
	curl_close($ch);

	// Array contains all CAS user information about the authenticated user
	$patterns = array('#\<cas:user\>(.*?)\</cas:user\>#', '#\<cas:DISPLAY_NAME\>(.*?)\</cas:DISPLAY_NAME\>#', '#\<cas:UDC_IDENTIFIER\>(.*?)\</cas:UDC_IDENTIFIER\>#', '#\<cas:GIVEN_NAME\>(.*?)\</cas:GIVEN_NAME\>#', '#\<cas:PSUUID\>(.*?)\</cas:PSUUID\>#', '#\<cas:UID\>(.*?)\</cas:UID\>#', '#\<cas:SN\>(.*?)\</cas:SN\>#', '#\<cas:MAIL\>(.*?)\</cas:MAIL\>#', '#\<cas:EDU_PERSON_AFFILIATIONS\>(.*?)\</cas:EDU_PERSON_AFFILIATIONS\>#');
	$auth_data = array();

	// Begin parsing for CAS user attributes & store them in $auth_data
	for ($i = 0, $size = count($patterns); $i < $size; ++$i) {
		preg_match($patterns[$i], $page, $match);
		if ($i == 0)
			$_SESSION['username'] = $match[1];
		$auth_data[$i] = $match[1];
	}
?>

<html>
	<body>
		<h1>
			CAS User Database
		</h1>
	</body>
	<table border="1" style="width:100%">
		<td><?php echo $auth_data[0]; ?></td>
		<td><?php echo $auth_data[1]; ?></td>
		<td><?php echo $auth_data[2]; ?></td>
		<td><?php echo $auth_data[3]; ?></td>
		<td><?php echo $auth_data[4]; ?></td>
		<td><?php echo $auth_data[5]; ?></td>
		<td><?php echo $auth_data[6]; ?></td>
		<td><?php echo $auth_data[7]; ?></td>
		<td><?php echo $auth_data[8]; ?></td>
	</table>
</html>
