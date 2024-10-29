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
	
	$numb = (int)$_GET['nu'];

	$ch = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['client_name'];			
	
		/* Update customer Status */
		$sql = $conn->prepare("UPDATE tr_schedule SET is_deleted = '1'
					WHERE client_id = $id AND dt_num = '$numb'");
		$sql->execute();
		/* End Customer */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Customer deleted from schedule', '$name', 'customer schedule', '$userId', NOW())");
		$log->execute();
		/* End Log */

		//header('Location: index.php?error=' . urlencode('Deleted successfully'));
		header("Location: index.php?view=list&id=$numb&error=Deleted successfully");

?>