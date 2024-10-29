<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
		
	$numberv = mysqli_real_escape_string($link, $_GET['n']);	
	
					
		/* Insert Customer */
		$sql = $conn->prepare("UPDATE bs_user SET van_number = '$numberv' WHERE user_id = '$userId'");
		$sql->execute();
		/* End Customer */
			
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('User van updated', '$numberv - $userId', 'user', '$userId', NOW())");
		$log->execute();
		/* End Log */

	header('Location: ../index.php');
		
				

?>