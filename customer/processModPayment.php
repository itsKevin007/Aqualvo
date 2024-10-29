<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];
	$soan = mysqli_real_escape_string($link, $_POST['soan']);
	$or = mysqli_real_escape_string($link, $_POST['or']);
	$amt = mysqli_real_escape_string($link, $_POST['amt']);
	$det = mysqli_real_escape_string($link, $_POST['det']);
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$datepaid = date("Y-m-d", strtotime($from));
	
			
			$subjSql = $conn->prepare("UPDATE tr_payment SET soa_number = '$soan', or_number = '$or', amount_paid = '$amt', detail = '$det', date_paid = '$datepaid' WHERE pay_id = '$id'");
			$subjSql->execute();
	
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Payment modified', '$id', 'payment', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */
			
			header("Location: index.php?view=modify_payment&id=$id&error=Saved successfully");	
				
						
?>