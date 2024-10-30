<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
		
	$tn = mysqli_real_escape_string($link, $_POST['tn']);
	$rnd = mysqli_real_escape_string($link, $_POST['rnd']);
	$slm = mysqli_real_escape_string($link, $_POST['slm']);
	$dis = mysqli_real_escape_string($link, $_POST['dis']);
	$trip = mysqli_real_escape_string($link, $_POST['trip']);
	
			/* Insert Data */
			$sql = $conn->prepare("INSERT INTO tr_loading (truckname, i_round, i_slim, i_dispenser, trip_no, date_added)
						VALUES ('$tn', '$rnd', '$slm', '$dis', '$trip', '$today_date1')");
			$sql->execute();
			/* End Data */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Truck loading added', '$tn', 'truck loading', '$userId', NOW())");
			$log->execute();
			/* End Log */

		header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
		

?>