<?php

defined('AJXP_EXEC') or die( 'Access not allowed');

/****************************
 * HOSTDEPLOY ACCESS TEST
 ***************************/
if (isset($_GET['hostdeploy-key'])) {
	unset($_SESSION['hd_user']);

	$key = $_GET['hostdeploy-key'];
	$key = base64_decode(strtr($key, '-_', '+/'));
	list($user, $time, $key) = explode(':', $key, 3);

	// Only allow usage within 30 seconds
	if (abs($time-time()) < 30) {
  	// Hard-coded public key for hostdeploy
		$public = '-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDkW80PWHQXkrf6+LGHU+fiAnCg
NQ2TUQonJOuVSh+eXi5euUWe8o5nagQxqCO7EmN+NnlG9R4Rmi7YymslvZl04oa5
OUAO6Ld8JT12TPfAnI+23bBkLb4Idft7qySVFqVWoiNObLC6xaZKlTgQ3NGlmneP
GHuDRkSSrbl4n0yAZwIDAQAB
-----END PUBLIC KEY-----';

		$result = openssl_verify("$user:$time", $key, $public);
		if ($result === 1) {
			$_SESSION['hd_user'] = $user;
		}else{
			throw new Exception("Unexpected result from openssl_verify: ".$result);
		}
	}
}

// HostDeploy: Get current username
$details = posix_getpwuid(posix_geteuid());
$username = $details['name'];

// Check we've got a session for this user
if (!isset($_SESSION['hd_user']) || $_SESSION['hd_user'] != $username) {
  die('Could not access file manager. Please try login again.');
}
