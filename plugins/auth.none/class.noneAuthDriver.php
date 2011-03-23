<?php
defined('AJXP_EXEC') or die( 'Access not allowed');

require_once(INSTALL_PATH."/server/classes/class.AbstractAuthDriver.php");
class noneAuthDriver extends AbstractAuthDriver {
	
	var $usersSerFile;
	var $driverName = "none";
	
	function performChecks(){}
	
	function listUsers(){ return array(); }
	function userExists($login){ return False; }
	function checkPassword($login, $pass, $seed){ return False; }
	function usersEditable(){ return False; }
	function passwordsEditable(){ return False; }
	function getUserPass($login){ return false; }
}
?>
