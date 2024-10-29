<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

	$orderId = $_POST['id'];
	$from = $_POST['from'];
	$dr = $_POST['dr'];
	$or = $_POST['or'];
	$da = $_POST['da'];
	$bank = $_POST['bank'];
	$checkno = $_POST['checkno'];
	$status = $_POST['status'];
	
	$orderdate1 = date("Y-m-d h:i:s",strtotime($from));
	$orderdate2 = date("Y-m-d",strtotime($from));

	
		/* Update Order Status */
		$sql = $conn->prepare("UPDATE tr_transaction SET od_date = '$orderdate1', od_date_1 = '$orderdate2', cr = '$or', dr = '$dr', da = '$da',
					bank = '$bank', check_number = '$checkno', is_paid = '$status', modified_by = '$userId', date_modified = NOW()
						WHERE tr_id = $orderId");
		$sql->execute();
		/* End Order */
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Transaction modified', '$orderId', 'transaction', '$userId', NOW())");
		$log->execute();
		/* End Log */
		
		header("Location: index.php?view=detail&oid=$orderId&error=Modified successfully");

?>