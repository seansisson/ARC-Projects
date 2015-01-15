<?php
	// Project 6
	// login.php
	// Login method for home.php
	// session variable is set here,
	// authenticating with CAS

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
			$username = $match[1];
		$auth_data[$i] = $match[1];
	}

	// Retrieve & sanitize username
	$sn = $username;
	$escape_chars = array("\\","*","(",")","\0");
	$sanitized_sn = str_replace($escape_chars, "", $sn);

	// Connect to the OIT LDAP server
	$connection = ldap_connect('ldap-login.oit.pdx.edu');
	$dn = "dc=pdx,dc=edu";
	$filter = "(& (| (cn=arc) (cn=arcstaff)) (memberUid=$sanitized_sn) (objectclass=posixGroup))";

	// User validation lookup
	$search = ldap_search($connection, $dn, $filter);
	$results = ldap_get_entries($connection, $search);

	// Check if user is in arc or arcstaff group, authorize or deny access to admin.php
	if ($results['count'] > 0)
		$_SESSION['username'] = $username;
		header("Location: dash.php");
	else
		echo "You are not authorized to proceed";
	exit;
?>
