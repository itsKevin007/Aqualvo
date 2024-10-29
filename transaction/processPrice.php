<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];
	$oid = $_POST['oid'];
	$price = $_POST['price'];
	$emptys = $_POST['emptys'];

	$ch = $conn->prepare("SELECT * FROM tr_transaction_detail WHERE trd_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$name = $ch_data['trd_id'];			
	
		/* Update Order Status */
		$sql = $conn->prepare("UPDATE tr_transaction_detail SET price = '$price', emptys = '$emptys'
					WHERE trd_id = $id");
		$sql->execute();
		/* End Order */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Transaction price updated', '$name', 'transaction', '$userId', NOW())");
		$log->execute();
		/* End Log */

		header('Location: index.php?error=' . urlencode('Saved successfully'));
		header("Location: index.php?view=detail&oid=$oid&error=Saved successfully");

?>