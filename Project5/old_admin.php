<?php
	session_start();

	// Retrieve & sanitize username
	$sn = $_SESSION['username'];
	$escape_chars = array("\\", "*", "(", ")", "\0");
	$sanitized_sn = str_replace($escape_chars, "", $sn);

	// Connect to the OIT LDAP server
	$connection = ldap_connect('ldap-login.oit.pdx.edu');
	$dn = "dc=pdx,dc=edu";
	$filter = "(& (| (cn=arc) (cn=arcstaff)) (memberUid=$sanitized_sn) (objectclass=posixGroup))";

	// Search LDAP for entries regarding users in groups arc and arcstaff; displays them to the screen
	$search = ldap_search($connection, $dn, $filter);
	$results = ldap_get_entries($connection, $search);
	print_r($results['count']);

	// 
	

	// session_unset();
	// session_destroy();
?>
