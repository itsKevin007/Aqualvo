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
		
	case 'add_material' :
		$content 	= 'add_material.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'add_salt' :
		$content 	= 'add_salt.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'add_dispenser' :
		$content 	= 'add_dispenser.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
		
	case 'add_filter' :
		$content 	= 'add_filter.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
	
	case 'modify_material' :
			$content 	= 'modify_material.php';
			$pageTitle 	= $sett_data['system_title'];
			break;
			
	case 'modify_salt' :
			$content 	= 'modify_salt.php';
			$pageTitle 	= $sett_data['system_title'];
			break;
			
	case 'modify_dispenser' :
			$content 	= 'modify_dispenser.php';
			$pageTitle 	= $sett_data['system_title'];
			break;
			
	case 'modify_filter' :
			$content 	= 'modify_filter.php';
			$pageTitle 	= $sett_data['system_title'];
			break;

	case 'modify_material' :
		  $content 	= 'modify_material.php';
		  $pageTitle 	= $sett_data['system_title'];
		   break;
		
	default :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
}

$script    = array('inventory.js');

require_once '../include/template.php';
	
?>