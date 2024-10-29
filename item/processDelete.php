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

	$ch = $conn->prepare("SELECT * FROM bs_item WHERE item_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['name'];			
	
		/* Update Data Status */
		$sql = $conn->prepare("UPDATE bs_item SET is_deleted = '1', date_deleted = NOW()
					WHERE item_id = $id");
		$sql->execute();
		/* End Data */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Item deleted', '$name', 'item', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Deleted successfully'));

?>