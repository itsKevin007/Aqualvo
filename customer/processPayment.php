<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];
	$o = $_POST['o'];
	$soan = mysqli_real_escape_string($link, $_POST['soan']);
	$or = mysqli_real_escape_string($link, $_POST['or']);
	$amt = mysqli_real_escape_string($link, $_POST['amt']);
	$det = mysqli_real_escape_string($link, $_POST['det']);
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$datepaid = date("Y-m-d", strtotime($from));
	
		/* Update data */
		if(isset($_POST['dr']))
		{
			foreach($_POST['dr'] as $subj)
			{ 
				
				$up = $conn->prepare("UPDATE tr_transaction SET is_paid = '1' WHERE tr_id = '$subj' AND cust_id = '$id'");
				$up->execute();
								
			}
		}
			/* End Data */
			
			$subjSql = $conn->prepare("INSERT INTO tr_payment (soa_number, or_number, cust_id, amount_paid, detail, date_paid, date_time_added) 
							VALUES ('$soan', '$or', '$id', '$amt', '$det', '$datepaid', '$today_date1')");
			$subjSql->execute();
	
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Payment added', '$id', 'payment', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */
			
			header("Location: index.php?view=add_payment&id=$id&o=$o&error=Saved successfully");	
				
						
?>