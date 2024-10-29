<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	# Get setting details
	$sett = "SELECT * FROM bs_setting";
	$rs_sett = dbQuery($sett);
	$rw_sett = dbFetchAssoc($rs_sett);
	extract($rw_sett);

switch ($view) {
	case 'list' :
		$content 	= 'list.php';
		$pageTitle 	= $system_title;
		break;			
	
	default :
		$content 	= 'list.php';
		$pageTitle 	= $system_title;
}

$script    = array('inventory.js');

require_once '../include/template.php';
	
?>