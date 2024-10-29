<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];

	if (isset($_GET['oid']) && (int)$_GET['oid'] > 0) {
		$id = (int)$_GET['oid'];
	} else {
		header('Location: index.php');
	}

	$ch = $conn->prepare("SELECT * FROM tr_transaction WHERE tr_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['tr_id'];			
	
		/* Update Order Status */
		$sql = $conn->prepare("UPDATE tr_transaction SET is_deleted = '1', deleted_by = '$userId', date_deleted = NOW()
					WHERE tr_id = $id");
		$sql->execute();
		/* End Order */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Transaction deleted', '$name', 'transaction', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Deleted successfully'));

?>