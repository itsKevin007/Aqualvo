<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	if (isset($_GET['oid']) && (int)$_GET['oid'] > 0) {
		$id = (int)$_GET['oid'];
	} else {
		header('Location: index.php');
	}

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$ch = $conn->prepare("SELECT * FROM tr_transaction_detail WHERE trd_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$trId = $ch_data['tr_id'];
	
		/* Update Order Status */
		$sql = $conn->prepare("UPDATE tr_transaction_detail SET is_deleted = '1', deleted_by = '$userId', date_deleted = '$today_date1'
					WHERE trd_id = $id");
		$sql->execute();
		/* End Order */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Order Item deleted', '$id', 'order item', '$userId', NOW())");
		$log->execute();
		/* End Log */

		
		header("Location: index.php?view=detail&oid=$trId&error=Deleted successfully");

?>