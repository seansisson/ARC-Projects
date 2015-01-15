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

	// Match username between XML tag <cas:user>
	$pattern = '#\<cas:user\>(.*?)\</cas:user\>#';
	preg_match($pattern, $page, $match);	
	$_SESSION['username'] = $match[1];
	print_r($page);

	// Redirect to admin.php
	//header('Location: admin.php');
?>
