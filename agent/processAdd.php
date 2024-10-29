<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
		
	$cname = mysqli_real_escape_string($link, $_POST['cname']);
	$address = mysqli_real_escape_string($link, $_POST['address']);
	$cp = mysqli_real_escape_string($link, $_POST['cp']);
	$cn = mysqli_real_escape_string($link, $_POST['cn']);
	
	
	
					
		/* Insert Customer */
		$sql = $conn->prepare("INSERT INTO bs_customer (client_name, address, contact_person, contactno, date_added)
					VALUES ('$cname', '$address', '$cp', '$cn', NOW())");
		$sql->execute();
		/* End Customer */
	
		// get the order id
		$cId = $conn->lastInsertId();
		$inv = $conn->prepare("INSERT INTO tr_inventory (cust_id, date_added)
					VALUES ('$cId', NOW())");
		$inv->execute();
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Customer added', '$cname', 'customer', '$userId', NOW())");
		$log->execute();
		/* End Log */

	header('Location: ../index.php');
		
				

?>