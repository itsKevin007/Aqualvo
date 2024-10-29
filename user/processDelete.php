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

	$ch = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['firstname'] . '&nbsp;' . $ch_data['lastname'];			
	
		/* Update user Status */
		$sql = $conn->prepare("UPDATE bs_user SET is_deleted = '1'
					WHERE user_id = $id");
		$sql->execute();
		/* End User */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('User deleted', '$name', 'user', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Deleted successfully'));

?>