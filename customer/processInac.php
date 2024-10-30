<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];

	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$id = (int)$_GET['id'];
	} else {
		header('Location: index.php');
	}

	$ch = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['client_name'];
	$is_act = $ch_data['is_active'];	

	if($is_act == 0){
		$stats = '1';
	}else{
		$stats = '0';
	}
	
		/* Update customer Status */
		$sql = $conn->prepare("UPDATE bs_customer SET is_active = '$stats'
					WHERE cust_id = $id");
		$sql->execute();
		/* End Customer */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Customer Modified Active/Inactive', '$name', 'customer', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Modified successfully'));

?>