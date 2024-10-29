<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	

switch ($view) {
	case 'list' :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'add' :
		$content 	= 'add.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'modify' :
		$content 	= 'modify.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
	
	case 'profile' :
		$content 	= 'profile.php';
		$pageTitle 	= $sett_data['system_title'];
		break;

	case 'add_payment' :
		$content 	= 'add_payment.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
	
	case 'view_payment' :
		$content 	= 'view_payment.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'modify_payment' :
		$content 	= 'modify_payment.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
	
	default :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
}

$script    = array('customer.js');

require_once '../include/template.php';
	
?>